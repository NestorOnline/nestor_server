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
            <div class="col-md-2 pr-0">
                <div class="filter-div">
                    <h4 class="border-b pb-3">Filter</h4>
                    <input type="hidden" class="group_id" value="">
                    <p>Product Form</p>
                    <div class="border-b max-height-filter">

                        <div class="filter-bo">
                            @foreach($categories as $category)
                            <?php
$product_count = \App\Product::where('category_id', $category->id)->count();
?>
                            @if($product_count)
                            <label class=" style__filter-label___3Jy6h">
                                <input type="checkbox" class="product_form" value="{{$category->id}}" /><span
                                    class="style__filter-checkbox___vU8YA"></span>
                                <span class="style__filter-name___A2BgE">
                                    <span>
                                        {{$category->name}}
                                    </span>
                                </span>
                                <span class="style__filter-count___1B7HQ">
                                    {{$product_count}}
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
                                <input type="checkbox" class="prescription_required" value="1"><span
                                    class="style__filter-checkbox___vU8YA"></span>
                                <span class="style__filter-name___A2BgE">
                                    <span>
                                        Required
                                    </span>
                                </span>
                                <span class="style__filter-count___1B7HQ">9</span>
                            </label>

                            <label class=" style__filter-label___3Jy6h">
                                <input type="checkbox" class="prescription_required" value="0"><span
                                    class="style__filter-checkbox___vU8YA"></span>
                                <span class="style__filter-name___A2BgE">
                                    <span>
                                        Not Required
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
                                <input type="checkbox" class="product_uses" value="{{$use->id}}"><span
                                    class="style__filter-checkbox___vU8YA"></span>
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
                    <div class="border-b">
                        <p>Price</p>
                        <div>
                            <div class="slider"></div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="hidden" class="form-control minval" value="0">
                                </div>
                                <div class="col-sm-6">
                                    <input type="hidden" class="form-control maxval" value="1000">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">

                <div class="row" id="product_list_view">
                    <div class="col-md-12">
                        <div class="sort-by-div">
                            <div>
                                <h5 class="mb-3">Showing {{ count($products)}} of {{ count($products)}} Items
                                </h5>
                            </div>
                            <div class="sort-by-flter">
                                <span>Sort By: </span>
                                <span><a href="#">Popularity</a></span>
                                <span><a href="#">High To Low</a></span>
                                <span><a href="#">Low To High</a></span>
                                <span><a href="#">Discount</a></span>
                            </div>
                        </div>
                    </div>

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
                                                class="img-responsive category_image" alt="Nestor Immunity Care">
                                            @else
                                            <img src="{{asset('NoImage.webp')}}" class="img-responsive category_image"
                                                alt="Nestor Immunity Care">
                                            @endif
                                            @else
                                            <img src="{{asset('NoImage.webp')}}" class="img-responsive category_image"
                                                alt="Nestor Immunity Care">
                                            @endif

                                            <?php
$chemist_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '7')->first();
$mrp_product_price = \App\Productprice::where('Product_Code', '=', $product->product_code)->where('ProductPriceType_Code', '=', '8')->first();
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
                                                    <span class="final_price" style="color: black">
                                                        @if($product->mrp_price)
                                                        MRP
                                                        <i class="fa fa-inr"></i>
                                                        <b>
                                                            {{number_format($product->mrp_price->Price, 2, '.', ',')}}</b>
                                                        @endif
                                                    </span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0 mt-3">
                                            @if($package)
                                            <div class="catag-name col pl-0">
                                                <p class="form m-0">Packing: {{$package->name}}</p>
                                            </div>
                                            @endif
                                            <div class="item-prices col-4 p-0 text-right">
                                                <div class="discount-val">
                                                    <span class="price" style="color: black">
                                                        @if($product->chemist_price)
                                                        Your Price
                                                        <i class="fa fa-inr"></i>
                                                        {{number_format($product->chemist_price->Price, 2, '.', ',')}}
                                                        @else
                                                        @endif
                                                    </span>


                                                    @if($product->sales_schame)
                                                    <span class="save">(Buy
                                                        {{$product->sales_schame->NextMinSaleQty_ForScheme}} Get
                                                        {{$product->sales_schame->Free_Qty}} Free)</span>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row m-0 mt-3">

                                            <div class="catag-name col pl-0">
                                                <p class="form m-0"></p>
                                            </div>

                                            <div class="item-prices col-4 p-0 text-right">
                                                <div class="discount-val">
                                                    @if($product->chemist_price && $product->mrp_price)
                                                    <?php
$total = 0;
$total = $product->chemist_price->Price + $product->chemist_price->Price * $product->chemist_price->GST / 100;

$margin = 0.00;
$margin = ($product->mrp_price->Price - $total) * 100 / $total;
?>
                                                    Margin on MRP {{number_format($margin, 2, '.', ',')}}%

                                                    @else
                                                    Margin Update Soon
                                                    @endif
                                                    </span>


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
                                                <div class="dia-bottom plus_minus_button{{$product->id}} text-right">
                                                    @if($product->get_addtocart_item)

                                                    <div class="qty-div">
                                                        <span class="qty_minus"
                                                            onclick="add_cart_from_search({{$product->id}},{{$product->chemist_price->Price}},-1,{{$product->get_addtocart_item->Qty}})">-</span>
                                                        <input type="number" required="" id="Qty" name="Qty"
                                                            class="qty_1" min="1"
                                                            value="{{$product->get_addtocart_item->Qty}}">
                                                        <span class="qty_plus"
                                                            onclick="add_cart_from_search({{$product->id}},{{$product->chemist_price->Price}},1,{{$product->get_addtocart_item->Qty}})">+</span>
                                                    </div>
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
                                                            onclick="add_cart_from_search({{$product->id}},{{$product->chemist_price->Price}},1,0)"
                                                            style="width: 100px">
                                                            <b>Add to Cart</b>
                                                        </button>
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