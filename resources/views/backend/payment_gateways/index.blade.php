@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payment Gatway List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Payment Gatway List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        <a href="{{route('backend.payment_gateways.create')}}" class="btn btn-sm btn-info">Add Payment Gatway</a>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Group List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Payment Gateway Code</th>
                                        <th>Payment Gateway Name</th>
                                        <th>Payment Gateway MKey</th>
                                        <th>Payment Gateway MId</th>
                                        <th>Payment Gateway MWebsite</th>
                                        <th>Payment Gateway Channel</th>
                                        <th>Payment Gateway IndustryType</th>
                                        <th>Payment Gateway Callback_Url</th>
                                        <th>Payment Gateway Mode</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payment_gateways as $key=>$payment_gateway)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$payment_gateway->PaymentGateway_Code}}</td>
                                        <td>{{$payment_gateway->PaymentGateway_Name}}</td>
                                        <td>{{$payment_gateway->PaymentGateway_MKey}}</td>
                                        <td>{{$payment_gateway->PaymentGateway_MId}}</td>
                                        <td>{{$payment_gateway->PaymentGateway_MWebsite}}</td>
                                        <td>{{$payment_gateway->PaymentGateway_Channel}}</td>
                                        <td>{{$payment_gateway->PaymentGateway_IndustryType}}</td>
                                        <td>{{$payment_gateway->PaymentGateway_Callback_Url}}</td>
                                        <td>{{$payment_gateway->PaymentGateway_Mode}}</td>
                                        <td>

                                        </td>
                                        <td>
                                            <a href="{{route('backend.groups.edit',$payment_gateway->id)}}"
                                                class="btn btn-sm btn-success">Edit</a>
                                            <a href="{{route('backend.groups.delete',$payment_gateway->id)}}"
                                                class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@stop