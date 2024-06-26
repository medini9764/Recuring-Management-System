<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);

        .email-signup-thankyou {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            background: #333;
            padding: 10%;
        }
        .content {
            margin: auto; /* Magic! */
            max-width: 700px;
            color: #333;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.55), 0 3px 6px rgba(0, 0, 0, 0.23);
            background: url('https://www.crafta.co.il/images/paper-plane.gif') no-repeat #fff;
            background-position: right 5px bottom 5px;
            background-size: 10em;
            text-align: center;
            position: relative;
            padding: 10%;
            border-radius: 5px;
        }

        .left-hole,.right-hole{
            position: absolute;
            width:20px; height:20px;
            background:#333;
            border-radius:50%;
            top:15px;
        }
        .left-hole{
            left:15px;
            top:10px;
        }
        .right-hole{
            right:15px;
            top:10px;
        }
        h2,h3{
            text-align:left;
            padding:5% 5% 0% 3%;
            color:#333;
            font-weight:900;
        }
        .main-content> h1 {
            color:#333;
            text-transform:uppercase;
            margin-top:-2%;
            font-size:2.5em;
            font-weight:900;
        }



    </style>
</head>
<body>
<div class="header-custom email-signup-thankyou">
    <div class="content">
        <div class="left-hole"></div>
        <div class="right-hole"></div>
        <div class="main-content">

            <h1>{{ __('views.payment_successful') }}</h1>
            <!-- <img style="height:300px;width:auto" src="https://fund.oasc.lk/img/crest-01.png"> -->
            <p style="text-align:left">  {{ __('views.addressed') }}<br/> <br/>
            {{ __('views.thank_you_message') }} <br/> <br/></p>

            <h3><a style="text-decoration: none" href="{{url('/')}}" class="lead" ><strong>{{ __('views.back_to_main_page') }}</strong> </a></h3>

        </div>

    </div>
</div>
</body>
</html>
