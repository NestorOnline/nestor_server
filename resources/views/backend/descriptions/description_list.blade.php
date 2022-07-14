@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Desciption List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Desciption List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('flash')
    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Add Desciption</button>   <!-- Main content -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Description</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {!!Form::open(['route'=>['backend.descriptions.create',$product->id],'files'=>true,'class'=>'form-horizontal'])!!}
                    <input id="product_code" type="hidden" class="form-control" name="product_code"
                        value="{{$product->product_code}}" value="{{ old('product_code') }}" required autofocus>
                    
                        <div class="form-group{{ $errors->has('description_type_code') ? ' has-error' : '' }}">
                        <label for="description_type_code" class="control-label">Display Squence</label>
                        <div class="col-md-12">
                            <select class="form-control" name="description_type_code"  required autofocus>
                                <?php
                               $descriptiontypes = \App\Descriptiontype::all();
                                ?>
                                @foreach($descriptiontypes as $descriptiontype)
                                <option value="{{$descriptiontype->id}}">{{$descriptiontype->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('sr_no') ? ' has-error' : '' }}">
                        <label for="Display_Sequence" class="control-label">Display Squence</label>
                        <div class="col-md-12">
                            <input id="sr_no" type="number" class="form-control" name="sr_no"
                                value="{{ old('sr_no') }}" required autofocus>
                            @if ($errors->has('sr_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('sr_no') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('heading') ? ' has-error' : '' }}">
                        <label for="heading" class="control-label">heading</label>
                        <div class="col-md-12">
                            <input id="heading" type="text" class="form-control" name="heading"
                                value="{{ old('heading') }}" required autofocus>
                            @if ($errors->has('heading'))
                            <span class="help-block">
                                <strong>{{ $errors->first('heading') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="control-label">Description</label>
                        <div class="col-md-12">
                            <textarea id="description"  type="text" class="form-control" name="description"
                                value="{{ old('description') }}" required autofocus></textarea>
                            @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">          
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Desciption List ({{$product->generic_name}}-{{$product->brand_name}})</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Desciption Type</th>
                                        <th>S. No. </th>
                                        <th>Heading</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($descriptions as $key=>$description)
                                    <tr>
                                        <td>@if($description->description_type)
                                            {{$description->description_type->name}}
                                            @endif
                                        </td>  
                                        <td>{{$description->sr_no}}</td>
                                        <td>{{$description->heading}}</td>       
                                        <td>{{$description->description}}</td>      
                                        <td>
<a href="javascript:void(0);" class="btn btn-sm btn-success" data-toggle="modal" data-target="#edit_pop{{$description->id}}">Edit</a>
    <div class="modal fade" id="edit_pop{{$description->id}}" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Description</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {!!Form::open(['route'=>['backend.descriptions.edit',$description->id],'files'=>true,'class'=>'form-horizontal'])!!}
                    <input id="product_code" type="hidden" class="form-control" name="product_code" value="{{$description->product_code}}">
                    
                        <div class="form-group{{ $errors->has('description_type_code') ? ' has-error' : '' }}">
                        <label for="description_type_code" class="control-label">Display Squence</label>
                        <div class="col-md-12">
                            <select class="form-control" name="description_type_code"  required autofocus>
                                <?php
                               $descriptiontypes = \App\Descriptiontype::all();
                                ?>
                                @foreach($descriptiontypes as $descriptiontype)
                                @if($descriptiontype->id==$description->description_type_code)
                                <option value="{{$descriptiontype->id}}" selected="selected">{{$descriptiontype->name}}</option>
                                @else
                                <option value="{{$descriptiontype->id}}">{{$descriptiontype->name}}</option>
                                @endif

                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('sr_no') ? ' has-error' : '' }}">
                        <label for="Display_Sequence" class="control-label">Display Squence</label>
                        <div class="col-md-12">
                            <input id="sr_no" type="number" class="form-control" name="sr_no"
                                value="{{$description->sr_no}}" required autofocus>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('heading') ? ' has-error' : '' }}">
                        <label for="heading" class="control-label">heading</label>
                        <div class="col-md-12">
                            <input id="heading" type="text" class="form-control" name="heading"
                                value="{{$description->heading}}" required autofocus>
                           
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="control-label">Description</label>
                        <div class="col-md-12">
                            <textarea id="description"  type="text" class="form-control" name="description"
                                 required autofocus>{{$description->description}}</textarea>

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
                                            
                                            <a href="{{route('backend.descriptions.delete',$description->id)}}" class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Desciption Type</th>
                                        <th>S. No. </th>
                                        <th>Heading</th>
                                        <th>Description</th>
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

