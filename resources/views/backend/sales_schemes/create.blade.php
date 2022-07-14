@extends('backend.theme.formtheme')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Sale Schemes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Sale Schemes</li>
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
                    <h3 class="card-title">Add New Sale Schemes</h3>

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

                            <div class="form-group{{ $errors->has('SalesScheme_Code') ? ' has-error' : '' }}">
                                <label for="SalesScheme_Code" class="col-md-2 control-label">SalesScheme_Code</label>
                                <div class="col-md-10">
                                    <input id="SalesScheme_Code" type="text" class="form-control" name="SalesScheme_Code"
                                        value="{{ old('SalesScheme_Code') }}" required autofocus>

                                    @if ($errors->has('SalesScheme_Code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('SalesScheme_Code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('SalesScheme_Name') ? ' has-error' : '' }}">
                                <label for="SalesScheme_Name" class="col-md-2 control-label">SalesScheme_Name</label>

                                <div class="col-md-10">
                                    <input id="SalesScheme_Name" type="text" class="form-control" name="SalesScheme_Name"
                                        value="{{ old('SalesScheme_Name') }}" required autofocus>

                                    @if ($errors->has('SalesScheme_Name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('SalesScheme_Name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">SchemeOn_Code</label>
                                <div class="col-md-10">
                                    <input id="SchemeOn_Code" type="text" class="form-control" name="SchemeOn_Code"
                                        value="{{ old('SchemeOn_Code') }}" required autofocus>
                                    @if ($errors->has('SchemeOn_Code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('SchemeOn_Code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('SchemeOn') ? ' has-error' : '' }}">
                                <label for="SchemeOn" class="col-md-2 control-label">SchemeOn</label>
                                <div class="col-md-10">
                                    <input id="SchemeOn" type="text" class="form-control" name="SchemeOn"
                                        value="{{ old('SchemeOn') }}" required autofocus>
                                    @if ($errors->has('SchemeOn'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('SchemeOn') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('DiscountType_Code') ? ' has-error' : '' }}">
                                <label for="DiscountType_Code" class="col-md-2 control-label">DiscountType_Code</label>
                                <div class="col-md-10">
                                    <input id="DiscountType_Code" type="text" class="form-control" name="DiscountType_Code"
                                        value="{{ old('DiscountType_Code') }}" required autofocus>

                                    @if ($errors->has('DiscountType_Code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('DiscountType_Code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('Discount') ? ' has-error' : '' }}">
                                <label for="Discount" class="col-md-2 control-label">Discount</label>
                                <div class="col-md-10">
                                    <input id="Discount" type="text" class="form-control" name="Discount"
                                        value="{{ old('Discount') }}" required autofocus>
                                    @if ($errors->has('Discount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Discount') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('NextMinSaleQty_ForScheme') ? ' has-error' : '' }}">
                                <label for="NextMinSaleQty_ForScheme" class="col-md-2 control-label">Product Code</label>
                                <div class="col-md-10">
                                    <input id="NextMinSaleQty_ForScheme" type="text" class="form-control" name="NextMinSaleQty_ForScheme"
                                        value="{{ old('NextMinSaleQty_ForScheme') }}" required autofocus>
                                    @if ($errors->has('NextMinSaleQty_ForScheme'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('NextMinSaleQty_ForScheme') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('OrderQtyMultipleOf') ? ' has-error' : '' }}">
                                <label for="OrderQtyMultipleOf" class="col-md-2 control-label">Order Qty Multiple
                                    Of</label>
                                <div class="col-md-10">
                                    <input id="OrderQtyMultipleOf" type="text" class="form-control"
                                        name="OrderQtyMultipleOf" value="{{ old('OrderQtyMultipleOf') }}" required
                                        autofocus>
                                    @if ($errors->has('OrderQtyMultipleOf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('OrderQtyMultipleOf') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('Free_Qty') ? ' has-error' : '' }}">
                                <label for="Free_Qty" class="col-md-2 control-label">Package Name</label>
                                 <div class="col-md-10">
                                    <input id="Free_Qty" type="text" class="form-control" name="Free_Qty"
                                        value="{{ old('Free_Qty') }}" required autofocus>
                                    @if ($errors->has('Free_Qty'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Free_Qty') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('Effective_From') ? ' has-error' : '' }}">
                                <label for="Effective_From" class="col-md-2 control-label">Effective_From</label>
                                 <div class="col-md-10">
                                    <input id="Effective_From" type="text" class="form-control" name="Effective_From"
                                        value="{{ old('Effective_From') }}" required autofocus>
                                    @if ($errors->has('Effective_From'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Effective_From') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            <div class="form-group{{ $errors->has('Effective_To') ? ' has-error' : '' }}">
                                <label for="Effective_To" class="col-md-2 control-label">MRP Price (Rs.)</label>
                                <div class="col-md-10">
                                    <input id="Effective_To" type="text" class="form-control" name="Effective_To"
                                        value="{{ old('Effective_To') }}" required autofocus>
                                    @if ($errors->has('Effective_To'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Effective_To') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('Office_Code') ? ' has-error' : '' }}">
                                <label for="Office_Code" class="col-md-2 control-label">Office_Code %</label>
                                <div class="col-md-10">
                                    <input id="Office_Code" type="text" class="form-control" name="Office_Code"
                                        value="{{ old('Office_Code') }}" required autofocus>
                                    @if ($errors->has('Office_Code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Office_Code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('Image') ? ' has-error' : '' }}">
                                <label for="Image" class="col-md-2 control-label">Product Image</label>
                                <div class="col-md-10">
                                    <input id="Image" type="file" class="form-control" name="Image" required autofocus>
                                    @if ($errors->has('Image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Image') }}</strong>
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