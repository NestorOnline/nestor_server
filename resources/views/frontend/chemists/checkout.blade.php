@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container">
        <div>
            <br>
            <div class="row" style="background: white;">

                <div class="col-md-2">
                    <br>

                    <h2>Checkout</h2>
                </div>
                <div class="col-md-10 hidden-xs">
                    <br>
                    <div class="product-details" style="height: 100px">
                        <div class="steps-from">
                            <ul class="steps-ul list-unstyled">
                                <li class="active li1">My Cart <span></span></li>
                                <li class="active li2">Checkout<span> </span></li>
                                <li class="li3"> Payment<span></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            @include('flash')
            <div class="row">

                <div class="col-md-8">
                    <div>
                        <div>
                            <div>
                                <div class="cart-product">
                                    <h4>MEDICINES</h4>
                                    <?php
$total = 0;
$gst_amount = 0;
$mrp_total = 0;
$date1 = date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))));
$date5 = date('Y-m-d', strtotime("+4 day", strtotime(date('Y-m-d'))));
?>
                                    @foreach($add_to_cards as $add_cart_data)
                                    <?php
$mrp_subtotal = 0;
$subtotal = 0;
$product_cart = \App\Product::find($add_cart_data->product_id);
$package = \App\Package::find($product_cart->package_id);
$subtotal = $add_cart_data->amount * $add_cart_data->Qty;
$total = $total + $subtotal;
$sales_scheme = \App\SalesScheme::where('Product_Code', '=', $product_cart->product_code)->first();
if ($product_cart->mrp_price) {
    $mrp_subtotal = $product_cart->mrp_price->Price * $add_cart_data->Qty;
    $mrp_total = $mrp_total + $product_cart->mrp_price->Price * $add_cart_data->Qty;
}

if ($product_cart->chemist_price) {
    $gst_amount = $gst_amount + $subtotal * $product_cart->chemist_price->GST / 100;
}

?>
                                    <div class="product-details">
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
                                                    <div class="item-prices text-right">
                                                        <div class="discount-val"><span id="row_itmdiscprice_922086"
                                                                style="color: black"></span>
                                                            <span class="final_price" style="color: black">
                                                                @if($subtotal)
                                                                <b> Rs.{{number_format($subtotal, 2, '.', ',')}}</b>
                                                                @else
                                                                @endif

                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--<div class="row m-0 mt-2">-->
                                                <!--    <div class="catag-name col pl-0">-->
                                                <!--        <p class="form m-0">Mfr: Numinous Products Pvt Ltd</p>-->
                                                <!--    </div>-->
                                                <!--</div>-->
                                                <div class="row m-0 mt-1">
                                                    <div class="catag-name col pl-0">
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
  text-overflow: ellipsis;">Packing:
                                                                {{$product_cart->package->name}}
                                                            </span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                @if($sales_scheme)
                                                <?php
$dividend = $add_cart_data->Qty;

$divisor = $sales_scheme->NextMinSaleQty_ForScheme;
$output = intdiv($dividend, $divisor);
$produc_qty = $output * $sales_scheme->Free_Qty;
?>
                                                @if($produc_qty > 0)
                                                <div class="row m-0 mt-1">
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0" style="color: #d76666"><b>You Will Get Free
                                                                {{$produc_qty}} Extra Product With This Product</b></p>
                                                    </div>
                                                </div>

                                                @endif
                                                @endif
                                                <div class="row m-0 mt-1">
                                                    <div class="date deldate col pl-0">
                                                        <div class="deliveryby"><b>Quantity :-
                                                                {{$add_cart_data->Qty}}</b>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="deliveryby row m-0 mt-2">

                                                    <div class="date deldate col pl-0">
                                                        <div class="deliveryby">

                                                            @if($product_cart->mrp_price)
                                                            <span class="final_price" style="color: black"><b> MRP :
                                                                    Rs.{{$product_cart->mrp_price->Price}} |Purchase
                                                                    price : Rs.{{$add_cart_data->amount}}</b><span>
                                                                    @endif
                                                        </div>
                                                    </div>
                                                    <div class="item-qty col-5 p-0">
                                                        <div>
                                                            <div class="form-group m-0 text-right">
                                                                <div class="deliveryby" style="display: none">
                                                                    Dispatched in 2 to 3 days </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="cart-product mt-3">
                                    <h4>Delivery Address</h4>
                                    <div class="product-details" id="Add_address">
                                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                                            <div class="rightside-details col pr-0">
                                                @if($address)
                                                @if($address->Contact_Person&&$address->Address1&&$address->City_Code &&
                                                $address->PIN&&$address->State_Code)
                                                <input type="hidden" id="address_id" value="1">
                                                <div class="row m-0">
                                                    <div class="product-item-name col pl-0">
                                                        <a href="#">{{$address->Contact_Person}}</a>
                                                    </div>
                                                </div>
                                                <div class="row m-0 mt-2">
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0">{{$address->Address1}}</p>
                                                    </div>
                                                </div>
                                                <div class="row m-0 mt-2">
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0">{{$address->Address2}}</p>
                                                    </div>
                                                </div>
                                                @if($address->Address3)
                                                <div class="row m-0 mt-2">
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0">{{$address->Address3}}</p>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="row m-0 mt-1">
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0">
                                                            <?php
