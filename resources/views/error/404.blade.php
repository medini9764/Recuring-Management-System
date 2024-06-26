<?php
/**
 * Created by PhpStorm.
 * User: yugan
 * Date: 1/19/2019
 * Time: 5:16 PM
 */?>
@extends('layouts.master')


@section('content')
    <h1>You don't have permission</h1>
    <a href="{{url('/payment_form_recurring')}}">Return To Dashboard</a>
@endsection
