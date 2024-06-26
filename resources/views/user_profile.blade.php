@extends('layouts.master')
@section('styles')

    <link href="{{asset('css/sweetalert2.min.css')}}" rel="stylesheet"/>
    <style>
        .customSwalBtn1{
            background-color: rgba(255, 195, 0,1.00);
            border-left-color: rgba(214,130,47,1.00);
            border-right-color: rgba(214,130,47,1.00);
            border: 0;
            border-radius: 3px;
            box-shadow: none;
            color: #fff;
            cursor: pointer;
            font-size: 17px;
            font-weight: 500;
            margin: 30px 5px 0px 5px;
            padding: 10px 32px;
        }
    </style>
@endsection

@section('content')
<?php
$user_details=Auth::user();

?>


<form class="form-horizontal" id="user_form" action="{{url('user_profile_update')}}" method="post" >

	<!-- <fieldset> -->

		<!-- Form Name -->


		<legend style="color: #505d69;padding: 15px 15px 15px 0px;">{{ __('views.user_management') }}</legend>


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
			<label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.email') }}<sup style="color: red">*</sup></label>
			<div class="col-md-10">
                <input id="email" name="email" type="email" placeholder="E-Mail" class="form-control input-md" required="" value="{{$user_details->email}}">
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
		<!-- <div class="form-group row">
			<label for="example-text-input control-label" class="col-md-2 col-form-label">Batch<sup style="color: red">*</sup></label>
			<div class="col-md-10">
				<input id="batch" name="batch" type="text" placeholder="Batch" class="form-control input-md" value="{{$user_details->batch}}">
			</div>
		</div> -->

		<div class="form-group row">
			<label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.enter_new_password') }}<sup style="color: red">*</sup></label>
			<div class="col-md-10">
				<input id="password" name="password" type="password" placeholder="Password" class="form-control input-md" value="">
			</div>
		</div>

		<div class="form-group row">
			<label for="example-text-input control-label" class="col-md-2 col-form-label">{{ __('views.confirm_password') }}<sup style="color: red">*</sup></label>
			<div class="col-md-10">
				<input id="confirm_password" name="confirm_password" type="password" placeholder="Confirm password" class="form-control input-md" value="">
			</div>
		</div>

		<!-- Select Basic -->
		<div class="form-group">
			<label class="col-md-4 control-label" for="singlebutton"></label>
			<div class="col-md-4">
				<button type="submit" id="singlebutton" name="singlebutton" class="btn btn-primary" style="text-align: right">{{ __('views.submit') }}</button>
			</div>
		</div>


	<!-- </fieldset> -->
</form>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js"></script>
<script src="{{asset('js/sweetalert2.min.js')}}"></script>

<script>



    jQuery("#user_form").validate({



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

            password : {
                minlength : 6
            },
            confirm_password : {
                minlength : 6,
                equalTo : "#password"
            }

        },

        messages: {

        },

        submitHandler: function () {

// start loaders
            var forms = $("#user_form");
            console.log(forms.serialize());

            jQuery.ajax({
                url: forms.attr('action'),
                type: forms.attr('method'),
                data:  forms.serialize(),
                dataType: 'json',
                cache: false,
                success: function (response) {

                    $(document).on('click', '.SwalBtn1', function() {

                        swal.close();

                        location.reload();
                    });

                    swal({
                        title: 'Success',
                        type: "success",
                        html: "Profile Updated Successfully" +
                            "<br>" +
                            '<button type="button" role="button" tabindex="0" class="SwalBtn1 customSwalBtn1">' + 'Ok' + '</button>'  ,
                        showCancelButton: false,
                        showConfirmButton: false
                    });




// location.reload();

                }
            });
        }
    });
</script>
@endsection