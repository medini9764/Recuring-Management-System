<?php

namespace App\Http\Controllers;

use DB;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;


class StcFormController extends Controller
{

    function __construct()
    {
        $this->client = new Client(
            [
                //'base_uri' => "https://commtoken.webxpay.com/v1/api/",
                'base_uri' => Config::get('key_values.tokenize_url'),
                'timeout' => 100.0,
                'verify' => false
            ]
        );
    }
    public function loadOnetimePaymentForm($id){
        return view('welcome', ['id' => $id]);
    }
    public function submitForm(Request $request)
    {
        $random = 'ACS' . self::generateRandomString();
        $old_amount = $request->amount;
        $new_amount = $old_amount*100 / (100 - 2.6694);

        if (Auth::check()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = null;
        }
        //	dd($user_id);
        DB::table('stc_form')->insert(
            [
                'Name' => $request->name,
                'contact_no' => $request->contact_no,
                'email' => $request->email,
                'batch' => $request->batch,
                'comment' => $request->comment,
                'donor_category' => $request->category_id,
                'payment_type' => 1,
                'user_id' => $user_id,
                'bank_charge' => $new_amount - $old_amount,
                'paid_amount' => $old_amount,
                'amount' => $new_amount,
                'order_id' => $random,
                'date_of_payment' => date('Y-m-d'),
            ]
        );

        $Name = $request->name;
        $contact_no = $request->contact_no;
        $email = $request->email;
        $batch = $request->batch;
        $payment_type = $request->payment_type;
        $project = $request->project;
        $amount = number_format((float)$new_amount, 2, '.', '');
        //dd(Config::get('key_values.public_key');
        $publickey = base64_decode(Config::get('key_values.public_key'));
        $url =Config::get('key_values.webx_url');
        $plaintext = $random.'|'.$amount;
        openssl_public_encrypt($plaintext, $encrypt, $publickey);
        $secret_key=Config::get('key_values.secret_key');
        $payment = base64_encode($encrypt);
        //dd($payment);
        return view('payment',
            compact('Name', 'contact_no', 'email', 'batch','comment', 'payment_type', 'amount', 'random','publickey','payment','url','secret_key'));
    }

    function generateRandomString($length = 15)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    function responseForm(Request $request)
    {
        $publickey = base64_decode(Config::get('key_values.public_key'));
        $payment = base64_decode($request ["payment"]);
        $signature = base64_decode($request ["signature"]);
        $custom_fields = base64_decode($request ["custom_fields"]);
//load public key for signature matching
        openssl_public_decrypt($signature, $value, $publickey);

        $responseVariables = explode('|', $payment);



        $details = DB::table('stc_form')->where('order_id', $responseVariables[0])->first();
        if ($responseVariables[3] == "15") {
            DB::table('stc_form')
                ->where('id', $details->id)
                ->update([
                    'payment_status' => 0,
                    'transection_id' => $responseVariables[1],
                ]);
            return view('sorry');

        } else {
            DB::table('stc_form')
                ->where('id', $details->id)
                ->update([
                    'payment_status' => 1,
                    'transection_id' => $responseVariables[1],
                ]);

            $data_export=array(
                'paid_date'=> date('Y-m-d'),
                'order_number'=>$details->	order_id,
                'webxpay_order_number'=> $responseVariables[1],
                "email" => $details->email,
                "name" => $details->Name,
                "amount" =>$details->amount,
            );

            $sms_message = 'Thank you for your donation!, ';
            $sms_message .= 'Your order number is ' . $details->	order_id.' and ' ;
            $sms_message .= 'amount is '.  $details->paid_amount.'.';
            $sms_message .= 'Your generosity is greatly appreciated and will make a significant impact. ' ;
            $contact_no = $details->contact_no;
            $this->sendMessage($contact_no, $sms_message);

            Mail::send('invoice.send_invoice', compact('data_export'), function ($message) use ($data_export) {
                $message->to($data_export['email'], $data_export['name'])
                    ->cc(['medinilakmali910@gmail.com'])
                    ->bcc(['medinilakmali910@gmail.com'])
                    ->subject('GRAND MOSQUE COLOMBO');
                $message->from('medinilakmali910@gmail.com','GRAND MOSQUE COLOMBO');
            });

            return view('thank_you');
        }
    }


