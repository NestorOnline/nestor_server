@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>{{$product->Product_ID}}-{{$product->generic_name}}</h1>
                    <br>
                    @if($product->package)
                    <p><strong>B2B Packing :</strong>{{$product->package->name}}</p>
                    <p><strong> B2C Packing :</strong> {{$product->package->Packing_Description}}</p>
                    @endif
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Competitive Price to Retailer</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal">
        Add of Comparative Product
    </button>
    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <p>Add Competitive Price to Retailer
                        <br>
                        <strong> {{$product->Product_ID}}-{{$product->generic_name}}</strong>
                    </p>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    {!!Form::open(['route'=>['backend.comparative_products.create'],'files'=>true,'class'=>'form-horizontal'])!!}
                    {{ csrf_field() }}

                    <input type="hidden" class="form-control" name="product_id" value="{{$product_id}}" required
                        autofocus>
                    <div class="form-group{{ $errors->has('manufacturer') ? ' has-error' : '' }}">
                        <label for="manufacturer" class="col-md-12 control-label">Manufacturer</label>
                        <div class="col-md-12">
                            <select name="manufacturer" class="form-control" required autofocus>
                                <option value="">---- Select -----</option>
                                @foreach($manufactures as $manufacture)
                                <option value="{{$manufacture->id}}">{{$manufacture->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('manufacturer'))
                            <span class="help-block">
                                <strong>{{ $errors->first('manufacturer') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
                        <label for="heading" class="col-md-12 control-label">Product Name</label>
                        <div class="col-md-12">
                            <input id="product_name" type="text" class="form-control" name="product_name"
                                value="{{ old('product_name') }}" required autofocus>
                            @if ($errors->has('product_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('product_name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                        <label for="sr_no" class="col-md-12 control-label">B2B Price
                            @if($product->package)
                            -{{$product->package->name}}
                            @endif
                        </label>
                        <div class="col-md-12">
                            <input id="price" type="text" class="form-control" name="price" value="{{ old('price') }}"
                                required autofocus>
                            @if ($errors->has('price'))
                            <span class="help-block">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('b2c_price') ? ' has-error' : '' }}">
                        <label for="sr_no" class="col-md-12 control-label">
                            B2C Price
                            @if($product->package)
                            -{{$product->package->Packing_Description}}
                            @endif
                        </label>
                        <div class="col-md-12">
                            <input id="b2c_price" type="text" class="form-control" name="b2c_price"
                                value="{{ old('b2c_price') }}" required autofocus>
                            @if ($errors->has('b2c_price'))
                            <span class="help-block">
                                <strong>{{ $errors->first('b2c_price') }}</strong>
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
                    {!!Form::close()!!}

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

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
                            <h3 class="card-title">List of Competitive Price to Retailer </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Manufacturer</th>
                                        <th>Product Name</th>
                                        <th>B2B Price</th>
                                        <th>B2C Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($comparative_products as $key=>$comparative_product)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>@if($comparative_product->manufacturer_single)
                                            {{$comparative_product->manufacturer_single->name}}
                                            @endif</td>
                                        <td>{{$comparative_product->product_name}}</td>
                                        <td>{{$comparative_product->price}}</td>
                                        <td>{{$comparative_product->b2c_price}}</td>

                                        <td>
                                            <div class="modal" id="UpdateModal{{$comparative_product->id}}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Update Competitive Price to Retailer
                                                            </h4>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            {!!Form::open(['route'=>['backend.comparative_products.edit',$comparative_product->id],'files'=>true,'class'=>'form-horizontal'])!!}
                                                            {{ csrf_field() }}


                                                            <div
                                                                class="form-group{{ $errors->has('manufacturer') ? ' has-error' : '' }}">
                                                                <label for="manufacturer"
                                                                    class="col-md-12 control-label">Manufacturer</label>
                                                                <div class="col-md-12">
                                                                    <select name="manufacturer" class="form-control"
                                                                        required autofocus>
                                                                        <option value="">---- Select -----</option>
                                                                        @foreach($manufactures as $manufacture)
                                                                        <option value="{{$manufacture->id}}"
                                                                            {{$manufacture->id==$comparative_product->manufacturer?'selected':''}}>
                                                                            {{$manufacture->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if ($errors->has('manufacturer'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('manufacturer') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
                                                                <label for="heading"
                                                                    class="col-md-12 control-label">Product Name</label>
                                                                <div class="col-md-12">
                                                                    <input id="product_name" type="text"
                                                                        class="form-control" name="product_name"
                                                                        value="{{$comparative_product->product_name}}"
                                                                        required autofocus>
                                                                    @if ($errors->has('product_name'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('product_name') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                                                <label for="sr_no" class="col-md-12 control-label">
                                                                    B2B Price
                                                                    @if($product->package)
                                                                    -{{$product->package->name}}
                                                                    @endif
                                                                </label>
                                                                <div class="col-md-12">
                                                                    <input id="price" type="text" class="form-control"
                                                                        name="price"
                                                                        value="{{$comparative_product->price}}" required
                                                                        autofocus>
                                                                    @if ($errors->has('price'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('price') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="form-group{{ $errors->has('b2c_price') ? ' has-error' : '' }}">
                                                                <label for="sr_no" class="col-md-12 control-label">
                                                                    B2C Price
                                                                    @if($product->package)
                                                                    -{{$product->package->Packing_Description}}
                                                                    @endif
                                                                </label>
                                                                <div class="col-md-12">
                                                                    <input id="b2c_price" type="text"
                                                                        class="form-control" name="b2c_price"
                                                                        value="{{$comparative_product->b2c_price}}"
                                                                        required autofocus>
                                                                    @if ($errors->has('b2c_price'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('b2c_price') }}</strong>
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
                                                            {!!Form::close()!!}

                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Close</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <a href="javascript::void(0);" class="btn btn-sm btn-success"
                                                data-toggle="modal"
                                                data-target="#UpdateModal{{$comparative_product->id}}">Edit</a>
                                            <a href="{{route('backend.comparative_products.delete',$comparative_product->id)}}"
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