@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payment Detail</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Payment Detail</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    {!!Form::open(['route'=>['backend.orders.payment_export'],'files'=>true,'method'=>'get','class'=>'form-horizontal'])!!}
    <div class="row">

        <div class="col-sm-1">
        </div>
        <div class="col-sm-3">
            <input name="payment_from" type="date" class="form-control" value="{{$payment_from}}">
        </div>
        <div class="col-sm-3">
            <input name="payment_to" type="date" class="form-control" value="{{$payment_to}}">
        </div>
        <div class="col-sm-3">
            <button class="btn btn-sm btn-info" type="submit">Submit</button>
        </div>

    </div>
    {!!Form::close()!!}
    <br>

    <!-- /.content -->
</div>
</div>

@stop