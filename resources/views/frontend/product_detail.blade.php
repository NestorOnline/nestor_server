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
                @if(count($product_images))
                @foreach($product_images as $product_image)
                @if($product_image)
                <li>
                    <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}"
                        alt="Nestor Immunity Care">
                </li>
                @endif
                @endforeach
                @else
                <li>
                    <img src="{{asset('NoImage.webp')}}" alt="Nestor Immunity Care">
                </li>
                @endif
            </ul>
        </div>
        <div class="col-md-7">
            <div class="delivery-box-div">
                <h4>{{$product->generic_name}}</h4>
                <span class="tag-detail"
                    style="background: #7bd9ba;color: white">@if($category){{$category->name}}@endif</span>
                @if($product->Prescription_Required=='1')
                <span class="tag-detail" style="background: #7bd9ba;color: white">Rx</span>
                @endif
                @if($product->ProductBrand_Code==1)
                <p>{{$product->brand_name}}</p>
                @elseif($product->ProductBrand_Code==2)
                STERIHEAL
                @elseif($product->ProductBrand_Code==3)
                NECTARINE
                @endif
                @if($product->customer_mrp_price && $product->sales_schame_customer)
                <h4   style="color: #eb3b65">MRP: <s><em class="fa fa-inr"></em>
                    {{number_format($product->customer_mrp_price->Price, 2, '.', ',')}}/-
</s>
                </h4>
                @endif
               
                @if($product->customer_price)
                <?php
                $purchase_price = 0;
$current_price = $product->customer_price->Price + ($product->customer_price->Price * $product->customer_price->GST) / 100;
if ($product->sales_schame_customer) {
    $product->offer =$product->sales_schame_customer->SalesScheme_Name; 
    $purchase_price =$current_price -$current_price*$product->sales_schame_customer->Discount/100;
} else {
    $purchase_price = $current_price;
}
?>
                <h4 style="color: black">Price: <em class="fa fa-inr"></em>
                    {{number_format($purchase_price, 2, '.', ',')}}/-
                </h4>
                @else
                Coming Soon
                @endif


                @if($package)
                <p><b>Packing: </b>{{$package->Packing_Description}}</p>
                @endif
                @if($product->manufacture)
                <p><b>Mfr:</b> {{$product->manufacture}}</p>
                @endif
                <div class="row">
                    <div class="dia-bottom plus_minus_button{{$product->id}}">
                        @if($product->get_addtocart_item_guest($product->id))
                        <div class="qty-div">
                            <span class="qty_minus"
                                onclick="add_cart_from_search({{$product->id}},{{$purchase_price}},-1,{{$product->get_addtocart_item_guest($product->id)}})">-</span>
                            <input type="number" required="" id="Qty" name="Qty" class="qty_1" min="1"
                                value="{{$product->get_addtocart_item_guest($product->id)}}">
                            <span class="qty_plus"
                                onclick="add_cart_from_search({{$product->id}},{{$purchase_price}},1,{{$product->get_addtocart_item_guest($product->id)}})">+</span>
                        </div>
                        @else
                        @if($product->customer_price && $product->customer_mrp_price)
                        @if($product->stock_by_office($Global_Office_Code) &&
                        ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder >= 1))

                        <span class="book-now">
                            <a href="{{route('frontend.buy_now',$product->id)}}">Buy
                                Now</a>
                        </span>

                        <span class="book-now" style="padding: 20px"><button class="book-now-cart" type="button"
                                onclick="add_cart_from_search({{$product->id}},{{$purchase_price}},1,0)">
                                <b>Add to Cart</b></button>
                        </span>


                        @else
                        <span class="book-now" style="color: #eb3b65">Out of Stock &nbsp;&nbsp;
                            <button class="book-now-cart" type="button" onclick="notify_me_function({{$product->id}})">
                                Notify Me</button>
                        </span>

                        @endif
                        @else
                        <div class="col-md-6">
                            <span style="color: #eb3b65;height: 35px">Coming Soon</span>
                            <!-- <span class="book-now"><a
                                        href="javascript:void(0);" data-product_code="{{$product->product_code}}"
                                        data-toggle="modal" data-target="#notify_model"
                                        onclick="modal_function(this);">Notify
                                        Me</a></span> -->
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
                <div class="row">
                    @if($product->sales_schame)
                    <div class="col-md-6 mt-3">
                        <div>
                            <div class="offers-box">
                                <h5>Applicable Offers</h5>
                                <p><em class="fa fa-tag"></em> Buy {{$sales_scheme->NextMinSaleQty_ForScheme}} Get
                                    {{$sales_scheme->Free_Qty}} Free</p>
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
$pincode_value = request()->cookie('zip_code');
$pin_code = json_decode($pincode_value);

