@include('frontend.include.head')
@include('frontend.include.header')
<?php
$category = \App\Category::find($product->category_id);
$group = \App\Group::find($product->group_id);
$groupcategory = \App\Groupcategory::find($product->groupcategory_id);
$category = \App\Category::find($product->category_id);
$package = \App\Package::find($product->package_id);
?>
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
            <div class="delivery-box-div">
                <h4>{{$product->brand_name}}</h4>
                @if($category)
                <span class="tag-detail"
                    style="background: #7bd9ba;color: white">@if($category){{$category->name}}@endif</span>
                @endif
                @if($product->Prescription_Required=='1')
                <span class="tag-detail" style="background: #7bd9ba;color: white">Rx</span>
                @endif
                @if($product->customer_mrp_price)
                <h4>M.R.P.: <em class="fa fa-inr"></em> <s>
                        {{number_format($product->customer_mrp_price->Price, 2, '.', ',')}}/-
                    </s> <b>(Incl. GST)</b></small></h4>
                @endif
                <?php
$purchase_price = 0;
?>

                @if($product->customer_price)
                <?php
$purchase_price = $product->customer_price->Price + ($product->customer_price->Price * $product->customer_price->GST) / 100;
?>
                <h3>Price: <em class="fa fa-inr"></em> <span style="color: #ea5858">
                        {{number_format($purchase_price, 2, '.', ',')}}/-
                        excl. GST</span></h3>
                @else
                <h3>Price: <span style="color: #ea5858">
                        Coming Soon
                    </span></h3>
                @endif


                @if($package)
                <p><b>Packaging:</b>{{$package->Packing_Description}}</p>
                @endif
                @if($product->manufacture)
                <p><b>Mfr:</b> {{$product->manufacture}}</p>
                @endif
                @if($product->customer_price && $product->customer_mrp_price)
                @if($product->stock_by_office($Global_Office_Code) &&
                ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder >= 1))
                <h5>QTY:- </h5>
                @endif
                @endif
                <form action="{{route('frontend.buy_now',$product->id)}}" method="get">
                    <div class="row">
                        @if($product->customer_price && $product->customer_mrp_price)
                        @if($product->stock_by_office($Global_Office_Code) &&
                        ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder >= 1))
                        <div class="col-md-3">
                            <div class="qty-div">
                                <span class="qty_minus" data-id="1">-</span>
                                <input name="Qty" type="number" required="" id="Qty" class="qty_1" min="1" value="1">
                                <span class="qty_plus" data-id="1">+</span>
                            </div>
                        </div>

                        <div class="col-md-3 ">
                            <div>
                                @if($product->customer_price)
                                <input type="hidden" id="amount" value="{{$purchase_price}}">
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
                                <span style="color: #eb3b65; font-size: 1.6em">Out of Stock</span>
                            </div>
                        </div>
                        @endif
                        @else
                        <div class="col-md-12">
                            <div>
                                <span style="color: #eb3b65; font-size: 1.6em">Coming Soon</span>
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
                                                        placeholder="Enter delivery pincode" value="110001"
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
                <?php
$expire_date = \App\Stock::where('Product_Code', '=', $product->product_code)->first();
?>
                @if($expire_date)
                <p><b>Before Date: </b> {{$expire_date->EXP_Date->format('d')}} {{$expire_date->EXP_Date->format('M')}}
                    {{$expire_date->EXP_Date->format('Y')}}</p>
                @endif
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
            @if(count($products))
            <div class="product-side-list">
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

                            <p class="m-0"><em class="fa fa-inr"></em>
                                @if($product->customer_price)
                                {{$product->customer_price->Price}}
                                @endif
                            </p>
                            <p class="m-0">Save upto 5%</p>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
            @endif
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
                            @if($prod->ProductBrand_Code==1)
                            {{$prod->generic_name}} ({{$prod->brand_name}})
                            @else
                            {{$prod->brand_name}}
                            @endif
                        </div>
                        <div class="diag-price" style="height: 30px">
                            <span class="final_price"><s>
                                    @if($prod->customer_mrp_price)
                                    MRP
                                    <i class="fa fa-inr"></i>
                                    {{number_format($prod->customer_mrp_price->Price, 2, '.', '')}}
                                    @else
                                    @endif
                                </s>
                            </span>
                            <span class="price">
                                @if($prod->customer_price)
                                Your Price
                                <i class="fa fa-inr"></i>
                                {{number_format($prod->customer_price->Price, 2, '.', '')}}
                                @else
                                @endif
                            </span>

                        </div>
                        <div class="diag-price" style="height: 30px">
                            <span class="price">
                                @if($prod->customer_price && $prod->customer_mrp_price)
                                <?php
$discount = 0.00;
$discount = ($prod->customer_mrp_price->Price - $prod->customer_price->Price) * 100 / $prod->customer_mrp_price->Price;
?>
                                Discount {{number_format($discount, 2, '.', ',')}}%

                                @else
                                Discount Update Soon
                                @endif
                            </span>


                            @if($prod->sales_schame)
                            <span class="save">(Buy {{$prod->sales_schame->NextMinSaleQty_ForScheme}} Get
                                {{$prod->sales_schame->Free_Qty}} Free)</span>
                            @endif
                        </div>
                        <div class="dia-bottom plus_minus_button{{$prod->id}}">
                            @if($product->get_addtocart_item)
                            <div class="qty-div">
                                <span class="qty_minus" data-id="1"
                                    onclick="add_cart_from_search({{$product->id}},{{$product->customer_price->Price}},-1,,{{$product->get_addtocart_item->Qty}})">-</span>
                                <input type="number" required="" id="Qty" name="Qty" class="qty_1" min="1"
                                    value="{{$product->get_addtocart_item->Qty}}">
                                <span class="qty_plus" data-id="1"
                                    onclick="add_cart_from_search({{$product->id}},{{$product->customer_price->Price}},1,,{{$product->get_addtocart_item->Qty}})">+</span>
                            </div>
                            @else
                            @if($prod->customer_price && $prod->customer_mrp_price)
                            @if($prod->stock_by_office($Global_Office_Code) &&
                            ($prod->stock_by_office($Global_Office_Code)->QtyForNewOrder >= 1))
                            <span class="book-now"><a href="{{route('frontend.buy_now',$prod->id)}}">Buy
                                    Now</a></span>
                            <span class="book-now"><button class="book-now-cart" type="button"
                                    onclick="add_cart_from_search({{$prod->id}},{{$prod->customer_price->Price}},1,0)"><b>Add
                                        to Cart</b></button></span>
                            @else
                            <span style="color: #eb3b65;height: 35px">Out of Stock</span>
                            @endif
                            @else
                            <span style="color: #eb3b65;height: 35px">Coming Soon</span>
                            <!-- <span class="book-now"><a
                                        href="javascript:void(0);" data-product_code="{{$prod->product_code}}"
                                        data-toggle="modal" data-target="#notify_model"
                                        onclick="modal_function(this);">Notify
                                        Me</a></span> -->
                            @endif
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


                        @if($product->customer_price)
                        <p class="m-0"><em class="fa fa-inr"></em>
                            {{number_format($product->customer_price->Price, 2, '.', '')}}
                        </p>
                        @else
                        Coming Soon
                        @endif

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
            url: "/add_to_carts/add_cart_user/",
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
            url: "/add_to_carts/add_cart_user/",
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
        alert(pincode);
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