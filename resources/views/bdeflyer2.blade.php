@include('frontend.include.head')
@include('frontend.include.header')
<div class="main">
    <div class="container-fluid">
        <div class="py-3">
            <div class="owl-carousel owl-theme owl-one">
                @foreach($main_sliders as $main_slider)
                <div class="item">
                    <div>
                        <a href="{{$main_slider->url_link}}">
                            <img src="{{asset($main_slider->image)}}" alt="">
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card-sec">

            <div>
                <div class="owl-carousel owl-theme owl-cat">
                    @foreach($healthareas_groupcategories as $key=>$healthareas_groupcategory)
                    <div class="item">
                        <div class="health-sec">
                            <a href="{{route('frontend.groupcategory_page',[$healthareas_groupcategory->group->url_name,$healthareas_groupcategory->url_name])}}"
                                alt="{{$healthareas_groupcategory->name}}">
                                <div class="cat-img-div">
                                    <img src="{{asset($healthareas_groupcategory->image)}}"
                                        style="width: 96px; height: 96px" alt="{{$healthareas_groupcategory->name}}">

                                </div>
                                <div class="health-detail">
                                    <p class="text-center"
                                        style="white-space: nowrap;width: 170px;overflow: hidden;text-overflow: ellipsis;text-align: center;">
                                        {{$healthareas_groupcategory->name}}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="py-3">
            <div class="owl-carousel owl-theme owl-two">
                @foreach($second_top_mail_sliders as $second_top_mail_slider)
                <div class="item">
                    <div class="add-banner rounded">
                        <a href="{{$second_top_mail_slider->url_link}}">
                            <img src="{{asset($second_top_mail_slider->image)}}" alt="">
                        </a>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
    <hr>


    <div class="container-fluid">
        <div class="card-sec">
            <div class="h-pettern text-center">
                <h6>POPULAR PRODUCTS</h6>
            </div>
            <div>
                <div class="owl-carousel owl-theme owl-cards">
                    @foreach($popular_products as $product)
                    <div class="item">
                        <div class="diag-section">
                            <span class="diag-img">
                                <a
                                    href="{{route('frontend.product_detail',[$product->group->url_name,$product->group_category->url_name,$product->url_name])}}">
                                    <?php
$product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
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
text-overflow: ellipsis;height: 40px">
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
  text-overflow: ellipsis;height: 25px">Packing : {{$package->Packing_Description}}
                                    @if($product->Prescription_Required=='1')
                                    <button class="tag-detail" style="background-color: #7bd9ba;color: white;display: inline-block;
    padding: 2px 10px;
    font-size: 12px;
    border-radius: 4px;">Rx</button>
                                    @endif</span>
                                @endif
                            </div>




                            <div class="diag-price" style="height: 30px;color:black">
                                <span class="price" style="color:black">
                                    <b>
                                        <?php
$total = 0;
?>
                                        @if($product->customer_price)
                                        <?php
