@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container">
        <div id="card_view">

            <?php
$gst_amount = 0;
$mrp_total = 0;
$total = 0;
$add_cart_data_total = 0;

?>
            <?php
$add_to_cards_qty_sum = 0;
foreach ($add_cart_datas as $add_cart_data) {
    $add_cart_data_total = $add_cart_data_total + $add_cart_data->amount * $add_cart_data->Qty + $add_cart_data->amount * $add_cart_data->Qty * 12 / 100;
    $add_to_cards_qty_sum = $add_to_cards_qty_sum + $add_cart_data->Qty;
}
$add_cart_data_total = $add_cart_data_total + 50;

if ($add_cart_datas == null) {
    $add_cart_datas = [];
}
$date1 = date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))));
$date5 = date('Y-m-d', strtotime("+4 day", strtotime(date('Y-m-d'))));

?>
            @include('flash')
            @if(count($add_cart_datas))

            <br>
            <div class="row" style="background: white;">

                <div class="col-md-2">
                    <br>
                    <h2>My Cart</h2>
                </div>
                <div class="col-md-10 hidden-xs">
                    <br>
                    <div class="product-details" style="height: 100px; width: 100%">
                        <div class="steps-from">
                            <ul class="steps-ul list-unstyled">
                                <li class="active li1">My Cart <span></span></li>
                                <li class="li2">Upload Prescription<span> </span></li>
                                <li class="li3"> Checkout<span></span></li>
                                <li class="li4">Payment <span> </span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="py-3">
                    <h3>Cart Items (<span id="cart_items">{{$add_to_cards_qty_sum}}</span>)
                        @if($order_setting->MinimumOrderValueForCustomer > $add_cart_data_total)
                        <span id="minimum_order_value" style="margin-left: 200px;color: #eb3b65">Get free delivery on orders above 
Rs. {{$order_setting->MinimumOrderValueForCustomer}}/- </span>
                        @else
                        <span id="minimum_order_value" style="margin-left: 200px;color: #eb3b65; display: none">Get free delivery on orders above 
Rs. {{$order_setting->MinimumOrderValueForCustomer}}/</span>
                        @endif
                    </h3>
                </div>
            </div>
            <div class="col-md-8">
                <div>
                    <div>
                        <div>
                            <div class="cart-product">
                                <h4>Order Summary</h4>


                                @foreach($add_cart_datas as $key=>$add_cart_data)
                                <?php
$subtotal = 0;
$product_cart = \App\Product::find($add_cart_data->product_id);
$subtotal = $add_cart_data->amount * $add_cart_data->Qty;
$total = $total + $subtotal;
$sales_scheme = \App\SalesScheme::where('Product_Code', '=', $product_cart->product_code)->first();

if ($product_cart->customer_mrp_price) {
    $mrp_total = $mrp_total + $product_cart->customer_mrp_price->Price * $add_cart_data->Qty;
    $gst_amount = 0;
}

?>
                                <div class="product-details delete_mem{{$add_cart_data->product_id}}">
                                    <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                                        <div class="leftside-icons col-md-2 p-0">
                                            <a class="product-item-photo" title="{{$product_cart->brand_name}}">
                                                <?php
$product_image = \App\Productimage::where('Product_Code', '=', $product_cart->product_code)->first();
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
                                                        href="{{route('frontend.product_detail',[$product_cart->group->url_name,$product_cart->group_category->url_name,$product_cart->url_name])}}">{{$product_cart->generic_name}}
                                                        ({{$product_cart->brand_name}})</a>
                                                </div>
                                                <div class="item-prices col-2 p-0 text-right">
                                                    <div class="discount-val"><span id="row_itmdiscprice_922086"><b
                                                                style="color: black">Rs.{{number_format($subtotal, 2, '.', ',')}}</b></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row m-0 mt-3">
                                                <div class="catag-name col pl-0">
                                                    <!--<p class="form m-0">Mfr: Nestor Pharmaceuticals Limited</p>-->
                                                    <p class="form m-0">
                                                        @if($product_cart->Prescription_Required=='1')
                                                        <button class="tag-detail" style="background-color: #7bd9ba;color: white;display: inline-block;
    padding: 2px 10px;
    font-size: 12px;
    border-radius: 4px;
    margin-bottom: 10px;">Rx</button>
                                                        @endif
                                                        @if($product_cart->package)
                                                        <span class="drug-varients ellipsis" style="white-space: nowrap;
  width: 220px;
  overflow: hidden;
  text-overflow: ellipsis;">Packing: {{$product_cart->package->Packing_Description}}
                                                        </span>
                                                        @endif
                                                    </p>
                                                    <p class="form m-0"> <b style="color: black">Price : Rs.
                                                            {{number_format($add_cart_data->amount, 2, '.', ',')}}/-</b>
                                                    </p>
                                                    @if($sales_scheme)
                                                    <?php
