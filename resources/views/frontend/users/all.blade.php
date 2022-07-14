@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <ul class="items">
                        <li class="home"> <a href="{{route('home')}}" title="Go to Home"> Home </a> </li>
                    </ul>
                </div>
            </div>
            <!-- <div class="col-md-2 pr-0">
                <div class="filter-div">
                    <h4 class="border-b pb-3">Filter</h4>
                    <p>Product Form</p>
                    <div class="border-b max-height-filter">
                        <div class="filter-bo">
                            @foreach($categories as $category)
                            @if(count($category->products))
                            <label class=" style__filter-label___3Jy6h">
                                <input type="checkbox" id="myCheck" onclick="categoy_function({{$category->id}})"><span
                                    class="style__filter-checkbox___vU8YA"></span>
                                <span class="style__filter-name___A2BgE">
                                    <span>
                                        {{$category->name}}
                                    </span>
                                </span>
                                <span class="style__filter-count___1B7HQ">
                                    {{count($category->products)}}
                                </span>
                            </label>
                            @endif
                            @endforeach
                        </div>

                    </div>
                    <p>Prescription Required</p>
                    <div class="border-b max-height-filter">
                        <div class="filter-bo">
                            <label class=" style__filter-label___3Jy6h">
                                <input type="checkbox"><span class="style__filter-checkbox___vU8YA"></span>
                                <span class="style__filter-name___A2BgE">
                                    <span>
                                        Required
                                    </span>
                                </span>
                                <span class="style__filter-count___1B7HQ">9</span>
                            </label>

                            <label class=" style__filter-label___3Jy6h">
                                <input type="checkbox"><span class="style__filter-checkbox___vU8YA"></span>
                                <span class="style__filter-name___A2BgE">
                                    <span>
                                        Note required
                                    </span>
                                </span>
                                <span class="style__filter-count___1B7HQ">172</span>
                            </label>

                        </div>

                    </div>

                    <p>Uses</p>
                    <div class="border-b max-height-filter">
                        <div class="filter-bo">
                            @foreach($uses as $use)
                            <label class=" style__filter-label___3Jy6h">
                                <input type="checkbox"><span class="style__filter-checkbox___vU8YA"></span>
                                <span class="style__filter-name___A2BgE">
                                    <span>
                                        {{$use->ProductUse_Name}}
                                    </span>
                                </span>
                                <span class="style__filter-count___1B7HQ"></span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="col-sm-1"></div>
            <div class="col-md-10">

                <div class="row" id="product_list_view">
                    <!-- <div class="col-md-12">
                        <div class="sort-by-div">
                            <div>
                                <h5 class="mb-3"></h5>
                            </div>
                            <div class="sort-by-flter">
                                <span>Sort By: </span>
                                <span><a href="">Popularity</a></span>
                                <span><a href="">High To Low</a></span>
                                <span><a href="">Low To High</a></span>
                                <span><a href="">Discount</a></span>
                            </div>
                        </div>
                    </div> -->

                    <div class="col-md-12">

                        <div class="cart-product">
                            <h4>Products</h4>
                            @foreach($products as $product)
                            <div class="product-details">
                                <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                                    <div class="leftside-icons col-md-2 p-0">
                                        <a class="product-item-photo" title="Natural Power 500 mg Capsule 60's">
                                            <?php
$product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
?>
                                            @if($product_image)
                                            @if(!$product_image->PhotoFile_Name==NULL)
                                            <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}"
                                        class="img-responsive category_image" alt="Nestor Immunity Care"
                                        style="height: 190px">
                                            @else
                                            <img src="{{asset('NoImage.webp')}}" class="img-responsive category_image"
                                                alt="Nestor Immunity Care">
                                            @endif
                                            @else
                                            <img src="{{asset('NoImage.webp')}}" class="img-responsive category_image"
                                                alt="Nestor Immunity Care">
                                            @endif

                                            <?php
$product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '9')->first();
?>
                                        </a>
                                    </div>
                                    <div class="rightside-details col pr-0">
                                        <div class="row m-0">
                                            <div class="product-item-name col pl-0">
                                                <a
                                                    href="{{route('frontend.product_detail',[$product->group->url_name,$product->group_category->url_name,$product->url_name])}}">
                                                    @if($product->ProductBrand_Code==1)
                                                    {{$product->generic_name}} ({{$product->brand_name}})
                                                    @else
                                                    {{$product->brand_name}}
                                                    @endif
                                                </a>

                                            </div>

                                            <?php