    public function showPaymentForm()
    {
        return view('payment_form');
    }

    public function showPaymentFormRecurring()
    {
        return view('payment_form_recurring');
    }

    public function submitStcFormRecurring(Request $request)
    {
        //dd($request);
        $random = 'ACS_' . uniqid();
        $old_amount = $request->amount;
        $new_amount = $old_amount*100 / (100 - 2.6694);
        $save_data = DB::table('recurring_payments')->insertGetId(
            [
                'user_id' => Auth::user()->id,
                //	'project' => $request->project,
                'payment_type' => "recurring",
                'amount' => $new_amount,
                'bank_charge' => $new_amount - $old_amount,
                'paid_amount' => $old_amount,
                'card_type' => $request->card_type,
                'donor_category' => $request->donor_category,
                'comment' => $request->comment,
                'recurring_period_days' => 30,
                'paid_date' => date('Y-m-d'),


                //'last_six_digits_of_amex' => $request->amex_card_digit,
                //'nic_no' => $request->nic_no,
            ]
        );

        if ($save_data) {
            return $save_data;
        } else {
            return 0;
        }
    }


    function generateToken()
    {
      //  $data = array("username" => "stc", "password" => "^!RnL)j5^lHO");
        $data = array("username" => Config::get('key_values.user_name'), "password" =>"M9SZKS)7A2J#");
   
        $response = $this->client->request(
            'POST',
            "auth",
            [
                'headers' => ['content-type' => 'application/json', 'Accept' => 'application/json'],
                'body' => json_encode($data)
            ]
        );
      

        try {
            $response = json_decode((string)$response->getBody());

            if (isset($response->token)) {
                return $response->token;
            }

            return null;
        } catch (\Throwable $th) {
            return $response;
        }
    }

    function getSessionData()
    {
        $user_details = Auth::user();
        $token = self::generateToken();

        $data = array("customer" => array("id" => $user_details->id, "email" => $user_details->email));


        $response = $this->client->request(
            'POST',
            "cards",
            [
                'headers' => [
                    'content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer $token"
                ],
                'body' => json_encode($data)
            ]
        );

        $response = json_decode((string)$response->getBody());


        return $response;


    }

    function saveCardData(Request $request)
    {
        $user_details = Auth::user();
        $token = self::generateToken();
        $data = array("customer" => array("id" => $user_details->id, "email" => $user_details->email));
        $response = $this->client->request(
            'POST',
            "cards",
            [
                'headers' => [
                    'content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer $token"
                ],
                'body' => json_encode($data)
            ]
        );
        $response = json_decode((string)$response->getBody());
        if (sizeof($response) > 0) {


            return response()->json(['error' => false]);
        } else {

            //dd($request);
            $user_details = Auth::user();
            $token = self::generateToken();
            $data = array(
                "session" => $request->session_id,
                "currency" => "LKR",
                "bankMID" => Config::get('key_values.bank_mid'),
                "customer" => array(
                    "id" => $user_details->id,
                    "email" => $user_details->email,
                    "firstName" => $user_details->name,
                    "lastName" => $user_details->name,
                    "contactNumber" => $user_details->contact_no,
                    "addressLineOne" => "sample line1",
                    "city" => "colombo",
                    "postalCode" => "78151",
                    "country" => "srilanka"
                ),
            );

            $response = $this->client->request(
                'POST',
                "cards/save",
                [
                    'headers' => [
                        'content-type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => "Bearer $token"
                    ],
                    'body' => json_encode($data)
                ]
            );

            $response = json_decode((string)$response->getBody());

            $encode_out = json_encode($response);

            return $encode_out;
        }

    }


    function saveAmexCard(Request $request)
    {
        $save_data = DB::table('recurring_payments')
            ->where('id', $request->order_id)
            ->update([
                'nic_no' => $request->nic_no,
                'last_six_digits_of_amex' => $request->amex_card_digit,
            ]);

        if ($save_data) {
            return $save_data;
        } else {
            return 0;
        }
    }


