@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pincode List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User List who have Cart Item</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">User List who have Cart Item</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Mobile No</th>
                                        <th>Party Name</th>
                                        <th>Party Code</th>
                                        <th>Conatct Person</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>PIN</th>
                                        <th>Total Cart Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $key=>$user)
                                    @if($user->chemist)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$user->chemist->Mobile_No}}</td>
                                        <td>{{$user->chemist->Party_Name}}</td>
                                        <td>{{$user->chemist->Party_Code}}</td>
                                        <td>{{$user->chemist->Contact_Person}}</td>
                                        <td>@if($user->chemist->state){{$user->chemist->state->name}}@endif</td>
                                        <td>@if($user->chemist->city){{$user->chemist->city->name}}@endif</td>
                                        <td>{{$user->chemist->PIN}}</td>
                                        <td></td>
                                        <td>
                                            <a href="{{route('backend.user_login_logs.view_chemist_cart_detail',$user->id)}}"
                                                class="btn btn-sm btn-success">View Cart detail</a>
                                        </td>
                                        @endif
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