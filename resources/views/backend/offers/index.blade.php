@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Offer List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Offer List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<a href="{{route('backend.offers.create')}}" class="btn btn-sm btn-info">Add Offer</a>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">          
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Offer List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>S. No. </th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Valid Date</th>
                                <th>Eligibility</th>
                                <th>How To Get</th>
                                <th>Cancellation Condition</th>
                                <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($offers as $key=>$offer)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><img src="{{asset($offer->image)}}" style="width: 150px; height: 75px"></td>
                                <td>{{$offer->name}}</td>
                                <td>{{$offer->description}}</td>
                                <td>{{$offer->valid_till->format('d-M-Y')}}</td>
                                <td>{{$offer->eligibility}}</td>
                                <td>{{$offer->how_you_get}}</td>
                                <td>{{$offer->cancellation_condition}}</td>                               
                                <td>
                                 <a href="{{route('backend.offers.edit',$offer->id)}}" class="btn btn-sm btn-success">Edit</a>
                                 <a href="{{route('backend.offers.delete',$offer->id)}}" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                  </tbody>
                  <tfoot>
                      <tr>
                  <th>S. No. </th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Valid Date</th>
                                <th>Eligibility</th>
                                <th>How To Get</th>
                                <th>Cancellation Condition</th>
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
