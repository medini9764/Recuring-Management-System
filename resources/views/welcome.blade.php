<html lang="en">
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <meta charset="UTF-8">
    <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{asset('assets/images/mosque2.jpg')}}">
    <title>GRAND MOSQUE COLOMBO</title>

    <style type="text/css">
        body{
            background-color: #1b5e3e;
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .background-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom right, rgba(27, 94, 62, 0.8), rgba(102, 187, 106, 0.8)), url('{{asset('assets/images/mosque2.png')}}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -1;
        }

        .container {
            z-index: 1;
        }

        a {
            color: #ffff !important;
        }

        legend{
            color: #fff;
            text-align: center !important;
            padding: 10px !important;
            width: 60% !important;
            margin: 5px auto 25px;
        }

        p.back {
            font-size: 14px !important;
            color: #fff !important;
            text-align: right;
            cursor: pointer;
        }

        label#name-error,
        label#contact_no-error,
        label#email-error,
        label#batch-error,
        label#amount-error {
            font-size: 13px;
            padding: 10px 0px;
            color: #ffff; 
        }
        
        footer.footer {
            background: #f7f7f7;
            padding: 25px 0px;
            margin: 0 auto;
        }
        
        .Powerdby {
            text-align: center;
        }
        
        .ft-image {
            width: 240px;
        }

        @media only screen and (max-width: 767px){
            legend {
                width: 80% !important;
            }
        }

    </style>
</head>
<body>

    <div class="background-overlay"></div>

    <div class="container">
        <div class="header clearfix">
            <nav>
                <ul class="nav nav-pills float-right">
                    <li class="nav-item"></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"></li>
                </ul>
            </nav>
        </div>
<!-- 
        <div class="jumbotron"> -->
            <form class="form-horizontal" id="stc_form" action="{{url('submit_stc_form')}}" method="post">
                <fieldset>
                    <!-- Form Name -->
                    <legend style="color: #fff;padding: 15px 15px 15px 0px;">One Time Donation Form{{$id}}</legend>
                    <div class="col-xs-12">
                        <p class="back"><a href="{{url('/')}}">< Back</a></p>
                    </div>
                    {{csrf_field()}}
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="name" style="font-size: 16px; color: #fff;">Name<sup style="color: red">*</sup></label>
                        <div class="col-md-4">
                            <input id="name" name="name" type="text" placeholder="" class="form-control input-md" required="">
                        </div>
                    </div>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="contact_no" style="font-size: 16px; color: #fff;">Contact No<sup style="color: red">*</sup></label>
                        <div class="col-md-4">
                            <input id="contact_no" name="contact_no" type="text" placeholder="" class="form-control input-md" required="">
                        </div>
                    </div>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="email" style="font-size: 16px; color: #fff;">E-Mail<sup style="color: red">*</sup></label>
                        <div class="col-md-4">
                            <input id="email" name="email" type="email" placeholder="" class="form-control input-md" required="">
                        </div>
                    </div>
                    <input id="category_id" name="category_id" type="hidden" value="{{$id}}">
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="amount" style="font-size: 16px; color: #fff;">Amount<sup style="color: red">*</sup></label>
                        <div class="col-md-4">
                            <input id="amount" name="amount" type="text" placeholder="" class="form-control input-md" required="">
                            <p style="font-size: 14px; color: #fff; padding: 15px 0px;">Convenience fee of 2.6% will get charged to the card on top of the committed amount</p>
                            <p style="font-size: 16px; color: #fff;"><strong>Total :</strong><span id="total_cost"></span></p>
                        </div>
                    </div>
                    <!-- Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="singlebutton"></label>
                        <div class="col-md-4">
                            <button type="submit" id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        <!-- </div> -->
    </div>

</body>
</html>

<!-- Latest compiled and minified JavaScript -->

<script src="https://code.jquery.com/jquery-1.12.4.min.js"
integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js"></script>

<script>

    $('#amount').keyup(function () {
        let price=$(this).val();

      //  let price_with_tax=parseInt(price)+parseInt(price)*0.03092;
        let price_with_tax = parseInt(price)*100 / (100 - 2.6694);
        if (isNaN(price_with_tax)){
            $('#total_cost').html(' Rs. '+0.00);
        }else{
            $('#total_cost').html(' Rs. '+parseFloat(price_with_tax, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
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

            donor_category:{
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


var form = $(this);

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


