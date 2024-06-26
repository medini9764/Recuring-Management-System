<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id=Auth::user()->id;
        
        if(Auth::user()->role==1){
            $one_time_sum=DB::table('stc_form')
			->where('payment_status',1)
			->sum('amount');

            $recurring_payment_sum=DB::table('recurring_payments')
			->join('users','recurring_payments.user_id','=','users.id')
			->join('visa_payments','visa_payments.form_id','=','recurring_payments.id')
			->join('webx_pay_refs','webx_pay_refs.order_id','=','visa_payments.unique_id')
			->where('recurring_payments.card_type','Visa')
			->sum('amount');
        }else{
            $one_time_sum=DB::table('stc_form')
			->where('user_id',$user_id)
			->where('payment_status',1)
			->sum('amount');

            $recurring_payment_sum=DB::table('recurring_payments')
			->join('users','recurring_payments.user_id','=','users.id')
			->join('visa_payments','visa_payments.form_id','=','recurring_payments.id')
			->join('webx_pay_refs','webx_pay_refs.order_id','=','visa_payments.unique_id')
			->where('recurring_payments.card_type','Visa')
			->where('user_id',$user_id)
			->sum('amount');
        }
        

        $currentMonth = now()->month;
        $currentYear = now()->year;
        if(Auth::user()->role==1){
            $recurring_payments = DB::table('recurring_payments')
            ->join('users', 'recurring_payments.user_id', '=', 'users.id')
            ->join('visa_payments', 'visa_payments.form_id', '=', 'recurring_payments.id')
            ->join('webx_pay_refs', 'webx_pay_refs.order_id', '=', 'visa_payments.unique_id')
            ->where('recurring_payments.card_type', 'Visa')
            ->whereMonth('recurring_payments.paid_date', $currentMonth)
            ->whereYear('recurring_payments.paid_date', $currentYear)
            ->get();

            $one_time_payments = DB::table('stc_form')
            ->where('payment_status', 1)
            ->whereMonth('date_of_payment', $currentMonth)
            ->whereYear('date_of_payment', $currentYear)
            ->get();
        }else{
            $recurring_payments = DB::table('recurring_payments')
            ->join('users', 'recurring_payments.user_id', '=', 'users.id')
            ->join('visa_payments', 'visa_payments.form_id', '=', 'recurring_payments.id')
            ->join('webx_pay_refs', 'webx_pay_refs.order_id', '=', 'visa_payments.unique_id')
            ->where('recurring_payments.card_type', 'Visa')
            ->where('user_id', $user_id)
            ->whereMonth('recurring_payments.paid_date', $currentMonth)
            ->whereYear('recurring_payments.paid_date', $currentYear)
            ->get();
        
        $one_time_payments = DB::table('stc_form')
            ->where('user_id', $user_id)
            ->where('payment_status', 1)
            ->whereMonth('date_of_payment', $currentMonth)
            ->whereYear('date_of_payment', $currentYear)
            ->get();
        }
        
        
        // Merge the results into a single array
        $payments = $recurring_payments->merge($one_time_payments);
        
        // Sort the merged array by paid date
        $payments = $payments->sortBy('paid_date')->take(10);

        $total_payment['one_time']=$one_time_sum;
        $total_payment['recurring_payment']=$recurring_payment_sum;

        return view('home',compact('total_payment','payments'));
    }

    public function lang(){
        return Redirect::back();
    }
}