$total = $product->customer_price->Price + $product->customer_price->Price * $product->customer_price->GST / 100;
?>
                                        Purchase Price
                                        <i class="fa fa-inr"></i>
                                        {{number_format($product->customer_price->Price, 2, '.', ',')}}
                                        @else
                                        @endif
                                    </b>
                                </span>
                            </div>
                            <!-- <div class="diag-price" style="height: 30px">
                                @if($product->sales_schame)
                                <span class="save">(Buy {{$product->sales_schame->NextMinSaleQty_ForScheme}} Get
                                    {{$product->sales_schame->Free_Qty}} Free)</span>
                                @endif
                            </div> -->
                            <div class="dia-bottom plus_minus_button{{$product->id}}" style="height: 50px">
                                @if($product->get_addtocart_item_guest($product->id))
                                <div class="qty-div">
                                    <span class="qty_minus"
                                        onclick="add_cart_from_search({{$product->id}},{{$product->customer_price->Price}},-1,{{$product->get_addtocart_item_guest($product->id)}}">)">-</span>
                                    <input type="number" required="" id="Qty" name="Qty" class="qty_1" min="1"
                                        value="{{$product->get_addtocart_item_guest($product->id)}}">
                                    <span class="qty_plus"
                                        onclick="add_cart_from_search({{$product->id}},{{$product->customer_price->Price}},1,{{$product->get_addtocart_item_guest($product->id)}}">)">+</span>
                                </div>
                                @else
                                @if($product->customer_price && $product->customer_mrp_price)
                                @if($product->stock_by_office($Global_Office_Code) &&
                                ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder >= 1))
                                <span class="book-now"><a href="{{route('frontend.buy_now',$product->id)}}">Buy
                                        Now</a></span>
                                <span class="book-now"><button class="book-now-cart" type="button"
                                        onclick="add_cart_from_search({{$product->id}},{{$product->customer_price->Price}},1,0)"><b>Add
                                            to Cart</b></button></span>
                                @else
                                <span style="color: #eb3b65">Out of Stock &nbsp;&nbsp;
                                    <button class="book-now-cart" type="button"
                                        onclick="notify_me_function({{$product->id}})"> Notify Me</button>
                                </span>
                                @endif
                                @else
                                <span style="color: #eb3b65;height: 35px">Comming Soon</span>
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
                </div>
            </div>
        </div>
    </div>


    <!--

    <div class="container-fluid">
        <div class="card-sec">
            <div class="h-pettern text-center">
                <h6>EXPLORE BY</h6>
            </div>
            <div>
                <div class="owl-carousel owl-theme owl-cat">
                    @foreach($healthareas_groupcategories as $key=>$healthareas_groupcategory)
                    <div class="item">
                        <div class="health-sec">
                            <a
                                href="{{route('frontend.groupcategory_page',[$healthareas_groupcategory->group->url_name,$healthareas_groupcategory->url_name])}}">
                                <div class="cat-img-div">
                                    @if($healthareas_groupcategory->id == '37')
                                    <img src="img/categories1.webp" style="width: 96px; height: 96px" alt="">
                                    @elseif($healthareas_groupcategory->id == '39')
                                    <img src="img/categories2.webp" style="width: 96px; height: 96px" alt="">
                                    @elseif($healthareas_groupcategory->id == '40')
                                    <img src="img/categories3.webp" style="width: 96px; height: 96px" alt="">
                                    @elseif($healthareas_groupcategory->id == '44')
                                    <img src="img/categories4.webp" style="width: 96px; height: 96px" alt="">
                                    @elseif($healthareas_groupcategory->id == '48')
                                    <img src="img/categories5.webp" style="width: 96px; height: 96px" alt="">
                                    @elseif($healthareas_groupcategory->id = '11')
                                    <img src="img/categories6.webp" style="width: 96px; height: 96px" alt="">
                                    @else

                                    @endif

                                </div>
                                <div class="health-detail">
                                    <p class="text-center">{{$healthareas_groupcategory->name}}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div> -->
    <div class="container-fluid">
        <div class="card-sec">
            <div class="h-pettern text-center">
                <h6>BEST PACKAGES</h6>
            </div>
            <div>
                <div class="owl-carousel owl-theme owl-cards">
                    @foreach($home_page_similars as $home_page_similar)
                    <div class="item">
                        <div class="diag-section">
                            <span class="diag-img">
                                <a href="">
                                    <img src="{{asset($home_page_similar->image)}}"
                                        class="img-responsive category_image" alt="Nestor Immunity Care">
                                </a>
                            </span>
                            <div class="diag-txt">
                                <span class="clsgetname ellipsis">{{$home_page_similar->title}}</span>
                                <span class="drug-varients ellipsis">Healthians</span>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @foreach($home_page_similars as $home_page_similar)
                    <div class="item">
                        <div class="diag-section">
                            <span class="diag-img">
                                <a href="">
                                    <img src="{{asset($home_page_similar->image)}}"
                                        class="img-responsive category_image" alt="Nestor Immunity Care">
                                </a>
                            </span>
                            <div class="diag-txt">
                                <span class="clsgetname ellipsis">{{$home_page_similar->title}}</span>
                                <span class="drug-varients ellipsis">Healthians</span>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card-sec">
            <div class="h-pettern text-center">
                <h6>TRENDING</h6>
            </div>
            <div>
                <div class="owl-carousel owl-theme owl-three">
                    @foreach($home_page_trendings as $home_page_trending)
                    <div class="item">
                        <div>
                            <img src="{{asset($home_page_trending->image)}}" alt="">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card-sec">
            <div class="h-pettern text-center">
                <h6>SIMILAR</h6>
            </div>
            <div>
                <div class="owl-carousel owl-theme owl-cards">
                    @foreach($similer_products as $product)
                    <div class="item">
                        <div class="diag-section">
                            <span class="diag-img">
                                <a
                                    href="{{route('frontend.product_detail',[$product->group->url_name,$product->group_category->url_name,$product->url_name])}}">
                                    <?php
