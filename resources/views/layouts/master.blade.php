<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>GRANDMOSQUECOLOMBO</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/mosque.jpg')}}">

    @include('layouts.styles')

    @yield('styles')


</head>

<body data-topbar="colored">

<!-- Begin page -->
<div id="layout-wrapper">

     @include('layouts.top_bar')
     @include('layouts.left_nav')


    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">

           @yield('content')
        </div>
        <!-- End Page-content -->
        @include('layouts.footer')
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->


@include('layouts.scripts')
@yield('scripts')

</body>
</html>