?>
                                                @if($pin_code)
                                                <input type="number" class="form-control" id="pincode_value"
                                                    value="{{$pin_code}}"
                                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                    type="number" maxlength="6" placeholder="Enter delivery pincode">
                                                @else
                                                <input type="number" class="form-control" id="pincode_value"
                                                    value="110001"
                                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                    type="number" maxlength="6" placeholder="Enter delivery pincode">
                                                @endif
                                                <span class="input-group-text b-unset" id="basic-addon1"><a
                                                        class="font-14" href="javascript:void(0);"
                                                        onclick="calc()">check</a></span>
                                                @if($pin_code)
                                                <?php
                                                $delivery_date = date("Y-m-d", strtotime("+2  day"));
                                                ?>
                                                <span class="input-group-text" id="pincode_check_data"
                                                    style="color: #003579;"><a class="font-14">Delivery by
                                                        {{date("M d", strtotime("+2  day"))}} </a></span>
                                                @else
                                                <span class="input-group-text" id="pincode_check_data"
                                                    style="color: #003579;"><a class="font-14">Delivery by
                                                        {{date("M d", strtotime("+2  day"))}} </a></span>
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
                <!-- <p>Sold by <span style="color: #328cad">Nestor Pharmaceuticals Limited </span> and Fulfilled by <span style="color: #328cad">Nestor</span>.</p> -->
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
        <?php
 $single_product = \App\Broughtalsoproduct::where('Prodoct_Code',$product->product_code)->first();
 if($single_product){
    $brought_also_product_lists = \App\Broughtalsoproduct::where('link_group',$single_product->link_group)->get();
    $brought_also_products = \App\Product::where('Prescription_Required','!=',1)->where('go_live',1)->whereIn('product_code',$brought_also_product_lists->map(function($brought_also){
        return $brought_also->Link_Prodoct_Code;
        }))->get();
 }  else{
    $brought_also_products =[];
 }     

        ?>
        <div class="col-md-4">
            <div class="product-side-list">
                @if(count($brought_also_products))
                <div class="delivery-box-div mt-3">
                    <h4>Advisory for customers on additional products for enhanced body & health care</h4>
                    @foreach($brought_also_products as $prod)
                    @if($product->product_code!=$prod->product_code)
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
                            <h6><a href="{{route('frontend.product_detail',[$prod->group->url_name,$prod->group_category->url_name,$prod->url_name])}}">{{$prod->generic_name}} ({{$prod->brand_name}})</a></h6>

                            <p class="m-0"><b>
                                    <?php
$purchase_price = 0;
?>
                                    @if($prod->customer_price)
                                    <?php
                $purchase_price = 0;
$current_price = $prod->customer_price->Price + ($prod->customer_price->Price * $prod->customer_price->GST) / 100;
if ($prod->sales_schame_customer) {
    $prod->offer =$prod->sales_schame_customer->SalesScheme_Name; 
    $purchase_price =$current_price -$current_price*$prod->sales_schame_customer->Discount/100;
} else {
    $purchase_price = $current_price;
}
?>
                                    Price
                                    <i class="fa fa-inr"></i>
                                    {{number_format($purchase_price, 2, '.', '')}}
                                </b>
                                @else
                                @endif
                                @if($prod->sales_schame_customer && $prod->customer_mrp_price)
                                <span class="price"  style="color: #eb3b65">
                                    <strong> &nbsp;MRP: <i class="fa fa-inr"></i>
<s>{{$prod->customer_mrp_price->Price}}</s>
</strong>
</span>
<!-- <span class="save">(save upto {{$prod->sales_schame_customer->SalesScheme_Name}})</span> -->
                                    @endif
                            </p>
                            
                        <br>
                        <div class="plus_minus_button{{$prod->id}}">
                            @if($prod->get_addtocart_item_guest($prod->id))
                            <div class="qty-div">
                                <span class="qty_minus" data-id="1"
                                    onclick="add_cart_from_search({{$prod->id}},{{$purchase_price}},-1,{{$prod->get_addtocart_item_guest($prod->id)}})">-</span>
                                <input type="number" required="" id="Qty" name="Qty" class="qty_1" min="1"
                                    value="{{$prod->get_addtocart_item_guest($prod->id)}}">
                                <span class="qty_plus" data-id="1"
                                    onclick="add_cart_from_search({{$prod->id}},{{$purchase_price}},1,{{$prod->get_addtocart_item_guest($prod->id)}})">+</span>
                            </div>
                            @else
                            @if($prod->customer_price && $prod->customer_mrp_price)
                            @if($prod->stock_by_office($Global_Office_Code) &&
                            ($prod->stock_by_office($Global_Office_Code)->QtyForNewOrder >= 1))
                            <span class="book-now"><a href="{{route('frontend.buy_now',$prod->id)}}">Buy
                                    Now</a></span>
                            <span class="book-now"><button class="book-now-cart" type="button"
                                    onclick="add_cart_from_search({{$prod->id}},{{$purchase_price}},1,0)"><b>Add
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
                    @endif
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
            <h6>SIMILAR</h6>
            <h5>Recommended Products</h5>
            <!-- <p><small>Free home sample collection for all health checkups</small></p> -->
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
text-overflow: ellipsis;">@if($prod->ProductBrand_Code==1)
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
  text-overflow: ellipsis;">{{$package->Packing_Description}}</span>
                            @endif
                        </div>
                        <div class="diag-price">

                            @if($product->customer_price)
                            <span class="price" style="color: black"><b>
                                    <?php
