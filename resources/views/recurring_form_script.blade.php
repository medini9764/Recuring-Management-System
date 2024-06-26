@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/require.js/2.3.6/require.min.js"></script>
    <script src="{{asset('js/env.js')}}"></script>
    <!-- PREVENT CLICK-JACKING -->
    <style id="antiClickjack">
        body {
            display: none !important;
        }
    </style>
    <script type="text/javascript">
        if (self === top) {
            var antiClickjack = document.getElementById("antiClickjack");
            antiClickjack.parentNode.removeChild(antiClickjack);
        } else {
            top.location = self.location;
        }
    </script>

    <script src="{{asset('js/webxpay.hostedsession.js')}}"></script>


    <script>

        $body = $("body");

        $(document).on({
            ajaxStart: function() { $body.addClass("loading");    },
            ajaxStop: function() { $body.removeClass("loading"); }
        });

        let url = "{{url('/')}}";
        let type = '';

        WebxpayTokenizeInit({
            card: {
                number: "#card-number",
                securityCode: "#security-code",
                expiryMonth: "#expiry-month",
                expiryYear: "#expiry-year",
                nameOnCard: "#cardholder-name",
            },
            ready: afterInit,
            credentials: {
                id: window.env.merchantId,
                version: '63'
            }
        });

        function afterInit(GenerateSession) {
            // save card
            $('#save-card-button').click(function () {
                $('#save-card-button').attr('disabled', true);

                GenerateSession(
                    function (session) {

                        $.ajax({
                            url: "{{url('save_card_data')}}",
                            type: 'POST',
                            headers: {
                                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {"session_id": session},
                            dataType: 'json',
                            cache: false,
                            success: function (data, textStatus, jqXHR) {

                                let form_id = $('#orderId').val();
                                console.log(data.error);

                                if(data.error==true)
                                {
                                    let url = "{{url('/sorry_recurring')}}";
                                    window.location = url;
                            }else{
                                    $.ajax({
                                        url: "{{url('pay_from_card')}}",
                                        type: 'POST',
                                        headers: {
                                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        data: {"form_id": form_id},
                                        dataType: 'json',
                                        cache: false,
                                        success: function (response, textStatus, jqXHR) {

                                            if (response.success == true) {
                                                let url = "{{url('/thank_you_recurring')}}";
                                                window.location = url;
                                            }
                                        },
                                        error: function (jqXHR, textStatus, errorThrown) {

                                        }
                                    });

                                }

                            },
                            error: function (jqXHR, textStatus, errorThrown) {

                            }
                        });


                        $(this).removeAttr("disabled");


                        //window.location.href = "?session=" + session;
                    },
                    function (error) {
                        handleErrors(error);
                    }
                );
            });

            // pay from session
         /*   $('#pay-from-card-button').click(function () {
                $('#pay-from-card-button').attr('disabled', true);

                GenerateSession(
                    function (session) {

                        $(this).removeAttr("disabled");
                        window.location.href = "?sessionpay=" + session;
                    },
                    function (error) {
                        handleErrors(error);
                    }
                );
            });*/
        }

        function handleErrors(error) {
            $('button').removeAttr('disabled');

            $('.err').html('');
            $('.general-error').html('');

            switch (error.type) {
                case 'fields_in_error': {
                    if (error.details.cardNumber) {
                        if (error.details.cardNumber == 'missing') {
                            $('.card-number-error').html('Enter valid card number');
                        }
                        if (error.details.cardNumber == 'invalid') {
                            $('.card-number-error').html('Invalid card number');
                        }
                    }
                    if (error.details.expiryMonth) {
                        if (error.details.expiryMonth == 'missing') {
                            $('.exp-month-error').html('Enter expiration month');
                        }
                        if (error.details.expiryMonth == 'invalid') {
                            $('.exp-month-error').html('Invalid expiration month');
                        }
                    }
                    if (error.details.expiryYear) {
                        if (error.details.expiryYear == 'missing') {
                            $('.exp-year-error').html('Enter expiration year');
                        }
                        if (error.details.expiryYear == 'invalid') {
                            $('.exp-month-error').html('Invalid expiration year');
                        }
                    }
                    if (error.details.securityCode) {
                        if (error.details.securityCode == 'missing') {
                            $('.cvv-error').html('Enter CVV');
                        }
                        if (error.details.securityCode == 'invalid') {
                            $('.cvv-error').html('Invalid CVV');
                        }
                    }
                    console.error('missing card details', error.details);
                    break;
                }
                case 'request_timeout': {
                    $('.general-error').html('<span class="text-decoration-uppercase">' + error.details + '</span>')
                    console.error('request time out', error.details);
                    break;
                }
                case 'system_error': {
                    if (error.details == 'cvv missing') {
                        $('.general-error').html('Enter CVV details');
                    } else {
                        $('.general-error').html(error.details);
                    }
                    console.error('system error', error.details);
                    break;
                }
            }
        }

        $('#amount').keyup(function () {

            let price = $(this).val();
            let price_with_tax = parseInt(price)*100 / (100 - 2.6694);
            if (isNaN(price_with_tax)) {
                $('#total_cost').html(' Rs. ' + 0.00);
            } else {
                $('#total_cost').html(' Rs. '+ parseFloat(price_with_tax, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
            }
        });

        jQuery("#stc_form").validate({


            rules: {
                name: {
                    required: true
                },
                contact_no: {
                    required: true,
                    number: true,
                    minlength: 9


                },
                recurring_period_days:{
                    required: true
                },
                email: {
                    required: true
                },

                batch: {
                    required: true
                },
                payment_type: {
                    required: true
                },
                amount: {
                    required: true,
                    number: true,
                    min:1000
                },
                card_type: {
                    required: true,
                },

            },

            messages: {},

            submitHandler: function () {



// start loaders
                var forms = $("#stc_form");


                jQuery.ajax({
                    url: forms.attr('action'),
                    type: forms.attr('method'),
                    data: forms.serialize(),
                    dataType: 'json',
                    cache: false,
                    success: function (response) {

                        $('#orderId').val(response);

                        $('#stc_main_form').fadeOut();
                        $('#card_group').fadeIn();



// location.reload();

                    }
                });
            }
        });

        $(document).ready(function () {
            $.ajax({
                url: "{{url('get_session_data')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function (session_id, textStatus, jqXHR) {


                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            });
        });

        $('#singlebutton').on('click',function () {
            $('.text-danger').remove();
                    let amex_card_digit= $('#amex_card_digit').val();
                    let nic_no= $('#nic_no').val();
                    let order_id = $('#orderId').val();
                    let valid=true;

                    let ids=['#amex_card_digit','#nic_no'];
                    let id_vals=[amex_card_digit,nic_no];
                    for(let i=0;i<id_vals.length;i++) {
                        if (id_vals[i] == "") {
                            $(ids[i]).closest('.form-group').addClass('has-error');
                            $(ids[i]).after('<p class="text-danger">This field is required</p>');
                            valid = false;
                        } else {
                            $(ids[i]).closest('.form-group').removeClass('has-error');
                            $(ids[i]).closest('.form-group').addClass('has-success');
                        }
                    }
                    if(amex_card_digit.length>6 || amex_card_digit.length<6){
                        $('#amex_card_digit').closest('.form-group').addClass('has-error');
                        $('#amex_card_digit').after('<p class="text-danger">Invalid Number Length</p>');
                        valid = false;
                    }else {
                        $('#amex_card_digit').closest('.form-group').removeClass('has-error');
                        $('#amex_card_digit').closest('.form-group').addClass('has-success');
                    }

                if (valid==true) {
                    $.ajax({
                        url: "{{url('save_amex_card')}}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {"order_id": order_id,"nic_no":nic_no,"amex_card_digit":amex_card_digit},
                        dataType: 'json',
                        cache: false,
                        success: function (session_id, textStatus, jqXHR) {
                            let url="{{url('/thank_you_recurring')}}";
                            window.location = url;
                        },
                        error: function (jqXHR, textStatus, errorThrown) {

                        }
                    });
                }

        });

        $('#card_type').on('change', function () {
            let card_type = $(this).val();
            if (card_type == "Amex") {
                $('#amex_group').show();
                $('#singlebutton').show();
                $('#amex_message').show();
            } else {
                $('#amex_group').hide();
                $('#singlebutton').hide();
                $('#amex_message').hide();
            }
            if (card_type == "Visa") {
                $('#visa_group').show();
                $('#save-card-button').show();
            } else {
                $('#visa_group').hide();
                $('#save-card-button').hide();

            }
        });
    </script>
@endsection