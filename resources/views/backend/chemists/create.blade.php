@extends('backend.theme.formtheme')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Chemist</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Chemist</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Add New Chemist Detail</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                class="fas fa-times"></i></button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!!Form::open(['files'=>true,'class'=>'form-horizontal'])!!}

                            <div class="form-group{{ $errors->has('chemist_name') ? ' has-error' : '' }}">
                                <label for="chemist_name">chemist_name</label>
                                <input id="chemist_name" type="text" class="form-control" name="chemist_name"
                                    value="{{ old('chemist_name') }}" required autofocus>
                                @if ($errors->has('chemist_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('chemist_name') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('contact_person') ? ' has-error' : '' }}">
                                <label for="contact_person">contact_person</label>
                                <input id="contact_person" type="text" class="form-control" name="contact_person"
                                    value="{{ old('contact_person') }}" required autofocus>
                                @if ($errors->has('contact_person'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('contact_person') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                                <label for="code">Description</label>

                                <input id="code" type="text" class="form-control" name="code" value="{{ old('code') }}"
                                    required autofocus>
                                @if ($errors->has('code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('drug_license_no') ? ' has-error' : '' }}">
                                <label for="drug_license_no">Valid Date</label>
                                <div class="col-md-3">
                                    <input id="drug_license_no" type="date" class="form-control" name="drug_license_no"
                                        value="{{ old('drug_license_no') }}" required autofocus>
                                    @if ($errors->has('drug_license_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('drug_license_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-9"></div>
                            </div>

                            <div class="form-group{{ $errors->has('mobile') ? ' has-error' : 'mobile' }}">
                                <label for="mobile">mobile</label>

                                <input id="user_id" class="form-control" type="text" name="mobile"
                                    value="{{ old('mobile') }}" required autofocus>
                                @if ($errors->has('mobile'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mobile') }}</strong>
                                </span>
                                @endif
                            </div>


                            <div class="form-group{{ $errors->has('password') ? ' has-error' : 'password' }}">
                                <label for="password">Password</label>

                                <input id="password" class="form-control" type="password" name="password" required
                                    autofocus>
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div
                                class="form-group{{ $errors->has('password-confirm') ? ' has-error' : 'password-confirm' }}">
                                <label for="password-confirm">password-confirm</label>

                                <input id="password-confirm" class="form-control" type="password"
                                    name="password-confirm" required autofocus>
                                @if ($errors->has('password-confirm'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password-confirm') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('geolocation') ? ' has-error' : '' }}">
                                <label for="geolocation">geolocation</label>

                                <input id="geolocation" class="form-control" type="text" name="geolocation"
                                    value="{{ old('geolocation') }}" required autofocus>
                                @if ($errors->has('geolocation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('geolocation') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label for="address">address</label>
                                <input id="cancellation_condition" type="text" class="form-control" name="address"
                                    value="{{ old('address') }}" required autofocus>
                                @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                <label for="state">state</label>
                                <input id="state" type="text" class="form-control" name="state"
                                    value="{{ old('state') }}" required autofocus>
                                @if ($errors->has('state'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('state') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                <label for="city">city</label>
                                <input id="cancellation_condition" type="text" class="form-control" name="city"
                                    value="{{ old('city') }}" required autofocus>
                                @if ($errors->has('city'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('pin') ? ' has-error' : 'pin' }}">
                                <label for="pin">pin</label>
                                <input id="pin" type="text" class="form-control" name="pin" value="{{ old('pin') }}"
                                    required autofocus>
                                @if ($errors->has('pin'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('pin') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                            {!!Form::close()!!}
                        </div>
                        <!-- /.col -->

                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- /.row -->
                </div>

            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection