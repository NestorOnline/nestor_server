@include('frontend.include.head')
@include('frontend.include.header')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="breadcrumbs">
                <ul class="items">
                    <?php
$single_group = \App\Group::where('id', '=', $product->group_id)->first();
$single_groupcategory = \App\Groupcategory::where('id', '=', $product->groupcategory_id)->first();
?>
                    <li class="home"> <a href="{{route('home')}}" title="Go to Home"> Home </a> </li>
                    <li class="home"> <a href="{{route('frontend.group_page',$single_group->url_name)}}"
                            title="Go to {{$single_group->name}}"> {{$single_group->name}} </a> </li>
                    <li class="home"> <a
                            href="{{route('frontend.groupcategory_page',[$single_group->url_name,$single_groupcategory->url_name])}}"
                            title="Go to {{$single_groupcategory->name}}"> {{$single_groupcategory->name}} </a> </li>
                    <li class="home"> <a
                            href="{{route('frontend.product_detail',[$product->group->url_name,$product->group_category->url_name,$product->url_name])}}"
                            title="Go to {{$product->brand_name}}"> {{$product->brand_name}} </a> </li>
                </ul>
            </div>
        </div>
        <div class="col-md-5">
            <ul id="glasscase" class="gc-start">
                <?php
$product_images = \App\Productimage::where('Product_Code', '=', $product->product_code)->get();

?>
                @foreach($product_images as $product_image)
                @if($product_image)
                <li>
                    <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}"
                        alt="Nestor Immunity Care">
                </li>
                @endif
                @endforeach
            </ul>
        </div>
        <div class="col-md-7">
            <?php
$total = 0;
$category = \App\Category::find($product->category_id);
$chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
$mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();
if ($chemist_product_price) {
    $total = $chemist_product_price->Price + $chemist_product_price->Price * $chemist_product_price->GST / 100;
}
$package = \App\Package::find($product->package_id);
?>

            <div class="delivery-box-div">
                <h4>{{$product->generic_name}}</h4>
                @if($category)
                <span class="tag-detail"
                    style="background: #7bd9ba;color: white">@if($category){{$category->name}}@endif</span>
                @endif
                @if($product->Prescription_Required=='1')
                <span class="tag-detail" style="background: #7bd9ba;color: white">Rx</span>
                @endif
                <div class="row">
                    <div class="col-md-5">
                        <p>{{$product->brand_name}}</p>
                        @if($package)
                        <p><b>Packing : {{$package->name}} </b></p>
                        @endif
                        @if($product->manufacture)
                        <p><b>Mfr:</b> {{$product->manufacture}}</p>
                        @endif
                        @if($product->mrp_price)
                        <h4 style="color: black">MRP: <em class="fa fa-inr"></em>
                            {{number_format($product->mrp_price->Price, 2, '.', ',')}}/-

                        </h4>
                        @endif
                        @if($product->chemist_price)
                        <h4 style="color: black">Purchase Price: <em class="fa fa-inr"></em> <span>
                                {{number_format($total, 2, '.', ',')}}/-</span></h4>

                        <?php
