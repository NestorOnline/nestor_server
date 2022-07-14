@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Product List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <a href="{{route('backend.products.create')}}" class="btn btn-sm btn-info">Add Product</a> <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Image(460 X 306)</th>
                                        
                                        <th>Product Code</th>
                                        <th>Product ID</th>
                                        
                                        <th>Generic Name</th>
                                        <th>Brand Name</th>
                                        <th>Group</th>
                                        <th>Group Category</th>
                                        <th>Package</th>
                                        <th>Category</th>
                                        <th>Product Code</th>
                                        <th>Order Quantity Code</th>
                                        <th>Composition</th>
                                        <th>Storage</th>
                                        <th>MRP Amount(Rs.)</th>
                                        <th>Offer</th>
                                        <th>Actual Amount(Rs.)</th>
                                        <th>Manufacture</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $key=>$product)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            <?php
$product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
?>
                                            @if($product_image)
                                            @if(!$product_image->PhotoFile_Name==NULL)
                                            <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}"
                                                class="img-responsive category_image" style="width: 150px; height: 75px"
                                                alt="Nestor Immunity Care" data-toggle="modal"
                                                data-target="#myModal{{$product->id}}">
                                            @else
                                            <img src="{{asset('NoImage.webp')}}" class="img-responsive category_image"
                                                style="width: 150px; height: 75px" alt="Nestor Immunity Care"
                                                data-toggle="modal" data-target="#myModal{{$product->id}}">
                                            @endif
                                            @else
                                            <img src="{{asset('NoImage.webp')}}" class="img-responsive category_image"
                                                style="width: 150px; height: 75px" alt="Nestor Immunity Care"
                                                data-toggle="modal" data-target="#myModal{{$product->id}}">
                                            @endif


                                            <div class="modal fade" id="myModal{{$product->id}}" role="dialog">
                                                <div class="modal-dialog  modal-lg">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">{{$product->generic_name}}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if($product_image)
                                                            @if(!$product_image->PhotoFile_Name==NULL)
                                                            <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}"
                                                                style="width: 100%"
                                                                class="img-responsive category_image"
                                                                alt="Nestor Immunity Care">
                                                            @else
                                                            <img src="{{asset('NoImage.webp')}}"
                                                                class="img-responsive category_image"
                                                                style="width: 100%" alt="Nestor Immunity Care">
                                                            @endif
                                                            @else
                                                            <img src="{{asset('NoImage.webp')}}"
                                                                class="img-responsive category_image"
                                                                style="width: 100%" alt="Nestor Immunity Care">
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </td>
                                         <td>{{$product->product_code}}</td>
                                        <td>{{$product->Product_ID}}</td>
                                        <td>{{$product->generic_name}}</td>
                                        <td>{{$product->brand_name}}</td>
                                        <td>
                                            <?php
$group = \App\Group::find($product->group_id);
?>
                                            @if($group)
                                            {{$group->name}}
                                            @endif
                                        </td>
                                        <td>
                                            <?php
$ProductGroupCategories = \App\ProductGroupCategories::where('Product_Code',$product->product_code)->get();
?>
@foreach($ProductGroupCategories as $ProductGroup)
<?php
$group_category = \App\Groupcategory::find($ProductGroup->groupcategory_id);
?>
@if($group_category)
{{$group_category->name}},
@endif
@endforeach
                                           
                                        </td>
                                        <td>
                                            <?php
$package = \App\Package::find($product->package_id);
?>
                                            @if($package)
                                            {{$package->name}}
                                            @endif
                                        </td>
                                        <td>
                                            <?php
$category = \App\Category::find($product->category_id);
?>
                                            @if($category)
                                            {{$category->name}}
                                            @endif
                                        </td>
                                        <td>{{$product->product_code}}</td>
                                        <td>{{$product->OrderQtyMultipleOf}}</td>
                                        <td>{{$product->composition}}</td>
                                        <td>{{$product->storage}}</td>

                                        <td>{{$product->mrp_amount}}</td>
                                        <td>{{$product->offer}} %</td>
                                        <td>{{$product->actual_amount}}</td>
                                        <td>{{$product->manufacture}}</td>
                                        <td>
                                            <a href="{{route('backend.descriptions.description_list',$product->id)}}"
                                                class="btn btn-sm btn-info">Add Description</a>
                                            <a href="javascript:void()" class="btn btn-sm btn-primary"
                                                data-toggle="modal" data-target="#changeAccess"
                                                data-rrmid="{{$product->id}}" data-tooltip="tooltip"
                                                title="View Detail">add Home</a>
                                            <!-- <a href="{{route('backend.comparative_products.list',$product->id)}}"
                                                class="btn btn-sm btn-info">List Of comparative Products</a> -->

                                            <a href="{{route('backend.product_images.add_image',$product->id)}}"
                                                class="btn btn-sm btn-warning">Add Image</a>

                                            <a href="{{route('backend.products.edit',$product->id)}}"
                                                class="btn btn-sm btn-success">Edit</a>
                                            <a href="{{route('backend.products.delete',$product->id)}}"
                                                class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Image</th>
                                        <th>Product Code</th>
                                        <th>Product ID</th>
                                        <th>Generic Name</th>
                                        <th>Brand Name</th>
                                        <th>Group</th>
                                        <th>Group Category</th>
                                        <th>Package</th>
                                        <th>Category</th>
                                        <th>Product Code</th>
                                        <th>Order Quantity Code</th>
                                        <th>Composition</th>
                                        <th>Storage</th>
                                        <th>MRP Amount(Rs.)</th>
                                        <th>Offer</th>
                                        <th>Actual Amount(Rs.)</th>
                                        <th>Manufacture</th>
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

<div class="modal fade" id="changeAccess" tabindex="-1" role="dialog" aria-labelledby="changeAccessLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeAccessLabel">Select Add Home</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!!Form::open(['route'=>['backend.products.add_position'],'files'=>true,'class'=>'form-horizontal'])!!}
                <input id="changeAccessModelLidden" name="product_id" type="hidden">
                <div class="mb-3 row">
                    <label for="newManager" class="col-sm-5 col-form-label">Position at<span
                            class="required">*</span></label>
                    <div class="col-sm-7">
                        <select name="position_at" class="form-control" required>
                            <option value="">---Select Position---</option>
                            <option value="home">Home</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="newManager" class="col-sm-5 col-form-label">Product Position<span
                            class="required">*</span></label>
                    <div class="col-sm-7">
                        <select name="position" class="form-control" required>
                            <option value="">---Select Position---</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>

@stop