@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Image List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Image List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('flash')
    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Add Image</button>
    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModalMobile">Add Mobile
        Image</button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Image</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {!!Form::open(['route'=>['backend.product_images.add_image',$product->id],'files'=>true,'class'=>'form-horizontal'])!!}
                    <input id="Product_Code" type="hidden" class="form-control" name="Product_Code"
                        value="{{$product->product_code}}" value="{{ old('Product_Code') }}" required autofocus>
                    <input id="provided_by" type="hidden" class="form-control" name="provided_by" value="CHANGE"
                        value="{{ old('provided_by') }}" required autofocus>

                    <div class="form-group{{ $errors->has('Display_Sequence') ? ' has-error' : '' }}">
                        <label for="Display_Sequence" class="col-md-2 control-label">Display Squence</label>
                        <div class="col-md-10">
                            <input id="Display_Sequence" type="text" class="form-control" name="Display_Sequence"
                                value="{{ old('Display_Sequence') }}" required autofocus>
                            @if ($errors->has('Display_Sequence'))
                            <span class="help-block">
                                <strong>{{ $errors->first('Display_Sequence') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('PhotoFile_Name') ? ' has-error' : '' }}">
                        <label for="PhotoFile_Name" class="col-md-2 control-label">Product Image</label>
                        <div class="col-md-10">
                            <input id="PhotoFile_Name" type="file" class="form-control" name="PhotoFile_Name" required
                                autofocus>
                            @if ($errors->has('PhotoFile_Name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('PhotoFile_Name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModalMobile" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add MOBILE Image</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {!!Form::open(['route'=>['backend.product_images.add_image_mobile',$product->id],'files'=>true,'class'=>'form-horizontal'])!!}
                    <input id="Product_Code" type="hidden" class="form-control" name="Product_Code"
                        value="{{$product->product_code}}" value="{{ old('Product_Code') }}" required autofocus>
                    <input id="provided_by" type="hidden" class="form-control" name="provided_by" value="MOBILE"
                        required autofocus>

                    <div class="form-group{{ $errors->has('Display_Sequence') ? ' has-error' : '' }}">
                        <label for="Display_Sequence" class="col-md-2 control-label">Display Squence</label>
                        <div class="col-md-10">
                            <input id="Display_Sequence" type="text" class="form-control" name="Display_Sequence"
                                value="{{ old('Display_Sequence') }}" required autofocus>
                            @if ($errors->has('Display_Sequence'))
                            <span class="help-block">
                                <strong>{{ $errors->first('Display_Sequence') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('PhotoFile_Name') ? ' has-error' : '' }}">
                        <label for="PhotoFile_Name" class="col-md-2 control-label">Product Image</label>
                        <div class="col-md-10">
                            <input id="PhotoFile_Name" type="file" class="form-control" name="PhotoFile_Name" required
                                autofocus>
                            @if ($errors->has('PhotoFile_Name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('PhotoFile_Name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{$product->generic_name}} ({{$product->brand_name}})</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Image (460 X 306)</th>
                                        <th>Display Sequence</th>
                                        <th>Image For</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product_images as $key=>$product_image)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            @if($product_image->provided_by)
                                            <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}"
                                                style="width: 150px; height: 100px">
                                            @endif
                                        </td>

                                        <td>{{$product_image->Display_Sequence}}</td>
                                        <td>
                                            @if($product_image->image_type)
                                            APP
                                            @else
                                            WEB
                                            @endif
                                        </td>
                                        <td>

                                            <a href="{{route('backend.product_images.delete',$product_image->id)}}"
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