$margin = 0;
if ($product->chemist_price && $product->mrp_price) {
    $margin = ($product->mrp_price->Price - $total) * 100 / $total;
} else {

}
?>
                        @if($product->chemist_price&&$product->mrp_price)
                        <h4 style="color: #C91a1a">Profit Margin on MRP: <span>
                                {{number_format($margin, 2, '.', ',')}}%
                            </span></h4>
                        @else
                        <h4 style="color: #C91a1a">Profit Margin on MRP: <span>
                                Wll Update
                            </span></h4>
                        @endif
                        @endif

                    </div>
                    <div class="col-md-7">
                        <!-- @if(count($comparative_products))
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="2">Competitive Price to Retailer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comparative_products as $comparative_product)
                                <tr>
                                    <td>
                                        @if($comparative_product->manufacturer_single)
                                        {{$comparative_product->manufacturer_single->name}}
                                        @endif
                                    </td>
                                    <td>{{$comparative_product->price}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif -->
                    </div>
                </div>

                @if($product->customer_price && $product->customer_mrp_price)
                @if($product->stock_by_office($Global_Office_Code) &&
                ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder >= 1))
                <h5>QTY:- </h5>
                @endif
                @endif
                <form action="{{route('frontend.buy_now',$product->id)}}" method="get">
                    <div class="row">

                        @if($product->chemist_price && $product->mrp_price)
                        @if($product->stock_by_office($Global_Office_Code) &&
                        ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder >= 1))

                        <div class="col-md-3">
                            <div class="qty-div">
                                <span class="qty_minus">-</span>
                                <input type="number" required="" id="Qty" name="Qty" class="qty_1" min="1" value="1">
                                <span class="qty_plus">+</span>
                            </div>
                        </div>

                        <div class="col-md-3 ">
                            <div>
                                @if($chemist_product_price)
                                <input type="hidden" id="amount" value="{{$chemist_product_price->Price}}">
                                @else
                                <input type="hidden" id="amount" value="0">
                                @endif
                                <input type="hidden" id="product_id" value="{{$product->id}}">

                                <button type="button" class="add-to-cart add-to-your-cart">Add to Cart</button>
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <div>
                                <button type="submit" class="add-to-cart">Buy Now</button>
                            </div>
                        </div>
                        @else
                        <div class="col-md-6">
                            <div>
                                <span class="book-now"><a href="javascript:void(0);"
                                        data-product_code="{{$product->product_code}}" data-toggle="modal"
                                        data-target="#notify_model" onclick="modal_function(this);">Notify
                                        Me</a>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div>
                                <span style="color: #eb3b65; font-size: 1.2em">Out of Stock</span>
                            </div>
                        </div>
                        @endif
                        @else
                        <div class="col-md-12">
                            <div>
                                <span style="color: #eb3b65; font-size: 1.2em">Coming Soon</span>
                            </div>
                        </div>
                        @endif
                        @if($product->sales_schame)
                        <div class="col-md-6 mt-3">
                            <div>
                                <div class="offers-box">
                                    <h5>Applicable Offers</h5>
                                    <p><em class="fa fa-tag"></em> Buy
                                        {{$product->sales_schame->NextMinSaleQty_ForScheme}} Get
                                        {{$product->sales_schame->Free_Qty}} Free</p>
                                    <p><small>If You Buy One Then You Could Get One Free</small></p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($product->stock_by_office($Global_Office_Code) &&
                        ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder >= 1))
                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <div class="delivery-box">
                                        <div>
                                            <p><em class="fa-map-marker fa"></em> Delivery to :</p>
                                            <div class="input-group">
                                                <div class="input-group-prepend delivery-input">

                                                    <?php
$pincode = \App\Address::where('user_id', '=', \Auth::user()->id)
    ->where('set_as_a_default', '=', 'Yes')
    ->where('set_as_a_current', '=', 'Yes')
    ->first();
?>
                                                    @if($pincode)
                                                    <input type="number" class="form-control" id="pincode_value"
                                                        value="{{$pincode->PIN ?? ''}}" maxlength="6"
                                                        placeholder="Enter delivery pincode" aria-label="Username"
                                                        aria-describedby="">

                                                    @else
                                                    <input type="number" class="form-control" id="pincode_value"
                                                        value="110001" placeholder="Enter delivery pincode"
                                                        maxlength="6" aria-label="Username" aria-describedby="">
                                                    @endif
                                                    <span class="input-group-text b-unset" id="basic-addon1"><a
                                                            class="font-14" href="javascript:void(0);"
                                                            onclick="calc()">check</a></span>
                                                    @if($pincode)
                                                    <?php
$delivery_date = date("Y-m-d", strtotime("+4  day"));
?>
                                                    <span class="input-group-text" id="pincode_check_data"
                                                        style="color: #003579;"><a class="font-14">Delivery by
                                                            {{date("y M D", strtotime("+4  day"))}} | Free
                                                            ₹50</a></span>
                                                    @else
                                                    <span class="input-group-text" id="pincode_check_data"
                                                        style="color: #003579;"><a class="font-14">Delivery by
                                                            {{date("y M D", strtotime("+4  day"))}} | Free
                                                            ₹50</a></span>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="delivery-box">
                                        <div class="delivery-img mr-3">
                                            <img src="img/icons/truck.png" alt="">
                                        </div>
                                        <div>
                                            <p>Delivery charges may apply</p>


                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <p style="color: #1daf63"><b>In stock</b></p>
                        @endif

                    </div>
                </form>
                @if($product->is_display_expiry=='1')
                <p><b>Before Date: </b> {{$product->best_before_date->format('d')}}
                    {{$product->best_before_date->format('M')}} {{$product->best_before_date->format('Y')}}</p>
                @endif
                <!--<p>Sold by <span style="color: #328cad">Nestor Pharmaceuticals Limited </span> and Fulfilled by <span style="color: #328cad">Nestor</span>.</p>-->
            </div>
        </div>
        <div class="col-md-8">
            <div class="">
                <div class="delivery-box-div mt-3 pro-det">
                    @if($descriptiontypes)
                    @foreach($descriptiontypes as $descriptiontype)
                    <?php