$package = \App\Package::find($product->package_id);
?>


                                            <div class="item-prices col-4 p-0 text-right">
                                                <div class="discount-val">

                                                    <!-- <span class="price">
                                                        @if($product->customer_price)
                                                        Your Price
                                                        <i class="fa fa-inr"></i>
                                                        {{number_format($product->customer_price->Price, 2, '.', '')}}
                                                        @else

                                                        @endif
                                                    </span> -->
                                                    <span class="final_price" style="color: black">
                                                        <b>
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
    $purchase_price = $current_price;
}
?>
                                                            Price
                                                            <i class="fa fa-inr"></i>
                                                            {{number_format($purchase_price, 2, '.', '')}}
                                                            @else
                                                            @endif
                                                        </b>
                                                    </span>
                                                    @if($product->sales_schame_customer && $product->customer_mrp_price)
                                    <span class="price"  style="color: #eb3b65">
                                    <strong> &nbsp;MRP: <i class="fa fa-inr"></i>
<s>{{$product->customer_mrp_price->Price}}</s>
</strong>
</span>
<!-- <span class="save">(save upto {{$product->sales_schame_customer->SalesScheme_Name}})</span> -->
                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0 mt-3">
                                        <?php
$package = \App\Package::find($product->package_id);
?>
                                @if($package)
                                <span class="drug-varients ellipsis" style="white-space: nowrap;
  width: 220px;
  overflow: hidden;
  text-overflow: ellipsis;height: 25px">Packing: {{$package->Packing_Description}}
                                    @if($product->Prescription_Required=='1')
                                    <button class="tag-detail" style="background-color: #7bd9ba;color: white;display: inline-block;
    padding: 2px 10px;
    font-size: 12px;
    border-radius: 4px;
    margin-bottom: 10px;">Rx</button>
                                    @endif</span>
                                @endif
                                            <div class="item-prices col-4 p-0 text-right">
                                                <div class="discount-val">
                                                    <!-- @if($product->customer_price && $product->customer_mrp_price)
                                                    <?php
$discount = 0.00;
$discount = ($product->customer_mrp_price->Price - $product->customer_price->Price) * 100 / $product->customer_mrp_price->Price;
?>
                                                    Discount {{number_format($discount, 2, '.', ',')}}%

                                                    @else
                                                    Margin Update Soon
                                                    @endif -->


                                                    @if($product->sales_schame)
                                                    <span class="save">(Buy
                                                        {{$product->sales_schame->NextMinSaleQty_ForScheme}} Get
                                                        {{$product->sales_schame->Free_Qty}} Free)</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="deliveryby row m-0 mt-2">
                                            <div class="date deldate col pl-0">
                                                <div class="deliveryby"> </div>
                                            </div>
                                            <div class="deliveryby row m-0 mt-2">
                                                <div class="remove-drug plus_minus_button{{$product->id}} text-right">
                                                    @if($product->get_addtocart_item)
                                                    @if($product->get_addtocart_item->doctor_description_id)

                                                    <div class="qty-div">
                                                        <span class="qty_minus" rel="tooltip"
                                                            data-original-title="Disable for prescribed Medicine"
                                                            data-toggle="tooltip">-</span>
                                                        <input type="number" required="" id="Qty" name="Qty"
                                                            class="qty_1" min="1"
                                                            value="{{$product->get_addtocart_item->Qty}}">
                                                        <span class="qty_plus" rel="tooltip"
                                                            data-original-title="Disable for prescribed Medicine"
                                                            data-toggle="tooltip">+</span>
                                                    </div>
                                                    @else
                                                    <div class="qty-div">
                                                        <span class="qty_minus"
                                                            onclick="add_cart_from_search({{$product->id}},{{$purchase_price}},-1,{{$product->get_addtocart_item->Qty}})">-</span>
                                                        <input type="number" required="" id="Qty" name="Qty"
                                                            class="qty_1" min="1"
                                                            value="{{$product->get_addtocart_item->Qty}}">
                                                        <span class="qty_plus"
                                                            onclick="add_cart_from_search({{$product->id}},{{$purchase_price}},1,{{$product->get_addtocart_item->Qty}})">+</span>
                                                    </div>
                                                    @endif
                                                    @else
                                                    @if($product->customer_price && $product->customer_mrp_price)
                                                    @if($product->stock && ($product->stock->QtyForNewOrder >= 1))
                                                    <span class="book-now">
                                                        <a href="{{route('frontend.buy_now',$product->id)}}"
                                                            style="width: 100px; text-align: center">
                                                            Buy Now
                                                        </a>
                                                    </span>
                                                    <span class="book-now">
                                                        <button class="book-now-cart" type="button"
                                                            onclick="add_cart_from_search({{$product->id}},{{$purchase_price}},1,0)"
                                                            style="width: 100px">
                                                            <b>Add to Cart</b></button>
                                                    </span>
                                                    @else
                                                    <button class="btn btn-md btn-danger" type="button"
                                                        style="width: 100px;">Out of Stock</button>
                                                    @endif
                                                    @else
                                                    <span style="color: #eb3b65;height: 35px">Coming Soon</span>
                                                    @endif
                                                    @endif

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
    </div>

