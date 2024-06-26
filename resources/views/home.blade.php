@extends('layouts.master')
@section('styles')
    <!-- DataTables -->
    <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <style>
        .btn-group{
            display:none;
        }
    </style>
@endsection
@section('content')

    <h1>Dashboard</h1>
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body text-center h-100">
                <div class="row g-0">
                    <div class="col-md-7 d-flex flex-column align-items-center justify-content-center">
                        <!-- <div id="logoPreview" style="max-width: 200px; margin-top: 10px;">
                            <img id="previewImage" src="{{ asset('storage/' . Auth::user()->image ) }}" alt="Logo Preview" style="max-width: 100%; height: auto;">
                        </div> -->
                        <div class="d-flex justify-content-center align-items-center" style="float: left;width:  228px;height: 221px;object-fit: cover;">
                            @if(Auth::user()->image)
                            <img src="{{ asset('storage/' . Auth::user()->image ) }}" class="img-fluid rounded-start " alt="Header Avatar" style="height:150px;width:150px;">
                            @else
                            <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" class="img-fluid rounded-start " alt="Header Avatar" style="">
                            @endif
                        </div>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-5">
                            <h5 class="card-title">{{Auth::user()->name}}</h5>
                            <p class="card-text">{{Auth::user()->email}}</p>
                            <p class="card-text">{{Auth::user()->contact_no}}</p>
                            @if(!Auth::user()->image)
                            <form action="{{ url('upload_image') }}" method="post" enctype="multipart/form-data" id="update_profile">
                                @csrf
                                <label for="profile_picture" class="btn btn-primary"  >Add Profile Picture</label>
                                <input id="profile_picture" type="file" name="image" style="display: none;" onchange="this.form.submit()">
                            </form>
                            @else
                            <form action="{{ url('upload_image') }}" method="post" enctype="multipart/form-data" id="update_profile">
                                @csrf
                                <label for="profile_picture" class="btn btn-primary" >Update Profile Picture</label>
                                <input id="profile_picture" type="file" name="image" style="display: none;" onchange="this.form.submit()">
                            </form>
                            @endif
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 ">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">One Time Donations</h5>
                    <!-- <div class="row">
                        <div class="col-sm-5"> -->
                            <img src="{{asset('img/one-time1.png')}}" class="img-fluid rounded-start " alt="Header Avatar" style="height:75px;wight:75px;" >
                        <!-- </div>
                        <div class="col-sm-7"> -->
                            <p>Total Donations</p>
                            @if($total_payment['one_time'])
                            <p class="card-text">Rs. {{number_format($total_payment['one_time'],2)}}</p>
                            @else
                            <p class="card-text">Rs. 0.00</p>
                            @endif
                            @if(Auth::user()->role==0)
                                <a href="{{url('payment_form')}}" class="btn btn-primary" style="background-color: #1b5e3e;border-color:#1b5e3e;">Add Donation</a>
                            @endif
                            
                        <!-- </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card ">
                <div class="card-body text-center">
                    <h5 class="card-title">Recuring Donations</h5>
                    <!-- <div class="row">
                        <div class="col-md-5"> -->
                            <img src="{{asset('img/recurring.png')}}" class="img-fluid rounded-start " alt="Header Avatar" style="height:75px;wight:75px;"  >
                        <!-- </div>
                        <div class="col-md-7"> -->
                            <p>Total Donations</p>
                            @if($total_payment['recurring_payment'])
                            <p class="card-text">Rs. {{number_format($total_payment['recurring_payment'], 2)}}</p>
                            @else
                            <p class="card-text">Rs. 0.00</p>
                            @endif
                            @if(Auth::user()->role==0)
                                <a href="{{url('payment_form_recurring')}}" class="btn btn-primary" >Add Donation</a>
                            @endif
                            
                        <!-- </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <p>Click below button to see the Recent  Transactions</p>
                    <button class="btn btn-primary mb-2" onclick="displayText()" >Recent Transactions</button>
                    <div id="textField" style="display: none;">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">Order Id</th>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Paid Date</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{$payment->order_id}}</td>
                                    <td>@if($payment->payment_type=='recurring')
                                        {{$payment->receipt}}
                                        @else
                                        {{$payment->transection_id}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($payment->payment_type=='recurring')
                                        {{date('d-m-Y',strtotime($payment->paid_date))}}
                                        @else
                                        {{date('d-m-Y',strtotime($payment->date_of_payment))}}
                                    </td>
                                    @endif
                                    <td>Rs. {{number_format($payment->amount, 2)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Required datatable js -->
    <script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Buttons examples -->
    <script src="{{asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
    <!-- Responsive examples -->
    <script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

    <!-- Datatable init js -->
    <script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>
    <script>
        var num=0;
        function displayText() {
            var text = document.getElementById("textField");
            text.style.display = "block";
            if(num==0){
                num=1
            }else{
                text.style.display = "none"; 
                num=0
            }
        }
    </script>
    
@endsection