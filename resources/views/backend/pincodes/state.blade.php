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
                        <li class="breadcrumb-item active">Pincode List</li>
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
                            <h3 class="card-title">Pincode List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          
           <table  class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>City</th>
                                        <th>PINCODE</th>
                                        <th>SERVICABLE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pincodes as $abc=>$pincode)
                                    <tr>
                                        <td>{{$abc+1}}</td>
                                        <td>
                                        <?php
                                        $city=\App\City::find($pincode->city_id);
                                        ?>
                                        @if($city)
                                        {{$city->name}}
                                        @endif
                                        </td>  
                                        <td>{{$pincode->pincode}}</td> 
                                       <td>@if($pincode->Serviceable==1)
                                        YES
                                            @else
                                        NO
                                            @endif
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

