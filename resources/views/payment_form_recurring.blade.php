@extends('layouts.master')
@section('styles')
    <style>
        .modal-img {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(255, 255, 255, .8) url('http://i.stack.imgur.com/FhHRx.gif') 50% 50% no-repeat;
        }
        .modal-img-one {
            display: none;
            position: absolute;
            top: 46%;
            z-index: 1001;
            left: 34%;
            font-size: 18px;
        }
        /* When the body has the loading class, we turn
           the scrollbar off with overflow:hidden */
        body.loading .modal-img-one{
            overflow: hidden;
        }

        /* Anytime the body has the loading class, our
           modal element will be visible */
        body.loading .modal-img-one{
            display: block;
        }

        /* When the body has the loading class, we turn
       the scrollbar off with overflow:hidden */
        body.loading .modal-img {
            overflow: hidden;
        }

        /* Anytime the body has the loading class, our
           modal element will be visible */
        body.loading .modal-img {
            display: block;
        }
    </style>
@endsection

@section('content')
	<?php
	$user_details = Auth::user();

	?>
    <p class="modal-img-one"> {{ __('views.refresh_message') }}</p>

    <form class="form-horizontal" id="stc_form" action="{{url('submit_stc_form_recurring')}}" method="post">

        <fieldset>

            <!-- Form Name -->


            <legend style="color: #505d69;padding: 15px 15px 15px 0px;">{{ __('views.recurring_donation_form') }}</legend>


        {{csrf_field()}}
        <!-- Text input-->
            <div id="stc_main_form">
                <div class="form-group row">
                    <label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.name') }}<sup
                                style="color: red">*</sup></label>
                    <div class="col-md-10">
                        <input id="name" name="name" type="text" placeholder="Name" class="form-control input-md"
                               required="" value="{{$user_details->name}}">
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group row">
                    <label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.contact_no') }}<sup
                                style="color: red">*</sup></label>
                    <div class="col-md-10">
                        <input id="contact_no" name="contact_no" type="text" placeholder="Contact No"
                               class="form-control input-md" required="" value="{{$user_details->contact_no}}">
                    </div>
                </div>
                <!-- Text input-->
                <div class="form-group row">
                    <label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.email') }}<sup
                                style="color: red">*</sup></label>
                    <div class="col-md-10">
                        <input id="email" name="email" type="email" placeholder="E-Mail" class="form-control input-md"
                               required="" value="{{$user_details->email}}">
                    </div>
                </div>

                <!-- Text input-->


                <div class="form-group row">
                    <label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.donor_category') }}<sup
                                style="color: red"></sup></label>
                    <div class="col-md-10">
                        <select id="donor_category" name="donor_category" class="form-control">
                            <option value="">--Select--</option>
                            <option @if($user_details->donor_category=="Monthly Sandha") selected @endif value="Monthly Sandha">{{ __('views.monthly_sandha') }}</option>
                            <option @if($user_details->donor_category=="Other") selected @endif   value="Other">{{ __('views.other') }}</option>
                        </select>
                        <!-- <input id="donor_type" name="donor_type" type="text" placeholder="Donor Type" class="form-control input-md"
                               value="{{$user_details->donor_category!==null?$user_details->donor_category:'Not available'}}" readonly> -->
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label for="example-text-input control-label" class="col-md-2 col-form-label">Batch<sup
                                style="color: red"></sup></label>
                    <div class="col-md-10">
                        <input id="batch" name="batch" type="text" placeholder="Batch" class="form-control input-md"
                               value="{{$user_details->batch}}">
                    </div>
                </div> -->
                <!-- Text input-->
            {{-- <div class="form-group row">
                 <label for="example-text-input control-label" class="col-md-2 col-form-label">Project</label>
                 <div class="col-md-10">
                     <input id="project" name="project" type="text" placeholder="Project"
                            class="form-control input-md">
                 </div>
             </div>--}}

            <!-- Select Basic -->

                <!-- <div class="form-group row">
                    <label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.recurring_period') }}<sup
                                style="color: red">*</sup></label>
                    <div class="col-md-10">
                        <select id="recurring_period_days" name="recurring_period_days" class="form-control">
                            <option value="">--Select--</option>
                            <option value="30">{{ __('views.monthly') }}</option>
                        </select>
                    </div>
                </div> -->

                <div class="form-group row">
                    <label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.card_type') }}<sup
                                style="color: red">*</sup></label>
                    <div class="col-md-10">
                        <select id="card_type" name="card_type" class="form-control">
                            <option value="">--Select--</option>
                            <option value="Amex">Amex</option>
                            <option value="Visa">Visa/Master</option>
                        </select>
                    </div>
                </div>
                 <!-- Text input-->
                 <div class="form-group row">
                    <label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.comment') }}<sup
                                style="color: red"></sup></label>
                    <div class="col-md-10">
                        <input id="comment" name="comment" type="text" placeholder="Comment" class="form-control input-md"
                               value="{{$user_details->comment}}">
                    </div>
                </div>

                <!-- Text input-->

                <div class="form-group row">
                    <label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.amount') }}<sup
                                style="color: red">*</sup></label>
                    <div class="col-md-10">
                        <input id="amount" name="amount" type="text" placeholder="" class="form-control input-md"
                               required="">
                        <p style="font-size: 14px;color: #b91616; font-weight: 600; margin: 0 auto;padding: 20px 0px 20px 0;">Convenience fee of 2.6% will get charged to the card on top of the committed amount</p>
                        <p style="font-size: 16px;color: rgb(255, 0, 0);padding: 15px 0px;margin: 0 auto;padding-bottom: 25px; font-weight: 600;text-transform: uppercase;display: none" id="amex_message">Amex cards issued on Sri-lanka only will be accepted</p>
                        <p style="font-size: 16px; color: #505d69;"><strong>Total :</strong><span id="total_cost"></span>
                        </p>
                    </div>
                </div>
            
                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="next_button"></label>
                    <div class="col-md-4">
                        <button type="submit" id="next_button" name="next_button" class="btn btn-primary"
                                style="text-align: right;">{{ __('views.next') }}
                        </button>
                    </div>
                </div>

            </div>
        </fieldset>
    </form>

    <div id="card_group" style="display: none;">
        <div id="amex_group" style="display: none;">
            <form id="amex_detail">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Amex Credit Card Payment</h4>
                                <p class="card-title-desc"></p>
                                <div class="form-group row">
                                    <label for="example-text-input control-label" class="col-md-2 col-form-label">Last
                                        6
                                        digits of your Amex Credit Card<sup
                                                style="color: red">*</sup></label>
                                    <div class="col-md-10">
                                        <input id="amex_card_digit" name="amex_card_digit" type="number"
                                               placeholder="Enter Credit Card Number" class="form-control input-md">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input control-label" class="col-md-2 col-form-label">NIC
                                        No.<sup
                                                style="color: red">*</sup></label>
                                    <div class="col-md-10">
                                        <input id="nic_no" name="nic_no" type="text" placeholder="NIC No."
                                               class="form-control input-md">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div id="visa_group" style="display: none;">
            <input type="hidden" id="orderId" name="orderId" value="">
            <div class="row">
                <div class="col-xl-12">
                    <!-- <div class="card">
                        <div class="card-body"> -->
                            <h4 class="header-title">Visa / Master Card Payment</h4>
                            <p class="card-title-desc">Please enter your credit card information. </p>

                            <div class="table-responsive">
                                {{--<table class="table mb-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>Card Number</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">113213 123213 12321 123</th>
                                        <td>
                                            <button type="button" id="select_card" name="select_card"
                                                    class="btn btn-primary" style="text-align: right;">Select Card
                                            </button>
                                            <button type="button" id="delete_card" name="delete_card"
                                                    class="btn btn-danger" style="text-align: right;">Delete Card
                                            </button>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>--}}
                            </div>

                        </div>


                        <div class="new-card-wrapper p-3">
                            <div class="form-group">
                                <label>{{ __('views.card_number') }}<sup style="color: red">*</sup>:</label>
                                <input type="text" id="card-number" class="form-control" title="card number"
                                       readonly/>
                                <span class="text-danger card-number-error err"></span>
                            </div>
                            <div class="form-group">
                                <label for="">{{ __('views.expiry_month') }}<sup style="color: red">*</sup>:
                                    <small>(MM)</small>
                                </label>
                                <input type="text" id="expiry-month" class="form-control" title="expiry month"
                                       readonly/>
                                <span class="text-danger exp-month-error err"></span>
                            </div>
                            <div class="form-group">
                                <label for="">{{ __('views.expiry_year') }}<sup style="color: red">*</sup>:
                                    <small>(YY)</small>
                                </label>
                                <input type="text" id="expiry-year" class="form-control" title="expiry year"
                                       readonly/>
                                <span class="text-danger exp-year-error err"></span>
                            </div>
                            <div class="form-group">
                                <label for="">{{ __('views.security_code') }}<sup style="color: red">*</sup>:</label>
                                <input type="text" id="security-code" class="form-control" title="security code"
                                       readonly/>
                                <span class="text-danger cvv-error err"></span>
                            </div>
                            <div class="form-group">
                                <label for="">{{ __('views.cardholder_name') }}<sup style="color: red">*</sup>:</label>
                                <input type="text" id="cardholder-name" class="form-control"
                                       title="card-holder name" readonly/>
                                <span class="text-danger card-holder-error err"></span>
                            </div>

                            <div class="general-error text-danger">

                            </div>
                            <div class="mt-5 text-right">
                                <div class="p-2 rounded no-gutters bg-light row align-items-end justify-content-end">
                                    {{--<div class="col-auto">
                                        <a href="#/" class="btn btn-secondary" id="save-card-button">Save</a>
                                    </div>--}}
                                    <div class="col-auto">
                                        <div class="">
                                            {{--    <div class="col-12">
                                                    <p class="text-info p-2 mb-0">Amount: 100 RS</p>
                                                </div>--}}
                                            {{-- <div class="col-12">
                                                 <a href="#" class="btn btn-primary" id="pay-from-card-button">Pay from session</a>
                                             </div>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <!-- </div>


                    </div> -->
                </div>

            </div>
        </div>
        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="singlebutton"></label>
            <div class="col-md-4">
                <button type="button" id="save-card-button" name="save-card-button" class="btn btn-primary"
                        style="text-align: righ; " >{{ __('views.submit') }}
                </button>
                <button type="button" id="singlebutton" name="singlebutton" class="btn btn-primary"
                        style="text-align: right;">{{ __('views.submit') }}
                </button>
            </div>
        </div>

    </div>

    <div class="modal-img"><!-- Place at bottom of page --></div>
@endsection
@include('recurring_form_script')