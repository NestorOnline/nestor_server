@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Stock Report List 2</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Stock</a></li>
                        <li class="breadcrumb-item active">Stock Report List 2</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="vertical-align: text-top">S. No. </th>
                                        <th class="text-center" style="vertical-align: text-top">Code</th>
                                        <th class="text-center" style="vertical-align: text-top">Product</th>
                                        <th class="text-center" style="vertical-align: text-top">Packing</th>
                                        @foreach($offices as $office)
                                        <th class="text-center" style="vertical-align: text-top">{{$office->Location}}
                                        </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($products as $key=>$product)

                                    <tr>
                                        <td>{{$key+1}}</td>
                                        @if($product)
                                        <td>{{$product->Product_ID}}</td>
                                        <td>{{$product->brand_name}}</td>
                                        <?php
$package = \App\Package::find($product->package_id);
?>
                                        @if($package)
                                        <td>{{$package->name}}</td>
                                        @endif
                                        @endif
                                        @foreach($offices as $office)
                                        <?php
$office_stock = \App\Stock::where('Office_Code', $office->Office_Code)->where('Product_Code', $product->product_code)->first();
?>
                                        <td class="text-center">
                                            @if($office_stock)
                                            {{$office_stock->QtyForNewOrder}}
                                            @endif
                                        </td>
                                        @endforeach

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