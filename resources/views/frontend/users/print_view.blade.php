@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div" onload="myFunction()">
    <div class="container">
        <div>
            <div class="row">
                <div class="col-md-12">
                    <div class="py-3">
                        <h3>My Orders</h3>
                    </div>
                </div>
                <div class="col-md-12">
                    <div>
                        <div>
                            <div>
                                <div class="product-details">
                                    <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                                        <div class="rightside-details col pr-0">
                                            @if($order->Party_Name)
                                            <div class="row m-0">
                                                <div class="product-item-name col pl-0">
                                                    <a
                                                        href="non-prescriptions/natural-power-capsule-60s">{{$order->Party_Name}}</a>
                                                </div>
                                            </div>
                                            @endif
                                            @if($order->Address1)
                                            <div class="row m-0 mt-2">
                                                <div class="catag-name col pl-0">
                                                    <p class="form m-0">{{$order->Address1}},</p>
                                                </div>
                                            </div>
                                            @endif
                                            @if($order->Address2)
                                            <div class="row m-0 mt-2">
                                                <div class="catag-name col pl-0">
                                                    <p class="form m-0">{{$order->Address2}},</p>
                                                </div>
                                            </div>
                                            @endif
                                            @if($order->Address3)
                                            <div class="row m-0 mt-2">
                                                <div class="catag-name col pl-0">
                                                    <p class="form m-0">{{$order->Address3}},</p>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="row m-0 mt-1">
                                                <div class="catag-name col pl-0">
                                                    <p class="form m-0">
                                                        <?php
$city = \App\City::find($order->City_Code);
?>
                                                        @if($city)
                                                        {{$city->name}}
                                                        @endif
                                                        ( {{$order->PIN}} ),
                                                        <?php
$state = \App\State::find($order->State_Code);
?>
                                                        @if($state)
                                                        {{$state->name}}
                                                        @endif</p>
                                                </div>
                                            </div>
                                            <div class="deliveryby row m-0 mt-2">
                                                <div class="date deldate col pl-0">
                                                    <div class="deliveryby"> {{$order->Mobile_No}}</div>
                                                </div>
                                            </div>
                                            @if($order->gst)
                                            <div class="deliveryby row m-0 mt-2">
                                                <div class="date deldate col pl-0">
                                                    <div class="deliveryby"> GST: {{$order->GSTIN}}</div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="cart-product mt-3">
                                    <h4>Track your Order Here</h4>

                                    <div class="product-details">
                                        <div class="steps-from">
                                            <ul class="steps-ul list-unstyled">
                                                <li class="active li1">Ordered <span>{{$order->created_at->format('D')}}
                                                        {{$order->created_at->format('d')}}
                                                        {{$order->created_at->format('M')}} </span></li>
                                                @if($order->CancelOn)
                                                <li class="active li2">Ordered Cancel<span>{{$order->CancelOn->format('D')}}
                                                        {{$order->CancelOn->format('d')}}
                                                        {{$order->CancelOn->format('M')}} </span></li>
                                                @else
                                                <?php
$date1 = '';
if ($order->PackedOn) {
    $date2 = date('Y-m-d', strtotime("+1 day", strtotime($order->PackedOn)));
    $date3 = date('Y-m-d', strtotime("+1 day", strtotime($order->PackedOn)));
    $date4 = date('Y-m-d', strtotime("+2 day", strtotime($order->PackedOn)));
} elseif ($order->DispatchedOn) {
    $date3 = date('Y-m-d', strtotime("+1 day", strtotime($order->DispatchedOn)));
    $date4 = date('Y-m-d', strtotime("+2 day", strtotime($order->DispatchedOn)));
} elseif ($order->DeliveredOn) {
    $date1 = date('Y-m-d', strtotime("+1 day", strtotime($order->DeliveredOn)));
} else {

    $date2 = date('Y-m-d', strtotime("+1 day", strtotime($order->created_at->format('Y-m-d'))));
    $date3 = date('Y-m-d', strtotime("+1 day", strtotime($order->created_at->format('Y-m-d'))));
    $date4 = date('Y-m-d', strtotime("+2 day", strtotime($order->created_at->format('Y-m-d'))));
}
?>
                                                @if($order->PackedOn)
                                                <li class="active li2">
                                                    Packed <span>{{date("D", strtotime($order->PackedOn))}}
                                                        {{date("d", strtotime($order->PackedOn))}}
                                                        {{date("M", strtotime($order->PackedOn))}}</span></li>
                                                @else
                                                <li class="li2">
                                                    Packed <span>{{date("D", strtotime($date2))}}
                                                        {{date("d", strtotime($date2))}}
                                                        {{date("M", strtotime($date2))}}</span></li>
                                                @endif

                                                @if($order->DispatchedOn)
                                                <li class="active li3">
                                                    Shipped <span>{{date("D", strtotime($order->DispatchedOn))}}
                                                        {{date("d", strtotime($order->DispatchedOn))}}
                                                        {{date("M", strtotime($order->DispatchedOn))}}</span></li>
                                                @else
                                                <li class="li3">
                                                    Shipped <span>{{date("D", strtotime($date3))}}
                                                        {{date("d", strtotime($date3))}}
                                                        {{date("M", strtotime($date3))}}</span></li>
                                                @endif


                                                @if($order->DeliveredOn)
                                                <li class="active li4">
                                                    Delivered <span> Expected by,
                                                        {{date("D", strtotime($order->DeliveredOn))}}
                                                        {{date("d", strtotime($order->DeliveredOn))}}
                                                        {{date("M", strtotime($order->DeliveredOn))}} </span></li>
                                                @else
                                                <li class="li4">
                                                    Delivered <span> Expected by, {{date("D", strtotime($date4))}}
                                                        {{date("d", strtotime($date4))}}
                                                        {{date("M", strtotime($date4))}} </span></li>
                                                @endif
                                                @endif
                                            </ul>
                                        </div>

                                    </div>

                                    <!-- </div>
                                    <div class="cart-product mt-3"> -->
                                    <h4>Order Summary</h4>

                                    <h4>Order ID : NSRID-{{$order->id}}</h4>
                                    @foreach($order_products as $order_product)
                                    <?php
