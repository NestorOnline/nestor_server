@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order Setting List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Order Setting List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>  <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">          
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Order Setting List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>MinimumOrderValueChemist</th>
                                        <th>MinimumOrderValueCustomer</th>
                                        <th>Updated By</th>
                                        <th>Updated Date/Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order_settings as $key=>$order_setting)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$order_setting->MinimumOrderValueForChemist}}</td>
                                        <td>{{$order_setting->MinimumOrderValueForCustomer}}</td> 
                                         <td>
                                             <?php
                                             
                                             ?>
                                             @if($order_setting->update_by)
                                             <?php
                                            $user = \App\User::find($order_setting->update_by);
                                             ?>
                                             @if($user)
                                             {{$user->mobile}}
                                             @endif
                                            @endif</td> 
                                          <td>{{$order_setting->updated_at->format('d-M-Y H:i:s')}}</td> 

                                        <td>
                                            <a href="{{route('backend.order_settings.edit',$order_setting->id)}}" class="btn btn-sm btn-success">Edit</a>
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

