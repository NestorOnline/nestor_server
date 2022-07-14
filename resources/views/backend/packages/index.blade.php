@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Package List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Package List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<a href="{{route('backend.packages.create')}}" class="btn btn-sm btn-info">Add Package</a>    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">          
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Package List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S. No. </th>
                                <th>Name</th>
                                <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($packages as $key=>$package)
                            <tr>
                                 <td>{{$key+1}}</td>
                                <td>{{$package->name}}</td>                             
                                <td>
                                 <a href="{{route('backend.packages.edit',$package->id)}}" class="btn btn-sm btn-success">Edit</a>
                                 <a href="{{route('backend.packages.delete',$package->id)}}" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                  </tbody>
                  <tfoot>
                   <tr>
                    <th>S. No. </th>
                                <th>Name</th>
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

