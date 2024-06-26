<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>GRAND MOSQUE COLOMBO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesdesign" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/mosque.jpg')}}">

    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css"/>

</head>

<body class="">
{{--<div class="home-btn d-none d-sm-block">
    <a href="index.html"><i class="mdi mdi-home-variant h2 text-white"></i></a>
</div>--}}

<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mb-5">
                    <a href="https://fund.oasc.lk" class="logo"><span class="logo-lg">

                                    <img src="{{asset('img/mosque.jpg')}}" alt="" style="height: 200px;display: inline; margin: 0 auto; padding: 0px;">
                                </span></a>
                    <h5 class="font-size-16 text-white-50 mb-4">GRAND MOSQUE COLOMBO</h5>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row justify-content-center">
            <div class="col-xl-5 col-sm-8">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="p-2">
                            <h5 class="mb-5 text-center">Sign In</h5>
                            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-custom mb-4 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <input id="username" type="email" class="form-control" name="email"
                                                   value="{{ old('email') }}" required>
                                            <label for="username">E-Mail Address</label>
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                            @endif
                                        </div>

                                        <div class="form-groupform-group{{ $errors->has('password') ? ' has-error' : '' }} form-group-custom mb-4">
                                            <input type="password" class="form-control" id="userpassword" name="password" required>
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                            @endif
                                            <label for="userpassword">Password</label>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="custom-control custom-checkbox">

                                                        <input class="custom-control-input"
                                                               id="customControlInline" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>

                                                    <label class="custom-control-label" for="customControlInline">Remember
                                                        me</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="text-md-right mt-3 mt-md-0">
                                                    <a href="{{ route('password.request') }}" class="text-muted"><i
                                                                class="mdi mdi-lock"></i> Forgot your password?</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary btn-block waves-effect waves-light" style="background-color:#1b5e3e;border-color: #1b5e3e;">
                                                Log In
                                            </button>
                                        </div>
                                        <div class="mt-4 text-center">
                                            <a href="{{ route('register') }}" class="text-muted"><i
                                                        class="mdi mdi-account-circle mr-1"></i> Registration for Recurring Payments</a>
                                        </div>
                                        <div class="mt-4 text-center">
                                            <a href="{{ url('one_time_pay/1') }}" class="text-muted"><i
                                                        class="fas fa-credit-card mr-1"></i>One Time Payment</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
</div>
<!-- end Account pages -->

<!-- JAVASCRIPT -->
<script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

<script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>

<script src="{{asset('assets/js/app.js')}}"></script>

</body>
</html>
