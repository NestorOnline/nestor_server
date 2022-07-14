@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order Detail</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Order Detail</li>
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

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Order No. </th>
                                        <td>NSRID-{{$order->id}}</td>

                                        <th>Customer Type</th>
                                        <td>Chemist</td>
                                        <th>Order Date</th>
                                        <td colspan="2">{{$order->created_at->format('d-M-Y')}}</td>
                                        <th>Order From</th>
                                        <td colspan="2">{{$order->orderreceivedfroms->OrderReceivedFrom_Name}}</td>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: top;">Party Name</th>
                                        <td>
                                            {{$order->Party_Name}}
                                            <br>
                                            ( {{$order->Party_Code}} )
                                        </td>
                                        <th style="vertical-align: top;">Contact Person</th>
                                        <td>{{$order->Contact_Person}}</td>
                                        <th style="vertical-align: top;">GST No.</th>
                                        <td colspan="2">{{$order->GSTIN}}</td>
                                        <th style="vertical-align: top;">DL No.</th>
                                        <td colspan="2">{{$order->DL_No}}
                                            <?php
$chemist = \App\Chemist::where('user_id', $order->user_id)->first();
?>
                                            @if($chemist)
                                            <a href="{{asset($chemist->DL_File)}}"
                                                target="_blank">{{$chemist->DL_File}}</a>
                                            @endif
                                            <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: top;">Address</th>
                                        <td colspan="7">
                                            @if($order->Address1)
                                            {{$order->Address1}},
                                            @endif
                                            @if($order->Address2)
                                            {{$order->Address2}},
                                            @endif
                                            @if($order->Address3)
                                            {{$order->Address3}},
                                            @endif
                                            @if($order->cities)
                                            {{$order->cities->name}},
                                            @endif
                                            @if($order->states)
                                            {{$order->states->name}},
                                            @endif
                                            @if($order->PIN)
                                            {{$order->PIN}}
                                            @endif

                                        </td>
                                        <th>Mobile</th>
                                        <td>
                                            @if($order->Mobile_No)
                                            {{$order->Mobile_No}}
                                            @endif
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>PRODUCT ID</th>
                                        <th>PRODUCT</th>
                                        <th>QTY</th>
                                        <th>FREE QTY</th>
                                        <th>RATE</th>
                                        <th>AMOUNT</th>
                                        <th>DISCOUNT AMOUNT</th>
                                        <th>TAXABLE AMOUNT</th>
                                        <th>TAX</th>
                                        <th>TOTAL</th>
                                    </tr>
                                    <?php
$sub_order_qty = 0;
$sub_free_qty = 0;
$sub_rate = 0;
$sub_amount = 0;
$sub_discount = 0;
$sub_taxable = 0;
$sub_tax = 0;
$sub_total = 0;
?>
                                    @foreach($order->orderproducts as $key=>$orderproduct)
                                    <tr>
                                        <td>{{$orderproduct->product->Product_ID}}</td>
                                        <td>{{$orderproduct->product->brand_name}}</td>
                                        <td align="right">{{$orderproduct->Order_Qty}}</td>
                                        <td align="right">{{$orderproduct->Free_Qty}}</td>
                                        <td align="right">{{$orderproduct->Rate}}</td>
                                        <td align="right">{{$orderproduct->Amount}}</td>
                                        <td align="right">{{$orderproduct->Discount}}</td>
                                        <td align="right">{{$orderproduct->Taxable}}</td>
                                        <td align="right">{{$orderproduct->Tax}}</td>
                                        <td align="right">{{$orderproduct->Total}}</td>
                                    </tr>
                                    <?php
$sub_order_qty = $sub_order_qty + $orderproduct->Order_Qty;
$sub_free_qty = $sub_free_qty + $orderproduct->Free_Qty;
$sub_rate = $sub_rate + $orderproduct->Rate;
$sub_amount = $sub_amount + $orderproduct->Amount;
$sub_discount = $sub_discount + $orderproduct->Discount;
$sub_tax = $sub_tax + $orderproduct->Tax;
$sub_taxable = $sub_taxable + $orderproduct->Taxable;
$sub_total = $sub_total + $orderproduct->Total;
?>
                                    @endforeach
                                    <tr style="background: yellow">
                                        <td></td>
                                        <td></td>
                                        <td align="right">{{$sub_order_qty}}</td>
                                        <td align="right">{{$sub_free_qty}}</td>
                                        <td align="right">{{$sub_rate}}</td>
                                        <td align="right">{{$sub_amount}}</td>
                                        <td align="right">{{$sub_discount}}</td>
                                        <td align="right">{{$sub_taxable}}</td>
                                        <td align="right">{{$sub_tax}}</td>
                                        <td align="right">{{$sub_total}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="text-right"> Product_Amount</td>
                                        <td colspan="2">{{$order->Payment_Amount}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="text-right"> Discount_Amount</td>
                                        <td colspan="2">{{$order->Discount_Amount}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="text-right"> Taxable_Amount</td>
                                        <td colspan="2">{{$order->Taxable_Amount}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="text-right"> Tax_Amount</td>
                                        <td colspan="2">{{$order->Tax_Amount}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="text-right"> Delivery_Amount</td>
                                        <td colspan="2">{{$order->Delivery_Amount}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="text-right"> Grand_Total</td>
                                        <td colspan="2">{{$order->Grand_Total}}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="8" class="text-right">WalletAmount</td>
                                        <td colspan="2">{{$order->WalletAmount}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="text-right">Payment_Amount</td>
                                        <td colspan="2">{{$order->Payment_Amount}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="text-right">Return_Amount</td>
                                        <td colspan="2">{{$order->Return_Amount}}</td>
                                    </tr>


                                    <?php

?>
                                    <tr>
                                        <td colspan="2"> Payment ORDER ID</td>
                                        <td colspan="3"> {{$order->payment_detail->Order_Code}}</td>
                                        <td colspan="2"> Requested Amount</td>
                                        <td colspan="3"> {{$order->payment_detail->Requested_Amount}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"> Bank Trans ID</td>
                                        <td colspan="3"> {{$order->payment_detail->BankTransID}}</td>
                                        <td colspan="2"> Trans Status</td>
                                        <td colspan="3"> {{$order->payment_detail->TransStatus}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"> Order Status</td>
                                        <td colspan="3">
                                            @if($order->order_status)
                                            {{$order->order_status->OrderStatus_Name}}
                                            @endif
                                        </td>
                                    </tr>


                                </tbody>
                            </table>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Order_Date</th>
                                        <th>ProcessingOn</th>
                                        <th>PackedOn</th>
                                        <th>DispatchedOn</th>
                                        <th>DeliveredOn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$order->Order_Date}}</td>
                                        <td>{{$order->ProcessingOn}}</td>
                                        <td>{{$order->PackedOn}}</td>
                                        <td>{{$order->DispatchedOn}}</td>
                                        <td>{{$order->DeliveredOn}}</td>
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
@stop