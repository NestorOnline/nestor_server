@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chemist List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Single Chemist Profile </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <a href="{{route('backend.chemists.create')}}" class="btn btn-sm btn-info">Single Chemist Profile</a>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Chemist List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Mobile No</th>
                                        <td>{{$chemist->Mobile_No}}</td>
                                    </tr>
                                    <tr>
                                        <th>Party Name</th>
                                        <td>{{$chemist->Party_Name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Party Code</th>
                                        <td>{{$chemist->Party_Code}}</td>
                                    </tr>
                                    <tr>
                                        <th>Conatct Person</th>
                                        <td>{{$chemist->Contact_Person}}</td>
                                    </tr>
                                    <tr>
                                        <th>DL No.</th>
                                        <td>{{$chemist->DL_No}}</td>
                                    </tr>
                                    <tr>
                                        <th>DL File</th>
                                        <td><a href="{{asset($chemist->DL_File)}}"
                                                target="_blank">{{$chemist->DL_File}}</a></td>
                                    </tr>
                                    <tr>
                                        <th>Email ID</th>
                                        <td>{{$chemist->Email_ID}}</td>
                                    </tr>
                                    <tr>
                                        <th>City</th>
                                        <td>@if($chemist->state){{$chemist->state->name}}@endif</td>
                                    </tr>
                                    <tr>
                                        <th>State</th>
                                        <td>@if($chemist->city){{$chemist->city->name}}@endif</td>
                                    </tr>
                                    <tr>
                                        <th>PIN</th>
                                        <td>{{$chemist->PIN}}</td>
                                    </tr>
                                    <tr>
                                        <th>Party Type</th>
                                        <td>
                                            @if($chemist->PartyType_Code==17)
                                            Chemist
                                            @else
                                            Customer
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>GST No.</th>
                                        <td>
                                            {{$chemist->GSTIN}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>STATUS</th>
                                        <td>
                                            @if($chemist->Status==0)
                                            <b style="color: red">Deactivate</b>
                                            @else
                                            <b style="color: #00cc00">Activate</b>
                                            @endif
                                        </td>
                                    </tr>

                                </thead>


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