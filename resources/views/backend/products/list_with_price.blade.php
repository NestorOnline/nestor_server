@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product List With Price</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Product List With Price</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product List With Price</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Image</th>
                                        <th>Product ID</th>
                                        <th>Brand Name</th>
                                        <th>Chemist MRP</th>
                                        <th>Chemist Price</th>
                                        <th>Customer MRP</th>
                                        <th>Customer Price</th>
                                        <th>GST</th>
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
                                        <td>{{$product->Product_ID}}</td>
                                        <td>{{$product->brand_name}}</td>
                                        <td>
                                            @if($product->mrp_price)
                                            {{$product->mrp_price->Price}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->chemist_price)
                                            {{$product->chemist_price->Price}}
                                            <br>
                                            {{$product->chemist_price->GST}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->customer_mrp_price)
                                            {{$product->customer_mrp_price->Price}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->customer_price)
                                            {{$product->customer_price->Price}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->chemist_price)
                                            {{$product->chemist_price->GST}}
                                            @endif
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