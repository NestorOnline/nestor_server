@include('frontend.include.head')
@include('frontend.include.header')
<div class="main">
    <div class="container-fluid">
        <div class="py-3">
            <div class="owl-carousel owl-theme owl-one">
                @foreach($main_sliders as $main_slider)
                <div class="item">
                    <div>
                        <a href="{{route('home')}}">
                            <img src="{{asset($main_slider->image)}}" alt="">
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <hr>
     <div class="container-fluid">
        <div class="">
            <div>
                <div class="row">
                     @foreach($healthareas_groupcategories as $key=>$healthareas_groupcategory)
                    <div class="col-md-2">
                        <div class="health-sec-cat">
                            <a href="{{route('frontend.groupcategory_page',[$healthareas_groupcategory->group->url_name,$healthareas_groupcategory->url_name])}}">
                                <div class="cat-img-div-top">
                                    @if($healthareas_groupcategory->id == '37')
                                    <img src="img/icons/doctor.png" alt="">                                    
                                    @elseif($healthareas_groupcategory->id == '39')
                                    <img src="img/icons/healthcare.png" alt="">
                                    @elseif($healthareas_groupcategory->id == '40')
                                    <img src="img/icons/heart.png" alt="">
                                    @elseif($healthareas_groupcategory->id == '44')                                    
                                    <img src="img/icons/healthcare.png" alt="">
                                    @elseif($healthareas_groupcategory->id == '48')
                                    <img src="img/icons/baby-boy.png" alt="">                                   
                                    @elseif($healthareas_groupcategory->id = '11')
                                    <img src="img/icons/diet.png" alt="">                                   
                                    @else
                                    
                                    @endif
                                </div>
                                <div class="health-detail">
                                <center> <p class="text-center" style="white-space: nowrap;width: 170px;overflow: hidden;text-overflow: ellipsis;text-align: center;">{{$healthareas_groupcategory->name}}</p></center>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="container-fluid">
        <div class="py-3">
            <div class="owl-carousel owl-theme owl-two">
                @foreach($second_top_mail_sliders as $second_top_mail_slider)
                <div class="item">
                    <div class="add-banner rounded">
                      <a href="{{route('home')}}">
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
        <div class="home-payment-offer" data-id="section_32">
            <div class="owl-carousel owl-theme owl-three">
                @foreach($offers as $offer)
                <div class="item">
                    <div class="slide-section">
                        <a href="">
                            <img class="banner_img" src="{{asset($offer->image)}}" alt=""> 
                            <div class="description-slide">
                                <p class="ellipsis">{{$offer->name}}</p>
                                <p>{{$offer->description}}</p>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
                <div class="item">
                    <div class="slide-section">
                        <a href="#">
                            <img class="banner_img" src="img/upload-presc-link-icn.svg" alt=""> 
                            <div class="description-slide">
                                <p class="ellipsis">Upload your prescription</p>
                                <p>Get a call back</p>
                            </div>
                            <div>
                                <span class="book-now"><a href="#" class="#">Upload</a></span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card-sec">
            <div class="h-pettern text-center">
                <h6>Popular</h6>
                <h5>Diagnostic Packages</h5>
                <p><small>Free home sample collection for all health checkups</small></p>
            </div>
            <div>
                <div class="owl-carousel owl-theme owl-cards">
                    @foreach($popular_products as $product)
                     <div class="item">
                        <div class="diag-section"> 
                            <span class="diag-img">
                                <a href="{{route('frontend.product_detail',[$product->group->url_name,$product->group_category->url_name,$product->url_name])}}">
                                    <?php
                                    $product_image = \App\Productimage::where('Product_Code','=',$product->product_code)->first();
                                    ?>
                                    @if($product_image)
                                    <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}" class="img-responsive category_image" alt="Nestor Immunity Care">
                                    @endif
                                </a> 
                            </span> 
                            <div class="diag-txt"> 
                                <span class="clsgetname ellipsis">{{$product->brand_name}}</span> 
                                <span class="drug-varients ellipsis" style="white-space: nowrap; 
  width: 220px; 
  overflow: hidden;
  text-overflow: ellipsis;">{{$product->generic_name}}</span> 
                            </div> 
                            <div class="diag-price"> 
            <?php
            $product_price = \App\Productprice::where('Product_Code','=',$product->product_code)->where('ProductPriceType_Code','=','9')->first();                             
            ?>
                                @if($product_price)
                                <span class="price">Rs. {{number_format($product_price->Price, 2, '.', '')}}</span> 
                                @endif
                            </div> 
                            <div class="dia-bottom"> 
                                <span class="book-now"><a href="{{route('frontend.buy_now',$product->id)}}">Buy Now</a></span>
                                @if($product_price)
                                <input type="hidden" class="amount{{$product->id}}" value="{{$product_price->Price}}">
                                @endif
                                <input type="hidden" class="product_id{{$product->id}}" value="{{$product->id}}">
                                <input type="hidden" class="Qty{{$product->id}}" value="1">
                                <span class="book-now"><a type="button"  class="add-to-your-cart{{$product->id}}">Add to Cart</a></span>  
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
                <h6>EXPLORE BY</h6>
                <h5>Categories</h5>
                <p><small>Search products according to your health problems</small></p>
            </div>
            <div>
                <div class="owl-carousel owl-theme owl-cat">
                @foreach($healthareas_groupcategories as $key=>$healthareas_groupcategory)
                    <div class="item">
                        <div class="health-sec">
                            <a href="">
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
    </div>
    <div class="container-fluid">
        <div class="card-sec">
            <div class="h-pettern text-center">
                <h6>SIMILER</h6>
                <h5>People also Looking For</h5>
                <p><small>Free home sample collection for all health checkups</small></p>
            </div>
            <div>
                <div class="owl-carousel owl-theme owl-cards">
                    @foreach($home_page_similars as $home_page_similar)
                    <div class="item">
                        <div class="diag-section"> 
                            <span class="diag-img"> 
                                <a href="">
                                    <img src="{{asset($home_page_similar->image)}}" class="img-responsive category_image" alt="Nestor Immunity Care">
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
                                    <img src="{{asset($home_page_similar->image)}}" class="img-responsive category_image" alt="Nestor Immunity Care">
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
    
    <!-- <div class="container-fluid">
        <div class="card-sec">
            <div class="h-pettern text-center">
                <h6>EXPLORE BY</h6>
                <h5>Discounts</h5>
                <p><small>Search products according to your health problems</small></p>
            </div>
            <div>
                <img src="img/discount.jpg" alt="">
            </div>
        </div>
    </div> -->
    <div class="container-fluid">
        <div class="card-sec">
            <div class="h-pettern text-center">
                <h6>TRENDING</h6>
                <h5>Discount Corner</h5>
                <p><small>Search products according to your health problems</small></p>
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
                <h6>SIMILER</h6>
                <h5>People also Looking For</h5>
                <p><small>Free home sample collection for all health checkups</small></p>
            </div>
            <div>
                <div class="owl-carousel owl-theme owl-cards">
                    @foreach($similer_products as $product)
                    <div class="item">
                        <div class="diag-section"> 
                            <span class="diag-img"> 
                                <a href="{{route('frontend.product_detail',[$product->group->url_name,$product->group_category->url_name,$product->url_name])}}">
                                 <?php
                                    $product_image = \App\Productimage::where('Product_Code','=',$product->product_code)->first();
                                    ?>
                                    @if($product_image)
                                    <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}" class="img-responsive category_image" alt="Nestor Immunity Care">
                                    @endif
                                </a> 
                            </span> 
                                           <?php
            $product_price = \App\Productprice::where('Product_Code','=',$product->product_code)->where('ProductPriceType_Code','=','9')->first();
                             
            ?>
                            <div class="diag-txt"> 
                                <span class="clsgetname ellipsis">{{$product->brand_name}}</span> 
                                <span class="drug-varients ellipsis" style="white-space: nowrap; 
  width: 220px; 
  overflow: hidden;
  text-overflow: ellipsis;">{{$product->generic_name}}</span> 
                            </div> 
                            <div class="diag-price"> 
                            <span class="price">Rs. {{number_format($product_price->Price, 2, '.', '')}}</span> 
                            </div> 
                            <div class="dia-bottom"> 
                                <span class="book-now"><a href="{{route('frontend.buy_now',$product->id)}}">Buy Now</a></span>
                                <input type="hidden" class="amount{{$product->id}}" value="{{number_format($product_price->Price, 2, '.', '')}}">
                                <input type="hidden" class="product_id{{$product->id}}" value="{{$product->id}}">
                                <input type="hidden" class="Qty{{$product->id}}" value="1">
                                <span class="book-now"><a type="button"  class="add-to-your-cart{{$product->id}}">Add to Cart</a></span> 
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 offset-md-5">
                    <div class="text-center">
                    <a href="" class="add-to-cart">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="container-fluid">
        <div class="bot-con">
            <h6>Welcome to Nestor.com! India's Leading Online Pharmacy!</h6>
            <p>With a dynamic legacy of over 100 years in the pharma business, it comes as no surprise that Nestor.com is the first choice of over 4 million+ satisfied customers when it comes to an online pharmacy in India. Nestor.com has a pan India presence as we deliver health care essentials to every state in the country. We take your health seriously at Nestor.com. Be it purchasing medicines online, lab tests or online doctor consultations, we've got it all covered for our customers!</p>
            <h6>Take the Worry Out of Buying Medicines! Purchase Medicines Online Anytime, Anywhere!</h6>
            <p>Get everything you need at Nestor.com to take care of your health right from high-quality, affordable, authentic prescription medicines, Over-The-Counter pharmaceuticals products to general health care products, Ayurveda, Unani and Homeopathy medicines.</p>
            <p>Buy medicines online at Nestor.com from the comfort of your home and we will take care of the rest! We will ensure that the life-saving drugs reach your doorstep without a hitch. Do away with the hassle of driving to the medical store, waiting in line, or even remembering your refills! Netmed.com will sort out those problems for you effectively so that you can lead a healthy and full life!</p>
            <p>Ordering medicines online at Nestor.com is just a simple 4 step process. Browse through our wide range of health care products, add them to your cart, uploading your prescription (if required) and proceed to checkout! With Netmed.com, rest assured that your health will be in safe hands!</p>
            <h6>Why Choose Nestor?</h6>
            <ul>
                <li>100+ years of experience in the pharma sector</li>
                <li>Vital medicines delivered across the country</li>
                <li>Trust of more than 4 million+ loyal customers</li>
                <li>Our team is made up of highly experienced pharmacists & healthcare professionals</li>
                <li>A wide array of healthcare services available for your convenience</li>
                <li>We stock only genuine medicines & healthcare products</li>
            </ul>
        </div>
    </div> -->