$dividend = $add_cart_data->Qty;

$divisor = $sales_scheme->NextMinSaleQty_ForScheme;
$output = intdiv($dividend, $divisor);
$produc_qty = $output * $sales_scheme->Free_Qty;
?>
                                                    @if($produc_qty > 0)
                                                    <p class="form m-0" style="color: #d76666"><b>You Will Get Free
                                                            {{$produc_qty}} Extra Product With This Product</b></p>
                                                    @endif
                                                    @endif
                                                </div>
                                                <div class="item-qty col-3 p-0">
                                                    <div>
                                                        <div class="form-group align-select m-0">
                                                            <h5>QTY:- </h5>
                                                            <div class="qty-div">
                                                                <span class="qty_minus"
                                                                    data-id="{{$add_cart_data->product_id}}"
                                                                    onclick="quantity{{$add_cart_data->product_id}}_change_minus()">-</span>
                                                                <input type="number" required="" name="Qty"
                                                                    class="qty_{{$add_cart_data->product_id}}" min="1"
                                                                    max="10"
                                                                    onchange="quantity{{$add_cart_data->product_id}}_change()"
                                                                    value="{{$add_cart_data->Qty}}"
                                                                    id="quantity_id{{$add_cart_data->product_id}}">
                                                                <span class="qty_plus"
                                                                    data-id="{{$add_cart_data->product_id}}"
                                                                    onclick="quantity{{$add_cart_data->product_id}}_change_plus()">+</span>
                                                            </div>
                                                            <input type="hidden"
                                                                id="product_id{{$add_cart_data->product_id}}"
                                                                value="{{$product_cart->id}}">
                                                            <input type="hidden"
                                                                id="price_amount{{$add_cart_data->product_id}}"
                                                                value="{{number_format($add_cart_data->amount, 2, '.', ',')}}">
                                                            @if($product_cart->customer_price)
                                                            <input type="hidden" id="gst{{$add_cart_data->product_id}}"
                                                                value="{{number_format($product_cart->customer_price->GST, 2, '.', ',')}}">
                                                            @endif
                                                            @if($product_cart->customer_mrp_price)
                                                            <input type="hidden"
                                                                id="mrp_product_price{{$add_cart_data->product_id}}"
                                                                value="{{number_format($product_cart->customer_mrp_price->Price, 2, '.', ',')}}">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="deliveryby row m-0 mt-2">
                                                <div class="date deldate col pl-0">
                                                    <!-- <div class="deliveryby"> Delivery between
                                                            {{date("M", strtotime($date1))}}
                                                            {{date("d", strtotime($date1))}}-
                                                            {{date("M", strtotime($date5))}}
                                                            {{date("d", strtotime($date5))}}
                                                        </div> -->
                                                </div>
                                                <div class="remove-drug col-2 p-0 text-right">
                                                    <input type="hidden" id="sub_total{{$add_cart_data->product_id}}"
                                                        class="form-control" name="total_amt"
                                                        value="{{number_format($subtotal, 2, '.', ',')}}">
                                                    <button type="button"
                                                        class="removeitem{{$add_cart_data->product_id}}"
                                                        onclick="remove{{$add_cart_data->product_id}}_function()"
                                                        value="{{$add_cart_data->product_id}}"
                                                        title="Remove item">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                            <br>
                            <center>
                                <h3><a href="{{route('home')}}">Continue Shopping</a></h3>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <?php

$grand_total = 0;
$check_amount = 0;
$sub_grand_total1 = 0;
$cart_total_charge = 0;
$sub_grand_total1 = $total + $gst_amount;
if($sub_grand_total1>500){
    $delevery_charge = 0;
}else{
    $delevery_charge = 50;
}


$check_amount = $total + $gst_amount + $delevery_charge;
$cart_total_charge = $total + $gst_amount + $delevery_charge;
if ($sub_grand_total1 > $order_setting->MinimumOrderValueForCustomer) {
    $grand_total = $total + $gst_amount + $delevery_charge - $wallet;
} else {
    $grand_total = $total + $gst_amount + $delevery_charge;
}