$product_image = \App\Productimage::where('Product_Code', '=', $product->product_code)->first();
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
text-overflow: ellipsis;height: 40px">
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
  text-overflow: ellipsis;height: 25px">Packing : {{$package->Packing_Description}}
                                    @if($product->Prescription_Required=='1')
                                    <button class="tag-detail" style="background-color: #7bd9ba;color: white;display: inline-block;
    padding: 2px 10px;
    font-size: 12px;
    border-radius: 4px;">Rx</button>
                                    @endif</span>
                                @endif
                            </div>




                            <div class="diag-price" style="height: 30px;color:black">
                                <span class="price" style="color:black">
                                    <b>
                                        <?php
$total = 0;
?>
                                        @if($product->customer_price)
                                        <?php
$total = $product->customer_price->Price + $product->customer_price->Price * $product->customer_price->GST / 100;
?>
                                        Purchase Price
                                        <i class="fa fa-inr"></i>
                                        {{number_format($product->customer_price->Price, 2, '.', ',')}}
                                        @else
                                        @endif
                                    </b>
                                </span>
                            </div>
                            <!-- <div class="diag-price" style="height: 30px">
                                @if($product->sales_schame)
                                <span class="save">(Buy {{$product->sales_schame->NextMinSaleQty_ForScheme}} Get
                                    {{$product->sales_schame->Free_Qty}} Free)</span>
                                @endif
                            </div> -->
                            <div class="dia-bottom plus_minus_button{{$product->id}}" style="height: 50px">
                                @if($product->get_addtocart_item_guest($product->id))
                                <div class="qty-div">
                                    <span class="qty_minus"
                                        onclick="add_cart_from_search({{$product->id}},{{$product->customer_price->Price}},-1,{{$product->get_addtocart_item_guest($product->id)}}">)">-</span>
                                    <input type="number" required="" id="Qty" name="Qty" class="qty_1" min="1"
                                        value="{{$product->get_addtocart_item_guest($product->id)}}">
                                    <span class="qty_plus"
                                        onclick="add_cart_from_search({{$product->id}},{{$product->customer_price->Price}},1,{{$product->get_addtocart_item_guest($product->id)}}">)">+</span>
                                </div>
                                @else
                                @if($product->customer_price && $product->customer_mrp_price)
                                @if($product->stock_by_office($Global_Office_Code) &&
                                ($product->stock_by_office($Global_Office_Code)->QtyForNewOrder >= 1))
                                <span class="book-now"><a href="{{route('frontend.buy_now',$product->id)}}">Buy
                                        Now</a></span>
                                <span class="book-now"><button class="book-now-cart" type="button"
                                        onclick="add_cart_from_search({{$product->id}},{{$product->customer_price->Price}},1,0)"><b>Add
                                            to Cart</b></button></span>
                                @else
                                <span style="color: #eb3b65;height: 35px">Out of Stock</span>
                                @endif
                                @else
                                <span style="color: #eb3b65;height: 35px">Comming Soon</span>
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
                </div>
            </div>
        </div>
    </div>

</div>

@include('frontend.include.footer')