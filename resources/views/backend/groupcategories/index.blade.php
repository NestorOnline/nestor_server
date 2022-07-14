@extends('backend.theme.indextheme')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Group Category List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Group List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @include('flash')
<a href="{{route('backend.groupcategories.create')}}" class="btn btn-sm btn-info">Add Group Category</a>    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">          
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Group category List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                            <tr>
                                <th>S. No. </th>
                                <th>Group Category Name</th>
                                <th>Group Name</th>
                                <th>URL Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groupcategories as $key=>$groupcategory)
                            <tr>
                                <td>{{$key+1}}</td>

                                <td>{{$groupcategory->name}}</td>
                                <td>
                                    <?php
                                    $group = \App\Group::find($groupcategory->group_id);
                                    ?>
                                    @if($group)
                                    {{$group->name}}
                                    @endif
                                </td>
                                <td>{{$groupcategory->url_name}}</td>
                                <td>
                                @if($groupcategory->image)
                                <img src="{{asset($groupcategory->image)}}" style="width: 50px; height: 50px">
                                @endif
                                </td>
                                <td>
                                @if($groupcategory->is_home)
                                <a href="{{route('backend.groupcategories.unset_from_home',$groupcategory->id)}}" class="btn btn-sm btn-warning">Unset From Home</a>
                                @else
                                <a href="{{route('backend.groupcategories.is_home',$groupcategory->id)}}" class="btn btn-sm btn-info">At Home</a>
                                @endif  
                                
                                 <a href="{{route('backend.groupcategories.edit',$groupcategory->id)}}" class="btn btn-sm btn-success">Edit</a>
                                 <a href="{{route('backend.groupcategories.delete',$groupcategory->id)}}" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                  <tfoot>
                   <tr>
                                <th>S. No. </th>
                                <th>Group category Name</th>
                                <th>Group Name</th>
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



