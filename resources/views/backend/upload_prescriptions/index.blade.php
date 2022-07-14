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

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">          
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Upload Precription List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Upload Image</th>
                                        <th>User</th>
                                        <th>Get CAll</th>
                                        <th>Add Medicine in My Card</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $x = 0;
                                    ?>
                                    @foreach($upload_prescriptions as $key=>$upload_prescription)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            <?php
                                            $images = explode(",", $upload_prescription->upload_prescription);
                                            ?>
                                            @foreach($images as $image)
                                            <?php
                                            $x = $x + 1;
                                            ?>
                                            <img src="{{asset($image)}}" style="width: 150px; height: 75px" data-toggle="modal" data-target="#myModal{{$x}}">
                                            <!-- Modal -->
                                            <div class="modal fade" id="myModal{{$x}}" role="dialog">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{asset($image)}}" style="width: 100%">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </td>
                                        <td>
                                            <?php
                                            $user = \App\User::find($upload_prescription->user_id);
                                            ?>
                                            {{$user->mobile}}
                                        </td>                                     
                                        <td>
                                            @if($upload_prescription->mobile)
                                            Yes
                                            @endif                                
                                        </td>
                                        <td>
                                            @if($upload_prescription->add_medicine)
                                            Yes
                                            @endif
                                        </td>                             
                                        <td>
                                           <a href="{{route('backend.upload_prescriptions.add_product',$upload_prescription->id)}}" class="btn btn-sm btn-success">Add Product</a>
                                            <a href="{{route('backend.upload_prescriptions.edit',$upload_prescription->id)}}" class="btn btn-sm btn-success">Edit</a>
                                            <a href="{{route('backend.upload_prescriptions.delete',$upload_prescription->id)}}" class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Image</th>
                                        <th>S. No. </th>
                                        <th>Upload Image</th>
                                        <th>User</th>
                                        <th>Get CAll</th>
                                        <th>Add Medicine in My Card</th>
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