$descriptions = \App\Description::where('product_code', '=', $product->product_code)->where('description_type_code', '=', $descriptiontype->id)->get();
?>
                    @if(count($descriptions))
                    <h4>{{$descriptiontype->name}}</h4>
                    <ul class="pl-5">
                        @foreach($descriptions as $description)
                        @if($description->description=='0')

                        @else
                        <li>{{$description->description}}</li>
                        @endif
                        @endforeach
                    </ul>
                    @endif
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="product-side-list">
                @if(count($products))
                <div class="delivery-box-div mt-3">
                    <h4>Related Products</h4>
                    @foreach($products as $prod)
                    <div class="row other-sec-devide">
                        <div class="col-md-2 p-2">
                            <?php
$product_image = \App\Productimage::where('Product_Code', '=', $prod->product_code)->first();
?>
                            @if($product_image)
                            <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}"
                                alt="" class="w-100">
                            @endif
                        </div>
                        <div class="col-md-10">
                            <h6><a href="">{{$prod->brand_name}}</a></h6>
                            <?php
$chemist_product_price = \App\Productprice::where('Product_Code', '=', $prod->product_code)->where('ProductPriceType_Code', '=', '7')->first();
?>
                            <p class="m-0"><em class="fa fa-inr"></em>
                                @if($chemist_product_price)
                                {{$chemist_product_price->Price}}
                                @endif
                            </p>
                            <p class="m-0">Save upto 5%</p>
                        </div>
                    </div>
                    @endforeach

                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@if(count($products))
<div class="container-fluid">
    <div class="card-sec">
        <div class="h-pettern text-center">
            <h6>SIMILER</h6>
            <h5>Recommended Products</h5>
            <p><small>Free home sample collection for all health checkups</small></p>
        </div>
        <div>
            <div class="owl-carousel owl-theme owl-cards">
                @foreach($products as $prod)
                <div class="item">
                    <div class="diag-section">
                        <span class="diag-img">
                            <a
                                href="{{route('frontend.product_detail',[$prod->group->url_name,$prod->group_category->url_name,$prod->url_name])}}">
                                <?php
$product_image = \App\Productimage::where('Product_Code', '=', $prod->product_code)->first();
?>
                                @if($product_image)
                                <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}"
                                    class="img-responsive category_image" alt="Nestor Immunity Care">
                                @endif
                            </a>
                        </span>
                        <div class="diag-txt">
                            <span class="clsgetname ellipsis" style="display: -webkit-box;
-webkit-line-clamp: 2;
-webkit-box-orient: vertical;
overflow: hidden;
text-overflow: ellipsis;height: 40px">@if($prod->ProductBrand_Code==1)
                                {{$prod->generic_name}} ({{$prod->brand_name}})
                                @else
                                {{$prod->brand_name}}
                                @endif</span>
                            <?php
$package = \App\Package::find($prod->package_id);
?>
                            @if($package)
                            <span class="drug-varients ellipsis" style="white-space: nowrap;
  width: 220px;
  overflow: hidden;
  text-overflow: ellipsis;height: 25px">Packing : {{$package->name}}</span>
                            @endif
                        </div>



                        <div class="diag-price" style="height: 30px;" style="">
                            <span class="price" style="color:black">
                                @if($product->mrp_price)
                                MRP
                                <i class="fa fa-inr"></i>
                                {{number_format($product->mrp_price->Price, 2, '.', ',')}}
                                @endif
                            </span>
                        </div>
                        <div class="diag-price" style="height: 30px;color:black">
                            <span class="price" style="color:black">
                                <?php
$total = 0;
?>
                                @if($prod->chemist_price)
                                <?php

$total = $prod->chemist_price->Price + $prod->chemist_price->Price * $prod->chemist_price->GST / 100;
?>
                                Purchase Price
                                <i class="fa fa-inr"></i>
                                {{number_format($prod->chemist_price->Price, 2, '.', ',')}}
                                @else
                                @endif
                            </span>
                        </div>
                        <div class="diag-price" style="height: 30px">
                            <span class="price">
                                @if($prod->chemist_price && $prod->mrp_price)
                                <?php