    public function payFromCard(Request $request)
    {

        $user_details = Auth::user();
        //$session = $request->session();

        $token = self::generateToken();
        $card_details = self::getSessionData();
        if (!empty($card_details)) {
            $order_id = "ASC_" . uniqid();
            DB::table('recurring_payments')
                ->where('id', $request->form_id)
                ->update([
                    'paid_date' => date('Y-m-d'),
                ]);
            DB::table('visa_payments')->insert(
                [
                    'form_id' => $request->form_id,
                    'unique_id' => $order_id,
                    'payment_date' => date('Y-m-d'),
                ]
            );
            $amount_detail = DB::table('recurring_payments')
                ->where('id', $request->form_id)
                ->first();


            $card_first = $card_details[0]->cardFirst;
            $card_last = $card_details[0]->cardLast;

            $orderNumber = rand(0, 10000);

            $amount = number_format((float)$amount_detail->amount, 2, '.', '');
            $data =
                array(
                    "amount" => $amount,
                    "cardLast" => $card_last,
                    "cardFirst" => $card_first,
                    "orderNumber" => $orderNumber,
                    "currency" => "LKR",

                    "customer" => array(
                        "email" => $user_details->email,
                        "id" => $user_details->id,
                    )
                );
            $response = $this->client->request(
                'POST',
                "cards/pay",
                [
                    'headers' => [
                        'content-type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => "Bearer $token"
                    ],
                    'body' => json_encode($data)
                ]
            );

            $response = json_decode((string)$response->getBody());
            $data_export=array(
               'paid_date'=> date('Y-m-d'),
               'order_number'=>$order_id,
               'webxpay_order_number'=>$response->receipt,
               "email" => $user_details->email,
               "name" => $user_details->name,
               "amount" =>$amount,
            );
            $message = 'Thank you for your donation!, ';
            $message  .= 'Your order number is ' . $order_id.' and ' ;
            $message  .= 'amount is  '.  $amount.',';
            $message  .= 'Your generosity is greatly appreciated and will make a significant impact. ' ;
            $phoneNumber = $user_details->contact_no;
            $this->sendMessage($phoneNumber, $message);
        
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
            Mail::send('invoice.send_invoice', compact('data_export'), function ($message) use ($data_export) {
                $message->to($data_export['email'], $data_export['name'])
                    ->cc(['medinilakmali910@gmail.com'])
                    ->bcc(['medinilakmali910@gmail.com'])
                    ->subject('GRAND MOSQUE COLOMBO');
                $message->from('medinilakmali910@gmail.com','GRAND MOSQUE COLOMBO');
            });
            
            $new_response = json_encode($response);
            return $new_response;

        }


    }

    public function sendMessage($phoneNumber, $message)
    {
        $message = urlencode($message);
        $phoneNumber = preg_replace('/\D+/', '', $phoneNumber);
        if (isset($phoneNumber[0])) {
            $firstNumber = $phoneNumber[0];

            if ($firstNumber == '7') {
                $phoneNumber = '0' . $phoneNumber;
            }

            if (strlen($phoneNumber) == 10) {
                $url = "https://sms.textware.lk:5001/sms/send_sms.php?username=webxpay&password=Web85xpy&src=WEBXPAY&dst=$phoneNumber&msg=$message&dr=1";
                $ch = curl_init();
            
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
                curl_exec($ch);

                curl_close($ch);
            
                return $ch;
            }
        } else {
            return FALSE;
        }
    }

    function listCard()
    {
        $user_details = Auth::user();
        $token = self::generateToken();
        $data = array("customer" => array("id" => $user_details->id, "email" => $user_details->email));
        $response = $this->client->request(
            'POST',
            "cards",
            [
                'headers' => [
                    'content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer $token"
                ],
                'body' => json_encode($data)
            ]
        );

        $response = json_decode((string)$response->getBody());

        return view('card_list', compact('response'));
    }


    function deleteCard(Request $request)
    {
        $user_details = Auth::user();
        //$session = $request->session();
        $token = self::generateToken();
        //$card_details=self::getSessionData();

        $card_first = $request->card_first;
        $card_last = $request->card_last;
        $card_id = $request->card_id;


        $data =
            array(
                "cardLast" => $card_last,
                "cardFirst" => $card_first,
                "cardId" => $card_id,
                "customerEmail" => $user_details->email,
                "customerId" => $user_details->id
            );

        $response = $this->client->request(
            'DELETE',
            "cards",
            [
                'headers' => [
                    'content-type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer $token"
                ],
                'body' => json_encode($data)
            ]
        );

        $response = json_decode((string)$response->getBody());

        $new_response = json_encode($response);

        return $new_response;


    }

}
