<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

	public function amexPayments()
	{
		$recurring_payments=DB::table('recurring_payments')
			->join('users','recurring_payments.user_id','=','users.id')
			->where('card_type','amex')->get();


		return view('reports.amex_report',compact('recurring_payments'));
	}

	public function visaPayments()
	{
		$recurring_payments=DB::table('recurring_payments')
			->join('users','recurring_payments.user_id','=','users.id')
			->join('visa_payments','visa_payments.form_id','=','recurring_payments.id')
			->join('webx_pay_refs','webx_pay_refs.order_id','=','visa_payments.unique_id')
			->where('card_type','visa')->get();


		return view('reports.visa_report',compact('recurring_payments'));
	}

	public function showPaymentsRecurrent()
	{
		$user_id=Auth::user()->id;


		$recurring_payments=DB::table('recurring_payments')
			->join('users','recurring_payments.user_id','=','users.id')
			->join('visa_payments','visa_payments.form_id','=','recurring_payments.id')
			->join('webx_pay_refs','webx_pay_refs.order_id','=','visa_payments.unique_id')
			->where('recurring_payments.card_type','Visa')
			->where('user_id',$user_id)
			->get();

		return view('reports.visa_report',compact('recurring_payments'));
	}

	public function showPaymentOneTime()
	{
		$user_id=Auth::user()->id;


		$one_time_payments=DB::table('stc_form')
			->where('user_id',$user_id)
			->where('payment_status',1)
			->get();

		return view('reports.one_time_payments',compact('one_time_payments'));
	}

	public function oneTimePayment()
	{
		$one_time_payments=DB::table('stc_form')
			->where('payment_status',1)
			->get();


		return view('reports.one_time_payments',compact('one_time_payments'));
	}




}
