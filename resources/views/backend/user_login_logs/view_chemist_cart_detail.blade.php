@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>View All Cart Items</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">View All Cart Items</li>
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
                            <h3 class="card-title">View All Cart Items</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Product Code</th>
                                        <th>Product ID</th>
                                        <th>MRP</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($add_to_carts as $key=>$add_to_cart)
                                    @if($add_to_cart->product)
                                    <tr>
                                        <td>{{$key+1}}</td>

                                        <td>
                                            @if($add_to_cart->product)
                                            <?php
$product_image = \App\Productimage::where('Product_Code', '=', $add_to_cart->product->product_code)->first();
?>
                                            <img
                                                src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}">
                                            @endif
                                        </td>
                                        <td>
                                            {{$add_to_cart->product->brand_name}}
                                            ({{$add_to_cart->product->generic_name}} )
                                        </td>
                                        <td>
                                            ({{$add_to_cart->product->product_code}} )
                                        </td>
                                        <td>
                                            ({{$add_to_cart->product->Product_ID}} )
                                        </td>
                                        <td>
                                            @if($add_to_cart->product->chemist_price)
                                            {{$add_to_cart->product->chemist_price->Price}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($add_to_cart->product->mrp_price)
                                            {{$add_to_cart->product->mrp_price->Price}}
                                            @endif
                                        </td>
                                        <td>{{$add_to_cart->Qty}}</td>
                                    </tr>
                                    @endif
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