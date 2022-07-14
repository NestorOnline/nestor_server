uuuuuuuu@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Description Type List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Description Type List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<a href="{{route('backend.description_types.create')}}" class="btn btn-sm btn-info">Add Description Type</a>    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">          
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Description Type List</h3>
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
                  @foreach($description_types as $key=>$description_type)
                            <tr>
                                 <td>{{$key+1}}</td>
                                <td>{{$description_type->name}}</td>                             
                                <td>
                                 <a href="{{route('backend.description_types.edit',$description_type->id)}}" class="btn btn-sm btn-success">Edit</a>
                                 <a href="{{route('backend.description_types.delete',$description_type->id)}}" class="btn btn-sm btn-danger">Delete</a>
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