?>
            <div class="col-md-4">
                <div>
                    <div class="totalamt-col">
                        <h4>ORDER DETAILS</h4>
                        <div class="allcalculation">
                            <div class="subtoal" style="display: none"><label _ngcontent-tlt-c6="">Total
                                    MRP</label><span>Rs.<span
                                        id="mrp_total">{{number_format($mrp_total, 2, '.', ',')}}</span></span>
                            </div>
                            <div class="subtoal"><label _ngcontent-tlt-c6="">Item Amount</label><span>Rs.<span
                                        id="cart_sub_total">{{number_format($total, 2, '.', ',')}}</span></span>
                            </div>
                            <div class="shipping-charges" style="display: none"><label _ngcontent-tlt-c6="">GST
                                    Amount</label><span>Rs.<span id="gst_amount">
                                        {{number_format($gst_amount, 2, '.', ',')}}</span></span></div>
                            <div class="shipping-charges"><label _ngcontent-tlt-c6="">Delivery
                                    Charges</label><span>Rs.<span id="cart_del_charge">
                                        {{number_format($delevery_charge, 2, '.', ',')}}</span></span></div>
                        </div>
                        <div class="allcalculation">
                            <div class="shipping-charges"><label _ngcontent-tlt-c6="">Order
                                    Value</label><span>Rs.<span id="cart_total_charge">
                                        {{number_format($cart_total_charge, 2, '.', ',')}}</span></div>


                        </div>
                        <div class="process-col">
                            <div class="totalamt">
                                <span class="text">Payable
                                    Amount</span><span class="save-price">Rs.<span class="save-price"
                                        id="grand_total_amount">
                                        @if($grand_total < 0) 0 @else {{number_format($grand_total, 2, '.', ',')}}
                                            @endif </span></span>
                            </div>
                        </div>
                      
                        <div class="p-3" id="payment_button">
                            <a href="{{route('frontend.checkout')}}" class="add-to-cart">Continue for payment</a>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
        @else
        <div>
            <img src="{{asset('empty_cart11.png')}}" style="width: 100%">
            <span class="book-now"><a href="{{route('home')}}" class="btn btn-sm btn-block">Back To Home Page</a>
            </span>
        </div>
        @endif

    </div>
    <div id="empty_card_view" style="display: none">
        <img src="{{asset('empty_cart11.png')}}" style="width: 100%">
        <span class="book-now"><a href="{{route('home')}}" class="btn btn-sm btn-block">Back To Home Page</a></span>
    </div>