$city = \App\City::find($address->City_Code);
$state = \App\State::find($address->State_Code);
?>
                                                            @if($city)
                                                            {{$city->name}}
                                                            @endif
                                                            ( {{$address->PIN}} ),
                                                            @if($state)
                                                            {{$state->name}}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="deliveryby row m-0 mt-2">
                                                    <div class="date deldate col pl-0">
                                                        <div class="deliveryby">+91 {{$address->Mobile_No}}</div>
                                                    </div>
                                                    <div class="item-prices col-2 p-0 text-right">
                                                        <!-- <div class="discount-val"><a href="{{route('dashboard.delivery_address',\Auth::user()->id)}}" ><span>Change</span></a></div> -->
                                                        <div class="discount-val"><a href="javascript:void(0)"
                                                                data-toggle="modal" data-target="#modify_address"><span
                                                                    id="row_itmdiscprice_922086">Change</span></a></div>

                                                    </div>
                                                </div>
                                                @else
                                                <div class="row m-0">
                                                    <div class="product-item-name col pl-0">
                                                        <!-- /    <a href="javascript:void(0)" data-toggle="modal" data-target="#modify_address"><span id="row_itmdiscprice_922086">Add Address</span></a> -->
                                                        <a href="{{route('dashboard.add_address')}}"
                                                            class="btn btn-sm btn-info">Add Address</a>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="address_id" value="0">
                                                @endif
                                                @else
                                                <div class="row m-0">
                                                    <div class="product-item-name col pl-0">
                                                        <!-- /    <a href="javascript:void(0)" data-toggle="modal" data-target="#modify_address"><span id="row_itmdiscprice_922086">Add Address</span></a> -->
                                                        <a href="{{route('dashboard.add_address')}}"
                                                            class="btn btn-sm btn-info">Add Address</a>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="address_id" value="0">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
$grand_total = 0;
$delevery_charge = 0;
$cart_total_charge = 0;
$cart_total_charge = $total + $gst_amount + $delevery_charge;

$grand_total = $cart_total_charge - $wallet - $reward;
?>
                <div class="col-md-4">
                    <div>
                        <div class="totalamt-col">
                            <h4>ORDER DETAILS</h4>
                            <div class="allcalculation">
                                <div class="subtoal"><label _ngcontent-tlt-c6="">Total MRP</label><span>Rs.<span
                                            id="mrp_total"> {{number_format($mrp_total, 2, '.', ',')}}</span></span>
                                </div>
                                <div class="subtoal"><label _ngcontent-tlt-c6="">Item Amount</label><span
                                        id="cart_sub_total">Rs. {{number_format($total, 2, '.', ',')}}</span></div>
                                @if($wallet>100)
                                <div class="shipping-charges"><label _ngcontent-tlt-c6="">Rewards</label><span
                                        id="cart_del_charge">- {{$wallet}}</span></div>
                                @elseif($reward)
                                <div class="shipping-charges"><label _ngcontent-tlt-c6="">Redeem Reward
                                        Points</label><span id="cart_del_charge">- {{$reward}}</span></div>
                                @else

                                @endif
                                <div class="shipping-charges"><label _ngcontent-tlt-c6="">GST Amount</label><span
                                        id="gst_amount">Rs. {{number_format($gst_amount, 2, '.', ',')}}</span></div>
                                <div class="shipping-charges"><label _ngcontent-tlt-c6="">Delivery Charges</label><span
                                        id="cart_del_charge">Rs. 0.00</span></div>
                            </div>
                            <div class="allcalculation">
                                <div class="shipping-charges"><label _ngcontent-tlt-c6="">Order Value</label><span
                                        id="cart_del_charge">Rs.
                                        {{number_format($cart_total_charge, 2, '.', ',')}}</span></div>

                            </div>
                            <div class="process-col">
                                <div class="totalamt"><span class="text">Payable
                                        Amount</span><span class="save-price">Rs.
                                        @if($grand_total < 0) 0 @else {{number_format($grand_total, 2, '.', '')}} @endif
                                            </span>
                                </div>
                            </div>
                            <div class="p-3">
                                @if($address)
                                @if($address->Contact_Person&&$address->Address1&&$address->City_Code&&$address->PIN&&$address->State_Code)
                                <a href="{{route('payment.pay')}}?reward={{$reward}}" class="add-to-cart">Pay</a>
                                @else
                                <a type="button" class="add-to-cart" id="check_address">Pay</a>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modify_address" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Change Address</h3>
            </div>
            <div class="modal-body">
                <div class="select-add-box">
                    <div class="row">
                        <?php
