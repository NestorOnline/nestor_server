@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pending Order List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pending Order List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    {!!Form::open(['files'=>true,'method'=>'get','class'=>'form-horizontal'])!!}
    <div class="row">
        <div class="col-sm-1">
        </div>
        <div class="col-sm-3">
            <input name="date" type="date" class="form-control" value="{{$date}}">
        </div>

        <div class="col-sm-3">
            <button class="btn btn-sm btn-info" type="submit">View</button>
        </div>

    </div>
    {!!Form::close()!!}
    <br>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Payment ID</th>
                                        <th>Mobile</th>
                                        <th>User Type</th>
                                        <th>Payment Date</th>
                                        <th>Paymnet Id</th>
                                        <th>Requested_Amount</th>
                                        <th>Wallet_Amount</th>
                                        <th>TransStatus</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $key=>$payment)
                                    @if($payment->User_ID)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>NMLID-{{$payment->id}}</td>
                                        @if($payment->user)
                                        <td>{{$payment->user->role}}</td>
                                        <td>{{$payment->user->mobile}}</td>
                                        @else
                                        <td></td>
                                        <td></td>
                                        @endif
                                        <td>{{$payment->created_at->format('d-M-Y')}}</td>
                                        <td>{{$payment->id}}</td>
                                        <td>{{$payment->Requested_Amount}}</td>
                                        <td>{{$payment->Wallet_Amount}}</td>
                                        <td>{{$payment->TransStatus}}</td>
                                        <td>
                                            <a href="{{route('backend.orders.view_cart_items',$payment->User_ID)}}"
                                                class="btn btn-sm btn-success">View Cart Item</a>
                                        </td>
                                    </tr>
                                    @endif
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
</div>

@stop