</div>
</div>
@include('frontend.include.footer')
<script>
$(document).ready(function() {
    $('#glasscase').glassCase({
        'thumbsPosition': 'left',
        'widthDisplay': 450,
        'heightDisplay': 400
    });
    $('.quantity').selectpicker();
});
</script>
@foreach($add_cart_datas as $key=>$add_cart_data)
<script type="text/javascript">
function remove{{$add_cart_data->product_id}}_function() {
    var cart_items = document.getElementById("cart_items").innerHTML;
    var price_amount = $("#price_amount{{$add_cart_data->product_id}}").val();
    var price_amount = parseFloat(price_amount.replace(',', '').replace(' ', ''));
    var mb = document.getElementById("cart_sub_total").innerHTML;
    var mb = parseFloat(mb.replace(',', '').replace(' ', ''));
    var grand_total = document.getElementById("grand_total_amount");
    var remove_key = $(".removeitem{{$add_cart_data->product_id}}").val();
    var sub_total = $("#sub_total{{$add_cart_data->product_id}}").val();
    var sub_total = parseFloat(sub_total.replace(',', '').replace(' ', ''));
    var gst = $("#gst{{$add_cart_data->product_id}}").val();
    $.ajax({
        url: "/add_to_carts/remove_cart",
        data: {
            remove_key: remove_key,
            sub_total: sub_total
        },
        type: "GET",
        success: function(data) {
            $("#add_card_view").html(data);
            var cart_total_charge = document.getElementById("cart_total_charge").innerHTML;
            var cart_total_charge = parseFloat(cart_total_charge.replace(',', '').replace(' ', ''));

            var user_wallet = 0;
            var cart_sub_total = mb - sub_total;
            var gst_amount_value = 0;
            if (user_wallet) {

            } else {
                var user_wallet = 0;
            }
            var OrderSetting = '<?php echo $order_setting->MinimumOrderValueForCustomer; ?>';
            var cart_total_charge = cart_sub_total + gst_amount_value;
                if(cart_total_charge>OrderSetting){
                var cart_del_charge = 0;
                document.getElementById("cart_del_charge").innerHTML = thousands_separators((cart_del_charge).toFixed(2));  
            }else{
                var cart_del_charge = 50;
                document.getElementById("cart_del_charge").innerHTML = thousands_separators((cart_del_charge).toFixed(2));
            }
            var cart_total_charge = cart_sub_total + gst_amount_value + cart_del_charge;
            if (cart_sub_total < OrderSetting) {
                $("#payment_button").show();
                $("#minimum_order_value").show();
            }
            var grand_total_amount = cart_total_charge - user_wallet;
            var Qty = $("#quantity_id{{$add_cart_data->product_id}}").val();
            var mrp_total = document.getElementById("mrp_total").innerHTML;
            var mrp_total = parseFloat(mrp_total.replace(',', '').replace(' ', ''));
            var mrp_product_price = $("#mrp_product_price{{$add_cart_data->product_id}}").val();
            var mrp_product_price = parseFloat(mrp_product_price.replace(',', '').replace(' ', ''));
            var mrp_total = mrp_total - mrp_product_price;
            document.getElementById("mrp_total").innerHTML = thousands_separators((mrp_total).toFixed(
                2));
            document.getElementById("cart_sub_total").innerHTML = thousands_separators((cart_sub_total)
                .toFixed(2));
            document.getElementById("grand_total_amount").innerHTML = thousands_separators((
                grand_total_amount).toFixed(2));
            document.getElementById("gst_amount").innerHTML = thousands_separators((gst_amount_value)
                .toFixed(2));
            document.getElementById("cart_items").innerHTML = cart_items - 1;
            document.getElementById("cart_total_charge").innerHTML = thousands_separators((
                cart_total_charge).toFixed(2));
            $(".delete_mem" + remove_key).remove();
            if (cart_sub_total == "0") {
                $('#empty_card_view').css('display', 'block');
                $('#card_view').css('display', 'none');
            }
        }
    });
}
</script>

<script type="text/javascript">
function quantity{{$add_cart_data->product_id}}_change() {
    var cart_items = document.getElementById("cart_items").innerHTML;
    var price_amount = $("#price_amount{{$add_cart_data->product_id}}").val();
    var Qty = $("#quantity_id{{$add_cart_data->product_id}}").val();
    var product_id = $("#product_id{{$add_cart_data->product_id}}").val();
    var key_value = "{{$add_cart_data->product_id}}";
    var mb = document.getElementById("cart_sub_total");
    var grand_total = document.getElementById("grand_total_amount");
    var sub_total = $("#sub_total{{$add_cart_data->product_id}}").val();
    var gst = $("#gst{{$add_cart_data->product_id}}").val();
    $.ajax({
        url: "/add_to_carts/change_qty",
        data: {
            Qty: Qty,
            key_value: key_value,
            product_id: product_id
        },
        type: "GET",
        success: function(data) {
            var cart_total_charge = document.getElementById("cart_total_charge").innerHTML;
            var user_wallet = document.getElementById("user_wallet").innerHTML;
            var cart_sub_total = mb.innerHTML - sub_total + Qty * price_amount;
            var gst_amount_value = 0;
            if (user_wallet) {

            } else {
                var user_wallet = 0;
            }
            var cart_total_charge = cart_sub_total + gst_amount_value;
            var OrderSetting = '<?php echo $order_setting->MinimumOrderValueForCustomer; ?>';
                if(cart_total_charge>OrderSetting){
                var cart_del_charge = 0;
                document.getElementById("cart_del_charge").innerHTML = thousands_separators((cart_del_charge).toFixed(2));  
            }else{
                var cart_del_charge = 50;
                document.getElementById("cart_del_charge").innerHTML = thousands_separators((cart_del_charge).toFixed(2));
            }
            var cart_total_charge = cart_sub_total + gst_amount_value + cart_del_charge;
            var grand_total_amount = cart_total_charge - user_wallet;
            var update_subtotal = Qty * price_amount;
            document.getElementById("cart_sub_total").innerHTML = (cart_sub_total).toFixed(2);
            document.getElementById("grand_total_amount").innerHTML = (grand_total_amount).toFixed(2);
            document.getElementById("total_amount_update").innerHTML = (grand_total_amount).toFixed(2);
            document.getElementById("Qty_update{{$add_cart_data->product_id}}").innerHTML = Qty;
            document.getElementById("gst_amount").innerHTML = (gst_amount_value).toFixed(2);
            document.getElementById("cart_items").innerHTML = cart_items - Qty;
            $(".delete_mem{{$add_cart_data->product_id}}").html(data);
        }
    });

}
</script>