$addresses = \App\Address::whereNotNull('Address1')->where('user_id', '=', \Auth::user()->id)->get();
?>
                        @foreach($addresses as $address)
                        <div class="col-md-12">
                            <label for=""><b>{{$address->Contact_Person}}</b>&#160; &#160; &#160; &#160;
                                &#160;{{$address->Mobile_No}}</label>
                            <div class="input-group mb-5">
                                <div>
                                    <span class="basic-addon1"></span>
                                    <p class="form m-0">
                                        @if($address->Address1)
                                        <b>{{$address->Address1}},</b>
                                        @endif
                                        @if($address->Address2)
                                        <b>{{$address->Address2}},</b>
                                        @endif
                                        @if($address->Address3)
                                        <b>{{$address->Address3}},</b>
                                        @endif

                                        <?php
$city = \App\City::find($address->City_Code);
?>

                                        @if($city)
                                        <b>{{$city->name}},</b>
                                        @else
                                        <b>{{$address->city}},</b>
                                        @endif

                                        <?php
$state = \App\State::find($address->State_Code);
?>

                                        @if($state)
                                        <b>{{$state->name}}</b>
                                        @else
                                        <b>{{$address->state}}</b>
                                        @endif

                                        @if($address->PIN)
                                        <b>-{{$address->PIN}}</b>
                                        @endif
                                    </p>
                                    @if($address->set_as_a_default=='Yes' && $address->set_as_a_current=='Yes' )
                                    <p class="pull-right" style="color: #00cc99">Primary Delivery Address</p>
                                    @else
                                    <p class="pull-right"><a href="{{route('dashboard.set_as_a_current',$address->id)}}"
                                            style="color: #ea2732">Set As A Current</a></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a type="button" href="javascript:void(0)" onclick="myFunction()" class="btn btn-primary">Save
                    Address</a>
                <a type="button" href="javascript:void(0)" class="btn btn-secondary" id="cancel-btn"
                    data-dismiss="modal">Cancel</a>
            </div>
        </div>
    </div>
</div>

@include('frontend.include.footer')
<script>
function calc() {
    var pincode = document.getElementById('pincode_value').value;
    if (pincode.length == 6) {

        $.ajax({
            url: "/frontend/pincode/check",
            data: {
                pincode: pincode
            },
            type: "GET",
            success: function(data) {
                $("#pincode_check_data").html(data);
                console.log(data);
            }
        });
    } else {
        $("#pincode_check_data").html(" ");
    }
}
</script>

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
<script>
function myFunction() {

    var Contact_Person = document.getElementById('Contact_Person_value').value;

    var Address1 = document.getElementById('address_value1').value;
    var address2 = document.getElementById('address_value2').value;
    var pincode = document.getElementById('pincode_value').value;
    var city = document.getElementById('city_value').value;
    var state = document.getElementById('state_value').value;
    var phone_no = document.getElementById('phone_no_value').value;

    if (pincode.length == 6) {

        $.ajax({
            url: "/frontend/add_address",
            data: {
                Contact_Person: Contact_Person,
                Address1: Address1,
                address2: address2,
                pincode: pincode,
                city: city,
                state: state,
                phone_no: phone_no
            },
            type: "GET",
            success: function(data) {
                $("#Add_address").html(data);
                document.getElementById("cancel-btn").click();
            }
        });
    } else {
        $("#pincode_check_data").html(" ");
    }
}
</script>

<script>
$(document).ready(function() {
    $("#check_address").click(function() {
        var Address = document.getElementById('address_id').value;
        if (Address == 1) {
            location.replace("http://{{$host}}/payment/pay");
        } else {
            alert('Please Add Your Address');
        }

    });
});
</script>