$purchase_price = 0;
?>
                                    @if($prod->customer_price)
                                    <?php
$current_price = $prod->customer_price->Price + ($prod->customer_price->Price * $prod->customer_price->GST) / 100;
if ($prod->sales_schame_customer) {
    $prod->offer =$prod->sales_schame_customer->SalesScheme_Name; 
    $purchase_price =$current_price -$current_price*$prod->sales_schame_customer->Discount/100;
} else {
}
?>
                                    Price
                                    <i class="fa fa-inr"></i>
                                    {{number_format($purchase_price, 2, '.', '')}}
                                    @else
                                    @endif
                                </b>
                            </span>
                            @endif
                            @if($prod->sales_schame_customer && $prod->customer_mrp_price)
                                <span class="price"  style="color: #eb3b65">
                                    <strong> &nbsp;MRP: <i class="fa fa-inr"></i>
<s>{{$prod->customer_mrp_price->Price}}</s>
</strong>
</span>
<!-- <span class="save">(save upto {{$prod->sales_schame_customer->SalesScheme_Name}})</span> -->
                                    @endif
                        </div>
                        <div class="dia-bottom plus_minus_button{{$prod->id}}">
                            @if($prod->get_addtocart_item_guest($prod->id))
                            <div class="qty-div">
                                <span class="qty_minus" data-id="1"
                                    onclick="add_cart_from_search({{$prod->id}},{{$purchase_price}},-1,{{$prod->get_addtocart_item_guest($prod->id)}})">-</span>
                                <input type="number" required="" id="Qty" name="Qty" class="qty_1" min="1"
                                    value="{{$prod->get_addtocart_item_guest($prod->id)}}">
                                <span class="qty_plus" data-id="1"
                                    onclick="add_cart_from_search({{$prod->id}},{{$purchase_price}},1,{{$prod->get_addtocart_item_guest($prod->id)}})">+</span>
                            </div>
                            @else
                            @if($prod->customer_price && $prod->customer_mrp_price)
                            @if($prod->stock_by_office($Global_Office_Code) &&
                            ($prod->stock_by_office($Global_Office_Code)->QtyForNewOrder >= 1))
                            <span class="book-now"><a href="{{route('frontend.buy_now',$prod->id)}}">Buy
                                    Now</a></span>
                            <span class="book-now"><button class="book-now-cart" type="button"
                                    onclick="add_cart_from_search({{$prod->id}},{{$purchase_price}},1,0)"><b>Add
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
                        @if(count($product_images))
                        @foreach($product_images as $xyz1=>$product_image)
                        @if($xyz1==0)

                        <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}"
                            class="w-100" alt="Nestor Immunity Care">
                        @endif
                        @endforeach
                        @else
                        <img src="{{asset('NoImage.webp')}}" class="w-100" alt="Nestor Immunity Care">
                        @endif
                    </div>
                    <div class="col-md-11">
                        <h6><a href="">
                                @if($product->ProductBrand_Code==1)
                                {{$product->generic_name}} ({{$product->brand_name}})
                                @else
                                {{$product->brand_name}}
                                @endif
                            </a></h6>
                        <?php
$purchase_price = 0;
?>
                        @if($product->customer_price)
                        <?php
$current_price = $product->customer_price->Price + ($product->customer_price->Price * $product->customer_price->GST) / 100;
if ($product->sales_schame_customer) {
    $product->offer =$product->sales_schame_customer->SalesScheme_Name; 
    $purchase_price =$current_price -$current_price*$product->sales_schame_customer->Discount/100;
} else {
}
?>
                        <p class="m-0">
                            <b>Price
                                <i class="fa fa-inr"></i>
                                {{number_format($purchase_price, 2, '.', '')}}</b>
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-2 ">
                <button type="button" class="add-to-cart"
                    onclick="add_cart_from_search({{$product->id}},{{$purchase_price}},1,0)">Add to Cart</button>
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


<script>
$(document).ready(function() {
    $(".add-to-your-cart").click(function() {
        var product_id = $("#product_id").val();
        var Qty = $("#Qty").val();
        var amount = $("#amount").val();

        $.ajax({
            url: "/add_to_carts/add_cart/",
            data: {
                product_id: product_id,
                Qty: Qty,
                amount: amount
            },
            type: "GET",
            success: function(data) {
                $("#add_card_view").html(data);
                console.log(data);
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
                console.log(data);
            }
        });
    } else {
        $("#pincode_check_data").html(" ");
    }
}
</script>