<header id="page-topbar">
    <div class="navbar-header" style="background-color:#1b5e3e;">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{url('/home')}}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{asset('img/mosque.jpg')}}" alt="" height="22">
                                </span>
                    <span class="logo-lg">
                                    <img src="{{asset('img/mosque.jpg')}}" alt="" style="height: 100px;display: inline; margin: 0 auto; padding: 0px;">
                                </span>
                </a>

                <a href="{{url('/home')}}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{asset('img/mosque.jpg')}}" alt="" height="22">
                                </span>
                    <span class="logo-lg">
                                    <img src="{{asset('img/mosque.jpg')}}" alt="" style="height: 100px;display: inline; margin: 0 auto; padding: 0px;">
                                </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-backburger"></i>
            </button>
           
            <!-- App Search-->

        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ml-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
    
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                     aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect">
                    <a class="text-white" href="{{url('en')}}">{{ __('views.english') }}</a>
                </button>
                <button type="button" class="btn header-item waves-effect">
                    <a class="text-white" href="{{url('ta')}}">{{ __('views.tamil') }}</a>
                </button>
            </div>


            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   
                    @if(Auth::user()->image)
                    <img class="rounded-circle header-profile-user" src="{{ asset('storage/' . Auth::user()->image ) }}" alt="Header Avatar">
                    @else
                    <img class="rounded-circle header-profile-user" src="{{asset('assets/images/users/avatar-1.jpg')}}" alt="Header Avatar">
                    @endif
                    <span class="d-none d-sm-inline-block ml-1">Welcome {{Auth::user()->name}}</span>
                    <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    {{--<a class="dropdown-item" href="#"><i class="mdi mdi-face-profile font-size-16 align-middle mr-1"></i> Profile</a>--}}
                    @if(Auth::user()->role==0)
                    <a class="dropdown-item" href="{{url('/list_card')}}"><i class="fas fa-minus-circle font-size-16 align-middle mr-1"></i> {{ __('views.delete_saved_card') }}</a>
                    @endif
                    <a class="dropdown-item" href="{{url('/user_profile')}}"><i class="fas fa-id-badge  font-size-16 align-middle mr-1"></i> {{ __('views.edit_profile') }}</a>
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout font-size-16 align-middle mr-1"></i> {{ __('views.logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>

        </div>
        
    </div>

</header>
