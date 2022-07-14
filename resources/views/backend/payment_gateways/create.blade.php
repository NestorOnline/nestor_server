@extends('backend.theme.formtheme')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Payment Gateway</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Payment Gateway</li>
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
                    <h3 class="card-title">Add New Payment Gateway Detail</h3>

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
                            {{csrf_field()}}
                            <div class="form-group{{ $errors->has('PaymentGateway_Code') ? ' has-error' : '' }}">
                                <label for="PaymentGateway_Code" class="control-label">Payment Gateway
                                    Code</label>
                                <div class="col-md-12">
                                    <input id="PaymentGateway_Code" type="text" class="form-control"
                                        name="PaymentGateway_Code" value="{{ old('PaymentGateway_Code') }}" required
                                        autofocus>
                                    @if ($errors->has('PaymentGateway_Code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('PaymentGateway_Code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('PaymentGateway_Name') ? ' has-error' : '' }}">
                                <label for="PaymentGateway_Name" class="control-label">PaymentGateway_Name</label>
                                <div class="col-md-12">
                                    <input id="PaymentGateway_Name" type="text" class="form-control"
                                        name="PaymentGateway_Name" value="{{ old('PaymentGateway_Name') }}" required
                                        autofocus>
                                    @if ($errors->has('PaymentGateway_Name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('PaymentGateway_Name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('PaymentGateway_MKey') ? ' has-error' : '' }}">
                                <label for="PaymentGateway_MKey" class="control-label">PaymentGateway_MKey</label>
                                <div class="col-md-12">
                                    <input id="PaymentGateway_MKey" type="text" class="form-control"
                                        name="PaymentGateway_MKey" value="{{ old('PaymentGateway_MKey') }}" required
                                        autofocus>
                                    @if ($errors->has('PaymentGateway_MKey'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('PaymentGateway_MKey') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('PaymentGateway_MId') ? ' has-error' : '' }}">
                                <label for="PaymentGateway_MId" class="control-label">PaymentGateway_MId</label>
                                <div class="col-md-12">
                                    <input id="PaymentGateway_MId" type="text" class="form-control"
                                        name="PaymentGateway_MId" value="{{ old('PaymentGateway_MId') }}" required
                                        autofocus>
                                    @if ($errors->has('PaymentGateway_MId'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('PaymentGateway_MId') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('PaymentGateway_MWebsite') ? ' has-error' : '' }}">
                                <label for="PaymentGateway_MWebsite"
                                    class="control-label">PaymentGateway_MWebsite</label>
                                <div class="col-md-12">
                                    <input id="PaymentGateway_MWebsite" type="text" class="form-control"
                                        name="PaymentGateway_MWebsite" value="{{ old('PaymentGateway_MWebsite') }}"
                                        required autofocus>
                                    @if ($errors->has('PaymentGateway_MWebsite'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('PaymentGateway_MWebsite') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('PaymentGateway_Channel') ? ' has-error' : '' }}">
                                <label for="PaymentGateway_Channel" class="control-label">PaymentGateway_Channel</label>
                                <div class="col-md-12">
                                    <input id="PaymentGateway_Channel" type="text" class="form-control"
                                        name="PaymentGateway_Channel" value="{{ old('PaymentGateway_Channel') }}"
                                        required autofocus>
                                    @if ($errors->has('PaymentGateway_Channel'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('PaymentGateway_Channel') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div
                                class="form-group{{ $errors->has('PaymentGateway_IndustryType') ? ' has-error' : '' }}">
                                <label for="PaymentGateway_IndustryType"
                                    class="control-label">PaymentGateway_IndustryType</label>
                                <div class="col-md-12">
                                    <input id="PaymentGateway_IndustryType" type="text" class="form-control"
                                        name="PaymentGateway_IndustryType"
                                        value="{{ old('PaymentGateway_IndustryType') }}" required autofocus>
                                    @if ($errors->has('PaymentGateway_IndustryType'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('PaymentGateway_IndustryType') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div
                                class="form-group{{ $errors->has('PaymentGateway_Callback_Url') ? ' has-error' : '' }}">
                                <label for="PaymentGateway_Callback_Url"
                                    class="control-label">PaymentGateway_Callback_Url</label>
                                <div class="col-md-12">
                                    <input id="PaymentGateway_Callback_Url" type="text" class="form-control"
                                        name="PaymentGateway_Callback_Url"
                                        value="{{ old('PaymentGateway_Callback_Url') }}" required autofocus>
                                    @if ($errors->has('PaymentGateway_Callback_Url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('PaymentGateway_Callback_Url') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('PaymentGateway_Mode') ? ' has-error' : '' }}">
                                <label for="PaymentGateway_Mode" class="control-label">PaymentGateway_Mode</label>
                                <div class="col-md-12">
                                    <input id="PaymentGateway_Mode" type="text" class="form-control"
                                        name="PaymentGateway_Mode" value="{{ old('PaymentGateway_Mode') }}" required
                                        autofocus>
                                    @if ($errors->has('PaymentGateway_Mode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('PaymentGateway_Mode') }}</strong>
                                    </span>
                                    @endif
                                </div>
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