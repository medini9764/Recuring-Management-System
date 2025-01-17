@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('contact_no') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Contact No</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="contact_no" value="{{ old('contact_no') }}" required>

                                @if ($errors->has('contact_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('contact_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- <div class="form-group{{ $errors->has('donor_category') ? ' has-error' : '' }}">
                            <label for="example-text-input control-label" class="col-md-4 control-label">Donor Category/Type<sup
                                        style="color: red">*</sup></label>
                            <div class="col-md-6">
                                <select id="donor_category" name="donor_category" class="form-control" required>
                                    <option value="">--Select--</option>
                                    <option value="Monthly Sandha">Monthly Sandha</option>
                                </select>

                                @if ($errors->has('doner_category'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('doner_category') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> -->
                        <!-- <div class="form-group{{ $errors->has('batch') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Batch</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="batch" value="{{ old('batch') }}" >

                            </div>
                        </div> -->



                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" style="background-color:#1b5e3e;border-color: #1b5e3e;">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
