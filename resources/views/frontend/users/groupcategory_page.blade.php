@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <ul class="items">
                        <li class="home"> <a href="{{route('home')}}" title="Go to Home"> Home </a> </li>
                        <li class="home"> <a href="{{route('frontend.group_page',$single_group->url_name)}}"
                                title="Go to {{$single_group->name}}"> {{$single_group->name}} </a> </li>
                        <li class="home"> <a
                                href="{{route('frontend.groupcategory_page',[$single_group->url_name,$single_groupcategory->url_name])}}"
                                title="Go to {{$single_groupcategory->name}}"> {{$single_groupcategory->name}} </a>
                        </li>
                    </ul>
                    @include('flash')
                </div>
            </div>
            <input type="hidden" class="groupcategory_id" value="{{$single_groupcategory->id}}">
            @include('frontend.include.group_category_sidebar_filter')
            <div class="col-md-10">
                <div class="">
                    <div class="">
                        <div class="owl-carousel owl-theme owl-one">
                            @foreach($main_sliders as $main_slider)
                            <div class="item">
                                <div>
                                    <img src="{{asset($main_slider->image)}}" alt="">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row" id="product_list_view">
                    <div class="col-md-12">
                        <div class="sort-by-div">
                            <div>
                                <h5 class="mb-3">Showing {{ $products->lastItem() }} of {{ $products->total() }} Items
                                </h5>
                            </div>
                            <div class="sort-by-flter">
                                <span>Sort By: </span>
                                <!-- <span><a href="">Popularity</a></span> -->
                                <span><a
                                        href="{{route('frontend.groupcategory_page',[$single_group->url_name,$single_groupcategory->url_name])}}?sort=DESC">High
                                        To Low</a></span>
                                <span><a
                                        href="{{route('frontend.groupcategory_page',[$single_group->url_name,$single_groupcategory->url_name])}}?sort=ASC">Low
                                        To High</a></span>
                                <span><a href="{{route('frontend.groupcategory_page',[$single_group->url_name,$single_groupcategory->url_name])}}?sort=DISCOUNT">Discount</a></span>
                            </div>
                        </div>
                    </div>
                    @foreach($products as $product)
                    <div class="col-md-3">
                        <div class="diag-section">
                            <span class="diag-img">
                                <a
                                    href="{{route('frontend.product_detail',[$product->group->url_name,$product->group_category->url_name,$product->url_name])}}">
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
                                </a>
                            </span>
                            <div class="diag-txt">
                                <span class="clsgetname ellipsis" style="display: -webkit-box;
-webkit-line-clamp: 2;
-webkit-box-orient: vertical;
overflow: hidden;
text-overflow: ellipsis;;height: 40px">
                                    @if($product->ProductBrand_Code==1)
                                    {{$product->generic_name}} ({{$product->brand_name}})
                                    @else
                                    {{$product->brand_name}}
                                    @endif
                                </span>
                                <?php
$package = \App\Package::find($product->package_id);
?>
                                @if($package)
                                <span class="drug-varients ellipsis" style="white-space: nowrap;
  width: 220px;
  overflow: hidden;
  text-overflow: ellipsis;height: 25px">{{$package->Packing_Description}}
                                    @if($product->Prescription_Required=='1')
                                    <button class="tag-detail" style="background-color: #7bd9ba;color: white;display: inline-block;
    padding: 2px 10px;
    font-size: 12px;
    border-radius: 4px;
    margin-bottom: 10px;">Rx</button>
                                    @endif</span>
                                @endif
                            </div>
                            <div class="diag-price" style="height: 30px;color:black">
                                <span class="price" style="color:black">
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
                                   
                                </span>
                                @if($product->sales_schame_customer && $product->customer_mrp_price)
                                        <span class="price"  style="color: #eb3b65">
                                    <strong> &nbsp;MRP: <i class="fa fa-inr"></i>
<s>{{$product->customer_mrp_price->Price}}</s>
</strong>
</span>
<!-- <span class="save">(save upto {{$product->sales_schame_customer->SalesScheme_Name}})</span> -->
                                    @endif
                                    </b>
                            </div>
                            <!-- <div class="diag-price" style="height: 30px">
                                @if($product->sales_schame)
                                <span class="save">(Buy {{$product->sales_schame->NextMinSaleQty_ForScheme}} Get
                                    {{$product->sales_schame->Free_Qty}} Free)</span>
                                @endif
                            </div> -->
                            <div class="dia-bottom plus_minus_button{{$product->id}}" style="height: 50px">
                                @if($product->get_addtocart_item)
                                @if($product->get_addtocart_item->doctor_description_id)
            
            <div class="qty-div">
                                   <span class="qty_minus" rel="tooltip" data-original-title="Disable for prescribed Medicine" data-toggle="tooltip">-</span>
                                   <input type="number" required="" id="Qty" name="Qty" class="qty_1" min="1"
                                       value="{{$product->get_addtocart_item->Qty}}">
                                   <span class="qty_plus" rel="tooltip" data-original-title="Disable for prescribed Medicine" data-toggle="tooltip">+</span>
                               </div>
            @else
            <div class="qty-div">
                                   <span class="qty_minus"
                                       onclick="add_cart_from_search({{$product->id}},{{$purchase_price}},-1,{{$product->get_addtocart_item->Qty}})">-</span>
                                   <input type="number" required="" id="Qty" name="Qty" class="qty_1" min="1"
                                       value="{{$product->get_addtocart_item->Qty}}">
                                   <span class="qty_plus"
                                       onclick="add_cart_from_search({{$product->id}},{{$purchase_price}},1,{{$product->get_addtocart_item->Qty}})">+</span>
                               </div>
            @endif
                                @else
                                @if($product->chemist_price && $product->customer_price)
                                @if($product->stock_by_office($Global_Office_Code) &&
                                ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder >= 1))
                                <span class="book-now"><a href="{{route('frontend.buy_now',$product->id)}}">Buy
                                        Now</a></span>
                                <span class="book-now"><button class="book-now-cart" type="button"
                                        onclick="add_cart_from_search({{$product->id}},{{$purchase_price}},1,0)"><b>Add
                                            to Cart</b></button></span>
                                @else
                                <span style="color: #eb3b65">Out of Stock &nbsp;&nbsp;
                                    <button class="book-now-cart" type="button"
                                        onclick="notify_me_function({{$product->product_code}})"> <b>Notify
                                            Me</b></button>
                                </span>
                                @endif
                                @else
                                <span style="color: #eb3b65;height: 35px">Coming Soon</span>

                                <!-- <span class="book-now"><a
                                        href="javascript:void(0);" data-product_code="{{$product->product_code}}"
                                        data-toggle="modal" data-target="#notify_model"
                                        onclick="modal_function(this);">Notify
                                        Me</a></span> -->
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="col-md-12">
                        {{ $products->links() }}
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>
@include('frontend.include.footer')

@foreach($products as $product)
<script>
$(document).ready(function() {
    $(".add-to-your-cart{{$product->id}}").click(function() {
        var product_id = $(".product_id{{$product->id}}").val();
        var Qty = $(".Qty{{$product->id}}").val();
        var amount = $(".amount{{$product->id}}").val();

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

            }
        });
    });
});
</script>
@endforeach
<script>
    $(document).ready(function() {
    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
});
    </script>