<script type="text/javascript">
function quantity{{$add_cart_data->product_id}}_change_minus() {
    var cart_items = document.getElementById("cart_items").innerHTML;
    var gst_amount = document.getElementById("gst_amount");
    var price_amount = $("#price_amount{{$add_cart_data->product_id}}").val();
    var price_amount = parseFloat(price_amount.replace(',', '').replace(' ', ''));
    var Qty = Number($("#quantity_id{{$add_cart_data->product_id}}").val());
    var product_id = $("#product_id{{$add_cart_data->product_id}}").val();
    var key_value = "{{$add_cart_data->product_id}}";
    var mb = document.getElementById("cart_sub_total").innerHTML;
    var mb = parseFloat(mb.replace(',', '').replace(' ', ''));
    var sub_total = $("#sub_total{{$add_cart_data->product_id}}").val();
    var sub_total = parseFloat(sub_total.replace(',', '').replace(' ', ''));
    var gst = $("#gst{{$add_cart_data->product_id}}").val();
              if (Qty > 1) {
    var Qty = Number.parseInt(Qty)-1;
        $.ajax({
            url: "/add_to_carts/change_qty",
            data: {
                Qty: Qty,
                key_value: key_value,
                product_id: product_id
            },
            type: "GET",
            success: function(data) {
                var cart_total_charge = document.getElementById("cart_total_charge").innerHTML;
                var cart_total_charge = parseFloat(cart_total_charge.replace(',', '').replace(' ', ''));
                var user_wallet = 0;
                var cart_sub_total = mb - sub_total + Qty * price_amount;
                var gst_amount_value = 0;
                if (user_wallet) {

                } else {
                    var user_wallet = 0;
                }
                var cart_total_charge = cart_sub_total + gst_amount_value + 0;
                var OrderSetting = '<?php echo $order_setting->MinimumOrderValueForCustomer; ?>';
                if(cart_total_charge>OrderSetting){
                var cart_del_charge = 0;
                document.getElementById("cart_del_charge").innerHTML = thousands_separators((cart_del_charge).toFixed(2));  
            }else{
                var cart_del_charge = 50;
                document.getElementById("cart_del_charge").innerHTML = thousands_separators((cart_del_charge).toFixed(2));
            }
            var cart_total_charge = cart_sub_total + gst_amount_value + cart_del_charge;
                if (cart_sub_total < OrderSetting) {
                    $("#payment_button").show();
                    $("#minimum_order_value").show();
                }
                var grand_total_amount = cart_total_charge - user_wallet;
                var update_subtotal = Qty * price_amount;
                var mrp_total = document.getElementById("mrp_total").innerHTML;
                var mrp_total = parseFloat(mrp_total.replace(',', '').replace(' ', ''));
                var mrp_product_price = $("#mrp_product_price{{$add_cart_data->product_id}}").val();
                var mrp_product_price = parseFloat(mrp_product_price.replace(',', '').replace(' ', ''));
                var mrp_total = mrp_total - mrp_product_price;
                document.getElementById("mrp_total").innerHTML = thousands_separators((mrp_total)
                    .toFixed(2));
                document.getElementById("cart_sub_total").innerHTML = thousands_separators((
                    cart_sub_total).toFixed(2))
                document.getElementById("grand_total_amount").innerHTML = thousands_separators((
                    grand_total_amount).toFixed(2));
                document.getElementById("total_amount_update").innerHTML = thousands_separators((
                    grand_total_amount).toFixed(2));
                document.getElementById("Qty_update{{$add_cart_data->product_id}}").innerHTML = Qty;
                document.getElementById("gst_amount").innerHTML = thousands_separators((
                    gst_amount_value).toFixed(2));
                document.getElementById("cart_total_charge").innerHTML = thousands_separators((
                    cart_total_charge).toFixed(2));
                    document.getElementById("cart_items").innerHTML = parseInt(cart_items) - 1;
                    document.getElementById("counter-number").innerHTML = parseInt(cart_items) - 1;
                $(".delete_mem{{$add_cart_data->product_id}}").html(data);
            }
        });
    }
}
</script>
<script type="text/javascript">
function quantity{{$add_cart_data->product_id}}_change_plus() {
    var cart_items = document.getElementById("cart_items").innerHTML;
    var gst_amount = document.getElementById("gst_amount");
    var price_amount = $("#price_amount{{$add_cart_data->product_id}}").val();
    var price_amount = parseFloat(price_amount.replace(',', '').replace(' ', ''));
    var Qty = Number($("#quantity_id{{$add_cart_data->product_id}}").val()) + 1;
    var product_id = $("#product_id{{$add_cart_data->product_id}}").val();
    var key_value = "{{$add_cart_data->product_id}}";
    var mb = document.getElementById("cart_sub_total").innerHTML;
    var mb = parseFloat(mb.replace(',', '').replace(' ', ''));
    var sub_total = $("#sub_total{{$add_cart_data->product_id}}").val();
    var sub_total = parseFloat(sub_total.replace(',', '').replace(' ', ''));
    var gst = $("#gst{{$add_cart_data->product_id}}").val();
    $.ajax({
        url: "/add_to_carts/change_qty",
        data: {
            Qty: Qty,
            key_value: key_value,
            product_id: product_id
        },
        type: "GET",
        success: function(data) {
            var cart_total_charge = document.getElementById("cart_total_charge").innerHTML;
            var cart_total_charge = parseFloat(cart_total_charge.replace(',', '').replace(' ', ''));
            var user_wallet = 0;
            var cart_sub_total = mb - sub_total + Qty * price_amount;
            var gst_amount_value = 0;
            if (user_wallet) {} else {
                var user_wallet = 0;
            }
            var cart_total_charge = cart_sub_total + gst_amount_value;
            var OrderSetting = '<?php echo $order_setting->MinimumOrderValueForCustomer; ?>';
            if(cart_total_charge>OrderSetting){
                var cart_del_charge = 0;
                document.getElementById("cart_del_charge").innerHTML = thousands_separators((0).toFixed(2));  
            }else{
                var cart_del_charge = 50;
                document.getElementById("cart_del_charge").innerHTML = thousands_separators((50).toFixed(2));
            }
            if (cart_sub_total > OrderSetting) {
                $("#payment_button").show();
                $("#minimum_order_value").show();
            }
            var cart_total_charge = cart_sub_total + gst_amount_value + cart_del_charge;
            var grand_total_amount = cart_total_charge - user_wallet;
            var update_subtotal = Qty * price_amount;
            var mrp_total = document.getElementById("mrp_total").innerHTML;
            var mrp_total = parseFloat(mrp_total.replace(',', '').replace(' ', ''));
            var mrp_product_price = $("#mrp_product_price{{$add_cart_data->product_id}}").val();
            mrp_product_price = parseFloat(mrp_product_price.replace(',', '').replace(' ', ''));
            var mrp_total = mrp_total + mrp_product_price;
            document.getElementById("mrp_total").innerHTML = thousands_separators((mrp_total).toFixed(
                2));
            document.getElementById("cart_sub_total").innerHTML = thousands_separators((cart_sub_total)
                .toFixed(2))
            document.getElementById("grand_total_amount").innerHTML = thousands_separators((
                grand_total_amount).toFixed(2));
            document.getElementById("total_amount_update").innerHTML = thousands_separators((
                grand_total_amount).toFixed(2));
            document.getElementById("Qty_update{{$add_cart_data->product_id}}").innerHTML = Qty;
            document.getElementById("gst_amount").innerHTML = thousands_separators((gst_amount_value)
                .toFixed(2));
            document.getElementById("cart_total_charge").innerHTML = thousands_separators((
                cart_total_charge).toFixed(2));
                document.getElementById("cart_items").innerHTML = parseInt(cart_items) + 1;
                document.getElementById("counter-number").innerHTML = parseInt(cart_items) + 1;
            $(".delete_mem{{$add_cart_data->product_id}}").html(data);
        }
    });

}
</script>
@endforeach

<script>
function thousands_separators(num) {
    var num_parts = num.toString().split(".");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return num_parts.join(".");
}
</script>

