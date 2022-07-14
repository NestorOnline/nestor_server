@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pending Order List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pending Order List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <br>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Party_Name </th>
                                        <td>{{$chemist->Party_Name}}</td>
                                        <th>Mobile </th>
                                        <td>{{$chemist->Mobile_No}}</td>
                                    </tr>
                                    <tr>
                                        <th>DL_No </th>
                                        <td>{{$chemist->DL_No}}</td>
                                        <th>GSTIN </th>
                                        <td>{{$chemist->GSTIN}}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact Person </th>
                                        <td>{{$chemist->Contact_Person}}</td>
                                        <th>Address </th>
                                        <td>
                                            @if($chemist->city)
                                            {{$chemist->city->name}},
                                            @endif
                                            @if($chemist->state)
                                            {{$chemist->state->name}},
                                            @endif
                                            @if($chemist->PIN)
                                            {{$chemist->PIN}},
                                            @endif

                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tbody>
                            </table>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Date</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
$total = 0;
?>
                                    @foreach($add_to_carts as $key=>$add_to_cart)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$add_to_cart->created_at->format('d-M-Y')}}</td>
                                        <td>
                                            @if($add_to_cart->product)
                                            {{$add_to_cart->product->generic_name}}
                                            ( {{$add_to_cart->product->brand_name}} )
                                            @endif
                                        </td>
                                        <td>{{$add_to_cart->Qty}}</td>
                                        <td>{{$add_to_cart->amount}}</td>

                                        <?php
$gst = 0;
if ($add_to_cart->product && $add_to_cart->product->chemist_price) {
    $price = $add_to_cart->product->chemist_price;
    $gst = $add_to_cart->product->GST;
}
$total = $total + $add_to_cart->Qty * $add_to_cart->amount + $add_to_cart->Qty * $add_to_cart->amount * $add_to_cart->product->GST / 100
?>
                                    </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="4"><strong class="pull-right">Total</strong></td>
                                        <td>{{$total}}</td>
                                    </tr>
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
</div>

@stop