</div>
@include('frontend.include.footer')
<script>
function collision($div1, $div2) {
    var x1 = $div1.offset().left;
    var w1 = 40;
    var r1 = x1 + w1;
    var x2 = $div2.offset().left;
    var w2 = 40;
    var r2 = x2 + w2;

    if (r1 < x2 || x1 > r2)
        return false;
    return true;
}
// Fetch Url value
var getQueryString = function(parameter) {
    var href = window.location.href;
    var reg = new RegExp('[?&]' + parameter + '=([^&#]*)', 'i');
    var string = reg.exec(href);
    return string ? string[1] : null;
};
// End url
// // slider call
$('.slider').slider({
    range: true,
    min: 1,
    max: 1000,
    step: 1,
    values: [getQueryString('minval') ? getQueryString('minval') : 300, getQueryString('maxval') ?
        getQueryString('maxval') : 600
    ],

    slide: function(event, ui) {

        $('.ui-slider-handle:eq(0) .price-range-min').html('' + ui.values[0]);
        $('.ui-slider-handle:eq(1) .price-range-max').html('' + ui.values[1]);
        $('.price-range-both').html('<i>' + ui.values[0] + ' - </i>' + ui.values[1]);

        // get values of min and max
        $("#minval").val(ui.values[0]);
        $("#maxval").val(ui.values[1]);

        if (ui.values[0] == ui.values[1]) {
            $('.price-range-both i').css('display', 'none');
        } else {
            $('.price-range-both i').css('display', 'inline');
        }

        if (collision($('.price-range-min'), $('.price-range-max')) == true) {
            $('.price-range-min, .price-range-max').css('opacity', '0');
            $('.price-range-both').css('display', 'block');
        } else {
            $('.price-range-min, .price-range-max').css('opacity', '1');
            $('.price-range-both').css('display', 'none');
        }

    }
});

$('.ui-slider-range').append('<span class="price-range-both value"><i>' + $('.slider').slider('values', 0) + ' - </i>' +
    $('.slider').slider('values', 1) + '</span>');

$('.ui-slider-handle:eq(0)').append('<span class="price-range-min value">' + $('.slider').slider('values', 0) +
    '</span>');

$('.ui-slider-handle:eq(1)').append('<span class="price-range-max value">' + $('.slider').slider('values', 1) +
    '</span>');
</script>

<script>
function slider_submit() {
    var minval = $("#minval").val();
    var maxval = $("#maxval").val();
    var group_id = $(".group_id").val();

    alert(minval);
    alert(maxval);
    $.ajax({
        url: "/search/group_product_by_price",
        data: {
            minval: minval,
            maxval: maxval,
            group_id: group_id
        },
        type: "GET",
        success: function(data) {
            $("#product_list_view").html(data);
            console.log(data);
        }
    });
}
</script>

<script>
function categoy_function(category_id) {
    var checkBox = document.getElementById("myCheck");

    if (checkBox.checked == true) {
        $.ajax({
            url: "/search/group_product_by_price",
            data: {
                category_id: category_id
            },
            type: "GET",
            success: function(data) {
                $("#product_list_view").html(data);
                console.log(data);
            }
        });
    } else {
        $.ajax({
            url: "/search/group_product_by_price",
            data: {
                category_id: category_id
            },
            type: "GET",
            success: function(data) {
                $("#product_list_view").html(data);
                console.log(data);
            }
        });
    }
}
</script>
<script>
    $(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
});
    </script>