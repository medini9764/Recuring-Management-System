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
    <!-- <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.3/dist/sweetalert2.min.css" rel="stylesheet"> -->
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Category/Project</h4>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">Add New Category</button>
                    </div>
                    <p class="card-title-desc">
                    </p>

                    <table id="datatable"  class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>

                            <th>No</th>
                            <th>Category Id</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>


                        <tbody>
                        @foreach($datas as $data)
                            <tr>

                                <td>{{$data->id}}</td>
                                <td>{{$data->id}}</td>
                                <td>{{$data->name}}</td>
                                <td>{{$data->description}}</td>
                                <td><button type="button" class="btn btn-warning edit-category" data-id="{{$data->id}}" data-name="{{$data->name}}" data-description="{{$data->description}}" data-toggle="modal" data-target="#editCategoryModal">Edit</button></td>
                               
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

        <!-- Modal -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm" action="{{url('submit_category_form')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="category_name">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" required>
                        </div>
                        <div class="form-group">
                            <label for="category_description">Category Description</label>
                            <textarea class="form-control" id="category_description" name="category_description" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="submitCategoryFormButton" form="addCategoryForm" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm" action="{{ url('editCategory') }}" method="post">
                        @csrf
                        <input type="hidden" id="edit_category_id" name="category_id">
                        <div class="form-group">
                            <label for="edit_category_name">Category Name</label>
                            <input type="text" class="form-control" id="edit_category_name" name="category_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_category_description">Category Description</label>
                            <textarea class="form-control" id="edit_category_description" name="category_description" required></textarea>
                        </div>
                        <button type="button" id="submitEditCategoryFormButton" class="btn btn-primary">Submit</button>
                    </form>
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

    <script src="{{asset('js/sweetalert2.min.js')}}"></script>
    <!-- Datatable init js -->
    <script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>

    <!-- SweetAlert JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.3/dist/sweetalert2.min.js"></script> -->

    <!-- AJAX form submission with SweetAlert notification -->
    <script>
        $(document).ready(function() {
    $('#submitCategoryFormButton').on('click', function(event) {
        event.preventDefault();

        var formData = {
            '_token': $('input[name=_token]').val(),
            'category_name': $('#category_name').val(),
            'category_description': $('#category_description').val()
        };

        $.ajax({
            url: $('#addCategoryForm').attr('action'),
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#addCategoryModal').modal('hide');
                if(response.success) {
                    swal("Success!", "Your data has been successfully added new category!", "success");
                } else {
                    swal("Failed !", "There was an issue adding the category!", "error");
                }
                // Optionally, you could also refresh the table or add the new row to the table dynamically here.
            },
            error: function(response) {
                swal("Failed !", "There was an issue adding the category!", "error");
            }
        });
    });
});

$(document).on('click', '.edit-category', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var description = $(this).data('description');

        $('#edit_category_id').val(id);
        $('#edit_category_name').val(name);
        $('#edit_category_description').val(description);
});

    </script>
@endsection