</div>

@include('frontend.include.footer')

@foreach($popular_products as $product)
 <script>
      $(document).ready(function(){
               $(".add-to-your-cart{{$product->id}}").click(function(){                    
            var product_id = $(".product_id{{$product->id}}").val();
            var Qty = $(".Qty{{$product->id}}").val();
             var amount = $(".amount{{$product->id}}").val();
             
                   $.ajax({
    url: "/add_to_carts/add_cart/",
    data: {product_id:product_id,Qty:Qty,amount:amount},
    type: "GET",
    success:  function(data){
        $("#add_card_view").html(data);
       
    }
});
        });                     
        });
        
</script>
@endforeach
@foreach($similer_products as $product)
 <script>
      $(document).ready(function(){
               $(".add-to-your-cart{{$product->id}}").click(function(){                    
            var product_id = $(".product_id{{$product->id}}").val();
            var Qty = $(".Qty{{$product->id}}").val();
             var amount = $(".amount{{$product->id}}").val();
             
                   $.ajax({
    url: "/add_to_carts/add_cart/",
    data: {product_id:product_id,Qty:Qty,amount:amount},
    type: "GET",
    success:  function(data){
        $("#add_card_view").html(data);
        
    }
});
        });                     
        });
        
</script>
@endforeach
  <script>
        var window_size = $('body').innerWidth();
        if (window_size < 991 ) {
            $('.ui-menu').addClass('mob-res-ul');
            $(document).on('click', '.mob-res-ul li', function (e) {
                $(this).toggleClass('icnos-down').children('.dropdown-menu').slideToggle();
            });
            $('.mob-show-bar').click(function() {
                $('.navigation').css('left', '0');
                $('body').addClass('sidebar-open');
            });
            $('.hide-sidebar').click(function(){
                $('.navigation').css('left', '-100%');
                $('body').removeClass('sidebar-open');
            });
            $('.search_icon').click(function(){
                $('.search-bar').slideToggle();
            });
        }
        $('.pin-edit').click(function(){
            $('#pinInput').focus();
        });
    </script>

