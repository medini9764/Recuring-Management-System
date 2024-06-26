<?php

namespace App\Http\Controllers;

use DB;
use Log;
use function GuzzleHttp\Promise\queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;


class TestController extends Controller
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'pay:recursive';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send Recursive payments of customers';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

		$this->client = new Client(
			[
				'base_uri' => Config::get('key_values.tokenize_url'),
				'timeout'  => 100.0,
				'verify' => false
			]
		);
	}

	function generateToken(){

        $data = array("username" => Config::get('key_values.user_name'), "password" =>Config::get('key_values.password'));

		$response = $this->client->request(
			'POST',
			"auth",
			[
				'headers'  => ['content-type' => 'application/json', 'Accept' => 'application/json'],
				'body' => json_encode($data)
			]
		);

		try {
			$response = json_decode((string) $response->getBody());

			if (isset($response->token)) {
				return $response->token;
			}

			return null;
		} catch (\Throwable $th) {
			return $response;
		}
	}

	function getSessionData($email,$user_id){
		$token=self::generateToken();

		$data =  array( "customer" => array("id" => $user_id, "email" =>$email ));


		$response = $this->client->request(
			'POST',
			"cards",
			[
				'headers'  => ['content-type' => 'application/json', 'Accept' => 'application/json', 'Authorization' => "Bearer $token"],
				'body' => json_encode($data)
			]
		);

		$response = json_decode((string) $response->getBody());


		return $response;


	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{


        Log::info('User failed to login.');
		$visa_payments=DB::table('recurring_payments')
			->select('recurring_payments.*','recurring_payments.*','users.*','users.id as user_id','recurring_payments.id as form_id')
			//->join('recurring_payments','visa_payments.form_id','=','recurring_payments.id')
			->join('users','users.id','=','recurring_payments.user_id')
			->where('card_type','Visa')

			->get();


        try {

            foreach ($visa_payments as $visa_payment) {
                $date = date('Y-m-d');
                $date1 = date_create($visa_payment->paid_date);
                $date2 = date_create($date);
                $diff = date_diff($date1, $date2);

                $date_payment = (int)$diff->format("%R%a");


                if ($date_payment == $visa_payment->recurring_period_days) {
                    $token = self::generateToken();

                    $card_details = self::getSessionData($visa_payment->email, $visa_payment->user_id);

                    if (!empty($card_details)) {
                        $order_id = "STC_" . uniqid();
                        DB::table('recurring_payments')
                            ->where('id', $visa_payment->form_id)
                            ->update([
                                'paid_date' => date('Y-m-d'),

                            ]);
                        DB::table('visa_payments')->insert(
                            [
                                'form_id' => $visa_payment->form_id,
                                'unique_id' => $order_id,
                                'payment_date' => date('Y-m-d'),
                            ]
                        );


                        $card_first = $card_details[0]->cardFirst;
                        $card_last = $card_details[0]->cardLast;

                        $orderNumber = rand(0, 10000);
                        $amount = number_format((float)$visa_payment->amount, 2, '.', '');
                        $data =
                            array(
                                "amount" => $amount,
                                "cardLast" => $card_last,
                                "cardFirst" => $card_first,
                                "orderNumber" => $orderNumber,
                                "currency" => "LKR",

                                "customer" => array(
                                    "email" => $visa_payment->email,
                                    "id" => $visa_payment->user_id,
                                )
                            );
                        $response = $this->client->request(
                            'POST',
                            "cards/pay",
                            [
                                'headers' => ['content-type' => 'application/json',
                                    'Accept' => 'application/json',
                                    'Authorization' => "Bearer $token"],
                                'body' => json_encode($data)
                            ]
                        );

                        $response = json_decode((string)$response->getBody());

                        DB::table('webx_pay_refs')->insert(
                            [
                                'order_id' => $order_id,
                                'status' => isset($response->success) ? $response->success : '',
                                'receipt' => isset($response->receipt) ? $response->receipt : '',
                                'merchantProvidedOrderNumber' => isset($response->merchantProvidedOrderNumber) ? $response->merchantProvidedOrderNumber : '',
                                'otherResponse' => json_encode($response),
                            ]
                        );
                        //dd($response);


                    }else{
                        echo PHP_EOL."card details not found";
                    }
                }

            }

        } catch (\Exception $e) {

            return $e->getMessage();
        }


	}


}