$margin = 0.00;
$margin = ($prod->mrp_price->Price - $total) * 100 / $total;
?>
                                <strong> Margin {{number_format($margin, 2, '.', ',')}}% </strong>

                                @else
                                <strong> Margin Update Soon</strong>
                                @endif
                            </span>


                            @if($prod->sales_schame)
                            <span class="save">(Buy {{$prod->sales_schame->NextMinSaleQty_ForScheme}} Get
                                {{$prod->sales_schame->Free_Qty}} Free)</span>
                            @endif
                        </div>
                        <div class="dia-bottom plus_minus_button{{$prod->id}}" style="height: 50px">
                            @if($prod->chemist_price && $prod->mrp_price)
                            @if($prod->stock_by_office($Global_Office_Code) &&
                            ($prod->stock_by_office($Global_Office_Code)->QtyForNewOrder >= 1))
                            <span class="book-now"><a href="{{route('frontend.buy_now',$prod->id)}}">Buy
                                    Now</a></span>
                            <span class="book-now"><button class="book-now-cart" type="button"
                                    onclick="add_cart_from_search({{$prod->id}},{{$prod->chemist_price->Price}},1,0)"><b>Add
                                        to Cart</b></button></span>
                            @else
                            <span style="color: #eb3b65">Out of Stock &nbsp;&nbsp;
                                <button class="book-now-cart" type="button" onclick="notify_me_function({{$prod->id}})">
                                    Notify Me</button>
                            </span>
                            @endif
                            @else
                            <span style="color: #eb3b65;height: 35px">Coming Soon</span>

                            <!-- <span class="book-now"><a
                                        href="javascript:void(0);" data-product_code="{{$prod->product_code}}"
                                        data-toggle="modal" data-target="#notify_model"
                                        onclick="modal_function(this);">Notify
                                        Me</a></span> -->
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
<div class="add-to-cart-fix">
    <div class="fix-card">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-1 p-2">
                        <img src="{{asset($product->image)}}" alt="" class="w-100">
                    </div>
                    <div class="col-md-11">
                        <h6><a href="">{{$product->generic_name}} ({{$product->brand_name}})</a></h6>

                        <p class="m-0"><em class="fa fa-inr"></em>
                            @if($product->chemist_price)
                            Rs. {{number_format($product->chemist_price->Price, 2, '.', ',')}}
                            @else
                            Coming Soon
                            @endif

                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-2 ">
                <button type="button" class="add-to-cart add-to-your-cart">Add to Cart</button>
            </div>
        </div>
    </div>
</div>
@include('frontend.include.footer')
<script src="js/zoom.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#glasscase').glassCase({
        'thumbsPosition': 'left',
        'widthDisplay': 450,
        'heightDisplay': 400
    });
    $('#exampleFormControlSelect1').selectpicker();
});
</script>

@foreach($products as $prod)
<script>
$(document).ready(function() {
    $(".add-to-your-cart{{$prod->id}}").click(function() {
        var product_id = $(".product_id{{$prod->id}}").val();
        var Qty = $(".Qty{{$prod->id}}").val();
        var amount = $(".amount{{$prod->id}}").val();

        $.ajax({
            url: "/add_to_carts/add_cart_chemist/",
            data: {
                product_id: product_id,
                Qty: Qty,
                amount: amount
            },
            type: "GET",
            success: function(data) {
                $("#add_card_view").html(data);
                $(".cart-dropdown").show();
                $('.cart-dropdown').delay(3000).hide(0);

            }
        });
    });
});
</script>
@endforeach

<script>
$(document).ready(function() {
    $(".add-to-your-cart").click(function() {
        var product_id = $("#product_id").val();
        var Qty = $("#Qty").val();
        var amount = $("#amount").val();

        $.ajax({
            url: "/add_to_carts/add_cart_chemist/",
            data: {
                product_id: product_id,
                Qty: Qty,
                amount: amount
            },
            type: "GET",
            success: function(data) {
                $("#add_card_view").html(data);
                $(".cart-dropdown").show();
                $('.cart-dropdown').delay(3000).hide(0);

            }
        });
    });
});
</script>

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
            }
        });
    } else {
        $("#pincode_check_data").html(" ");
    }
}
</script>