@extends('layouts.master')


@section('content')
    <?php
        $user_details=Auth::user();

    ?>


    <form class="form-horizontal" id="stc_form" action="{{url('submit_stc_form')}}" method="post" >

        <fieldset>

            <!-- Form Name -->


            <legend style="color: #505d69;padding: 15px 15px 15px 0px;"> {{ __('views.one_time_donation_form') }}</legend>


        {{csrf_field()}}
        <!-- Text input-->

            <div class="form-group row">
                <label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.name') }}<sup style="color: red">*</sup></label>
                <div class="col-md-10">
                    <input id="name" name="name" type="text" placeholder="Name" class="form-control input-md" required="" value="{{$user_details->name}}">
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group row">
                <label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.contact_no') }}<sup style="color: red">*</sup></label>
                <div class="col-md-10">
                    <input id="contact_no" name="contact_no" type="text" placeholder="Contact No" class="form-control input-md" required="" value="{{$user_details->contact_no}}">
                </div>
            </div>
            <!-- Text input-->
            <div class="form-group row">
                <label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.email') }}<sup style="color: red">*</sup></label>
                <div class="col-md-10">
                    <input id="email" name="email" type="email" placeholder="E-Mail" class="form-control input-md" required="" value="{{$user_details->email}}">
                </div>
            </div>

            <div class="form-group row">
                <label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.donor_category') }}<sup
                            style="color: red">*</sup></label>
                <div class="col-md-10">
                    <select id="donor_category" name="donor_category" class="form-control">
                        <option value="">--Select--</option>
                        <option @if($user_details->donor_category=="Mosque Construction") selected @endif value="Mosque Construction">{{ __('views.mosque_construction') }}</option>
                        <option @if($user_details->donor_category=="Electricity Bill") selected @endif value="Electricity Bill">{{ __('views.electricity_bill') }}</option>
                        <option @if($user_details->donor_category=="Water Bill") selected @endif value="Water Bill">{{ __('views.water_bill') }}</option>
                        <option @if($user_details->donor_category=="Sadaka") selected @endif value="Sadaka">{{ __('views.sadaka') }}</option>
                        <option @if($user_details->donor_category=="Other") selected @endif   value="Other">{{ __('views.other') }}</option>
                    </select>
                </div>
            </div>


            <!-- Text input-->
            <!-- <div class="form-group row">
                <label for="example-text-input control-label" class="col-md-2 col-form-label">Batch<sup style="color: red"></sup></label>
                <div class="col-md-10">
                    <input id="batch" name="batch" type="text" placeholder="Batch" class="form-control input-md" value="{{$user_details->batch}}" readonly>
                </div>
            </div> -->

            <!-- Text input-->
            <div class="form-group row">
                <label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.comment') }}<sup style="color: red"></sup></label>
                <div class="col-md-10">
                    <input id="comment" name="comment" type="text" placeholder="Comment" class="form-control input-md" value="{{$user_details->comment}}" >
                </div>
            </div>


            <div class="form-group row">
                <label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.amount') }}<sup style="color: red">*</sup></label>
                <div class="col-md-10">
                    <input id="amount" name="amount" type="text" placeholder="" class="form-control input-md" required="">
                    <p style="font-size: 14px;color: #b91616; padding: 20px 0px 20px 0; font-weight: 600;">Convenience fee of 2.6% will get charged to the card on top of the committed amount</p>
                    <p style="font-size: 16px; color: #505d69;"><strong>Total :</strong><span id="total_cost"></span> </p>
                </div>
            </div>
            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="singlebutton"></label>
                <div class="col-md-4">
                    <button type="submit" id="singlebutton" name="singlebutton" class="btn btn-primary" style="text-align: right;">{{ __('views.submit') }}</button>
                </div>
            </div>


        </fieldset>
    </form>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js"></script>

    <script>

        $('#amount').keyup(function () {

            let price=$(this).val();
            let price_with_tax = parseInt(price)*100 / (100 - 2.6694);

            if (isNaN(price_with_tax)){
                $('#total_cost').html(' Rs. '+0.00);
            }else{
                $('#total_cost').html(' Rs. '+ parseFloat(price_with_tax, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
            }
        });

        jQuery("#stc_form").validate({

            rules: {
                name:{
                    required:true
                },
                contact_no:{
                    required: true,
                    number:true,
                    minlength: 9


                },
                email:{
                    required: true
                },

                batch:{
                    required: true
                },
                payment_type:{
                    required: true
                },
                amount:{
                    required: true,
                    number: true,
                    min:1000
                }
            },

            messages: {

            },

            submitHandler: function () {

// start loaders
                var forms = $("#stc_form");



                jQuery.ajax({
                    url: forms.attr('action'),
                    type: forms.attr('method'),
                    data:  form.serialize(),
                    dataType: 'json',
                    cache: false,
                    success: function (response) {


// location.reload();

                    }
                });
            }
        });
    </script>
    @endsection