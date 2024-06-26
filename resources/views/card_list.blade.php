<?php
/**
 * Created by PhpStorm.
 * User: yugan
 * Date: 1/19/2019
 * Time: 5:16 PM
 */?>
@extends('layouts.master')
@section('styles')
    <!-- DataTables -->
    <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/sweetalert2.min.css')}}" rel="stylesheet"/>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title">{{ __('views.card_list') }}</h4>
                    <p class="card-title-desc">
                    </p>

                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>

                            <th>Card Number</th>
                            <th></th>

                        </tr>
                        </thead>


                        <tbody>
                        @foreach($response as $card_list)
                            <tr>

                                <td>{{$card_list->cardFirst}}**{{$card_list->cardLast}}</td>
                                <td><button class="btn btn-danger" id="deleteBut" data-cardFirst="{{$card_list->cardFirst}}" data-cardLast="{{$card_list->cardLast}}" data-cardId="{{$card_list->cardId}}">Delete</button></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
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

    <script src="{{asset('js/sweetalert2.min.js')}}"></script>
    <!-- Datatable init js -->
    <script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>

    <script>

        $('#deleteBut').on('click',function () {

            let card_first=$(this).attr('data-cardFirst');
            let card_last=$(this).attr('data-cardLast');
            let card_id=$(this).attr('data-cardId');
            console.log(card_last+' '+card_first );

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover the data again",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!"
            }).then(
                function () {
                    $.ajax({
                        url: "{{url('delete_card')}}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {"card_first": card_first,"card_last":card_last,"card_id":card_id},
                        dataType: 'json',
                        cache: false,
                        success: function (response, textStatus, jqXHR) {

                            swal("Deleted!", "Your data has been deleted!", "success");
                            location.reload();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {

                        }
                    });

                },
                function () {
                    return false;
                });

        });
    </script>

@endsection