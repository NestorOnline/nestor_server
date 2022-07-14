@extends('backend.theme.indextheme')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Slider List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Slider List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <a href="{{route('backend.sliders.create')}}" class="btn btn-sm btn-info">Add Slider</a> <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Slider List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Slider Type</th>
                                        <th>URL Link</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sliders as $key=>$slider)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td><img src="{{$slider->image}}" class="img-responsive"
                                                style="width: 300px;height: 100px"></td>
                                        <td>{{$slider->title}}</td>
                                        <td>{{$slider->slider_type}}</td>
                                        <td>{{$slider->url_link}}</td>

                                        <td>
                                            <a href="{{route('backend.sliders.edit',$slider->id)}}"
                                                class="btn btn-sm btn-success">Edit</a>
                                            <a href="{{route('backend.sliders.delete',$slider->id)}}"
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