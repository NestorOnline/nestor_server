@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Doctor Specialization List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Doctor Specialization List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <a href="{{route('backend.doctor_specializations.create')}}" class="btn btn-sm btn-info">Add Doctor
        Specialization</a>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Doctor Specialization List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Icon Image</th>
                                        <th>Specialization Name</th>
                                        <th>Doctor Type</th>
                                        <th>Specialization Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctor_specializations as $key=>$doctor_specialization)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td><img src="{{$doctor_specialization->icon_image}}"
                                                style="width: 150px; height: 75px"></td>
                                        <td>{{$doctor_specialization->Specialization_Name}}</td>
                                        <td>
                                            @if($doctor_specialization->Doctor_Type==1)
                                            Allopathic
                                            @elseif($doctor_specialization->Doctor_Type==2)
                                            Ayurvedic
                                            @endif
                                        </td>
                                        <td>
                                            @if($doctor_specialization->Doctor_Type==1)
                                            General Physician
                                            @elseif($doctor_specialization->Doctor_Type==2)
                                            Specialities
                                            @elseif($doctor_specialization->Doctor_Type==3)
                                            Common Health Issue
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('backend.doctor_specializations.edit',$doctor_specialization->id)}}"
                                                class="btn btn-sm btn-success">Edit</a>
                                            <a href="{{route('backend.doctor_specializations.delete',$doctor_specialization->id)}}"
                                                class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Icon Image</th>
                                        <th>Specialization Name</th>
                                        <th>Doctor Type</th>
                                        <th>Specialization Type</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
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