$product = \App\Product::where('product_code', '=', $order_product->Product_Code)->first();
?>
                                    <div class="product-details">
                                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                                            <div class="leftside-icons col-md-2 p-0">
                                                <a class="product-item-photo" title="Natural Power 500 mg Capsule 60's">
                                                    <?php
$product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
?>
                                                    @if($product_image)
                                                    <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}"
                                                        class="pro-img" alt="Nestor Immunity Care">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="rightside-details col pr-0">
                                                <div class="row m-0">
                                                    <div class="product-item-name col pl-0">
                                                        <a
                                                            href="{{route('frontend.product_detail',[$product->group->url_name,$product->group_category->url_name,$product->url_name])}}">{{$product->generic_name}}
                                                            ({{$product->brand_name}})</a>
                                                    </div>
                                                    <div class="item-prices col-3 p-0 text-right">
                                                        <div class="discount-val"><span
                                                                id="row_itmdiscprice_922086">Rs.{{number_format($order_product->Amount, 2)}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row m-0 mt-3">

                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0">
                                                            @if($product->Prescription_Required=='1')
                                                            <button class="tag-detail" style="background-color: #7bd9ba;color: white;display: inline-block;
    padding: 2px 10px;
    font-size: 12px;
    border-radius: 4px;
    margin-bottom: 10px;">Rx</button>
                                                            @endif
                                                            @if($product->package)
                                                            <span class="drug-varients ellipsis" style="white-space: nowrap;
  width: 220px;
  overflow: hidden;
  text-overflow: ellipsis;">
                                                                Packing:
                                                                @if(\Auth::user()->role=='Chemist')
                                                                {{$product->package->name}}
                                                                @else
                                                                {{$product->package->Packing_Description}}
                                                                @endif

                                                            </span>
                                                            @endif
                                                        </p>
                                                        <p class="form m-0">Per Unit Price: Rs.
                                                            {{number_format($order_product->Rate, 2)}} </p>
                                                    </div>
                                                    @if($order_product->Free_Qty)
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0" style="color:
                                                                 #d76666">You Get {{$order_product->Free_Qty}} Extra
                                                            Free Product With This Product
                                                        </p>
                                                    </div>
                                                    @endif
                                                    <div class="item-qty col-2 p-0">
                                                        <div>
                                                            <div
                                                                class="form-group justify-content-end align-select m-0">
                                                                <label for="QTY">QTY:
                                                                    {{$order_product->Order_Qty}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div>
                        <div class="totalamt-col">
                            <h4>ORDER DETAILS</h4>
                            <div class="allcalculation">
                                <div class="subtoal"><label _ngcontent-tlt-c6="">Subtotal Total</label><span
                                        id="cart_sub_total">Rs.{{number_format($order->Taxable_Amount, 2)}}</span></div>
                                <div class="shipping-charges"><label _ngcontent-tlt-c6="">GST Amount</label><span
                                        id="cart_del_charge">Rs.{{$order->Tax_Amount}}</span></div>
                                <div class="shipping-charges"><label _ngcontent-tlt-c6="">Delivery Charges</label><span
                                        id="cart_del_charge">Rs.{{number_format($order->Delivery_Amount, 2)}}</span>
                                </div>
                                <div class="net-amount"><label _ngcontent-tlt-c6="">Order Total</label><span
                                        id="cart_netpay_amt1">Rs.{{number_format($order->Grand_Total, 2)}}</span></div>
                                @if($order->wallet)
                                <div class="net-amount">
                                    <label _ngcontent-tlt-c6="">Wallet Amount</label>
                                    <span id="cart_netpay_amt1">-Rs.{{number_format($order->wallet, 2)}}</span>
                                </div>
                                @endif
                            </div>
                            <div class="process-col">
                                <div class="totalamt"><span class="text">Paid
                                        Amount</span><span
                                        class="save-price">Rs.{{number_format($order->Grand_Total, 2)}}</span></div>
                            </div>
                        </div>
                        @if($order->OrderStatus_Code==7)
                        <div class="deliveryby row m-0 mt-2">
                            <div class="remove-drug col-12 p-0 text-right">
                                <center>
                                    <a class="removeitem"
                                        href="{{route('dashboard.order_history',\Auth::user()->id)}}">Back</a>
                                    <a class="removeitem"
                                        href="{{route('backend.add_to_carts.customer_re_order',$order->id)}}">Re-Order</a>
                                </center>
                            </div>
                        </div>
                        @else
                        <div class="deliveryby row m-0 mt-2">
                            <div class="remove-drug col-12 p-0 text-right">
                                <center><a class="removeitem"
                                        href="{{route('dashboard.order_history',\Auth::user()->id)}}">Back</a> <a
                                        class="removeitem" href="{{route('backend.orders.order_cancel',$order->id)}}"
                                        title="Cancel Your Order"><em class="fa fa-times"></em> Cancel Your Order</a>
                                    <a class="removeitem"
                                        href="{{route('backend.add_to_carts.customer_re_order',$order->id)}}">Re-Order</a>
                                    @if($order->doctorappointment_id)
                                    <a class="removeitem"
                                        href="{{route('frontend.prescription_print',$order->doctorappointment_id)}}">Download
                                        Doctor Prescription
                                    </a>
                                    @endif

                                </center>
                            </div>
                        </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('frontend.include.footer')