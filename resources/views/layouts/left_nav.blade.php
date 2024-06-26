
<!-- ========== Left Sidebar Start ========== -->

<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">{{ __('views.payments') }}</li>
    @if(Auth::user()->role==0)
                {{--<li>
                    <a href="{{url('home')}}" class="waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="uim uim-airplay"></i></div><span class="badge badge-pill badge-success float-right"></span>
                        <span>Dashboard</span>
                    </a>
                </li>--}}

                <li>
                    <a href="{{url('payment_form')}}" class=" waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-credit-card"></i></div>
                        <span>{{ __('views.one_time_donation') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{url('payment_form_recurring')}}" class=" waves-effect">
                        <div class="d-inline-block icons-sm mr-1"><i class="fas fa-credit-card"></i></div>
                        <span>{{ __('views.recurring_donation') }}</span>
                    </a>
                </li>

                    <li class="menu-title">{{ __('views.transaction_report') }}</li>

                    <li>
                        <a href="{{url('customer_payments_one_time')}}" class=" waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-file-export"></i></div>
                            <span>{{ __('views.one_time_report') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('customer_payments_recurrent')}}" class=" waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-file-export"></i></div>
                            <span>{{ __('views.recurring_report') }}</span>
                        </a>
                    </li>


                    <li class="menu-title">{{ __('views.delete_card') }}</li>
                    <li>
                        <a href="{{url('/list_card')}}" class=" waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-minus-circle"></i></div>
                            <span>{{ __('views.delete_saved_card') }}</span>
                        </a>
                    </li>



    @else
                  {{--  <li>
                        <a href="{{url('home')}}" class="waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="uim uim-airplay"></i></div><span class="badge badge-pill badge-success float-right"></span>
                            <span>Dashboard</span>
                        </a>
                    </li>--}}
                    <li>
                        <a href="{{url('amex_users')}}" class="waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="uim uim-airplay"></i></div><span class="badge badge-pill badge-success float-right"></span>
                            <span>{{ __('views.amex_users') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('visa_users')}}" class="waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="uim uim-airplay"></i></div><span class="badge badge-pill badge-success float-right"></span>
                            <span>{{ __('views.visa_users') }}</span>
                        </a>
                    </li>


                    <li>
                        <a href="{{url('one_time_payment')}}" class="waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="uim uim-airplay"></i></div><span class="badge badge-pill badge-success float-right"></span>
                            <span>{{ __('views.one_time_payment') }}</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{url('category')}}" class="waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="uim uim-airplay"></i></div><span class="badge badge-pill badge-success float-right"></span>
                            <span>Category?Project</span>
                        </a>
                    </li>



     @endif
            </ul>
        
        </div>
        <!-- Sidebar -->
        <!-- Sidebar Footer -->
        <!-- <div class="container-fluid fixed-bottom text-center p-0" > -->
            <div class="navbar-brand-box">
                <div class="row">
                    <div class="col-sm-12">
                        <a href="https://webxpay.co" class="logo logo-dark">
                            <span class="logo-lg">
                                    <img src="{{asset('img/logofooter.png')}}" alt="" style="display: inline; margin: 0 auto; padding: 0px;">
                            </span>
                        </a>
                    </div>
                </div>
                <div class="row justify-content-center" >
                    <div class="col-sm-3">
                        <a href="https://www.instagram.com/webxpay" class="logo logo-dark">
                            <span class="logo-lg">
                                <img src="{{asset('img/instagram 2.svg')}}" class="transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-sm-3">
                        <a href="https://www.linkedin.com/company/webxpay" class="logo logo-dark">
                            <span class="logo-lg">
                                <img src="{{asset('img/linkedin 2.svg')}}" class="transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110" alt="">
                            </span>
                        </a>
                    </div>
                    <div class="col-sm-3">
                        <a href="https://www.facebook.com/webxpay" class="logo logo-dark">
                            <span class="logo-lg">
                                <img src="{{asset('img/facebook 2.svg')}}" class="transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110" alt="">
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        <!-- </div> -->
        <!-- Sidebar Footer End-->
       
    </div>
</div>
<!-- Left Sidebar End -->
