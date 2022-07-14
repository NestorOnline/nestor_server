@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <ul class="items">
                        <li class="home"> <a href="{{route('home')}}" title="Go to Home"> Home </a> </li>
                        <li class="home"> <a href="{{route('frontend.group_page',$single_group->url_name)}}" title="{{$single_group->name}}"> {{$single_group->name}} </a> </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2 pr-0">
                <div class="filter-div">
                    <h4 class="border-b pb-3">Filter</h4>
                    <p>Availability</p>
                    <div class="border-b max-height-filter">
                        <div class="filter-bo">
                            <label class=" style__filter-label___3Jy6h">
                                <input type="checkbox"><span class="style__filter-checkbox___vU8YA"></span>
                                <span class="style__filter-name___A2BgE">
                                    <span>
                                        Exclude out of stock 
                                    </span>
                                </span>
                                <span class="style__filter-count___1B7HQ">73</span>
                            </label>
                        </div>
                        
                    </div>
                    <p>Manufacturers</p>
                    <div class="border-b max-height-filter" >
                        <div class="filter-bo">
                            <label class=" style__filter-label___3Jy6h">
                                <input type="checkbox"><span class="style__filter-checkbox___vU8YA"></span>
                                <span class="style__filter-name___A2BgE">
                                    <span>
                                        Nestor Pharmaceuticals Ltd.
                                    </span>
                                </span>
                                <span class="style__filter-count___1B7HQ">73</span>
                            </label>
                        </div>
                        
                    </div>
                  
                    <p>Brands</p>
                    <div class="border-b max-height-filter">
                        <div class="filter-bo">
                            <label class=" style__filter-label___3Jy6h">
                                <input type="checkbox"><span class="style__filter-checkbox___vU8YA"></span>
                                <span class="style__filter-name___A2BgE">
                                    <span>
                                        Nestor 
                                    </span>
                                </span>
                                <span class="style__filter-count___1B7HQ">73</span>
                            </label>
                        </div>
                        
                    </div>
                    <div  class="border-b">
                        <p>Price</p>
                        <div onclick="slider_submit()">
                            <div class="slider" onclick="slider_submit()"></div>
                            <input type="hidden" id="minval" onkeyup="slider_submit()">
                        <input type="hidden" id="maxval" onkeyup="slider_submit()">
                        <input type="hidden" class="group_id" value="{{$single_group->id}}">
                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="">
                    <div class="">
                        <div class="owl-carousel owl-theme owl-one">
                            <div class="item">
                                <div>
                                    <img src="{{asset('img/slider-2.webp')}}" alt="">
                                </div>
                            </div>
                            <div class="item">
                                <div>
                                    <img src="{{asset('img/slider-1.webp')}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="product_list_view">
                    <div class="col-md-12">
                        <div class="sort-by-div">
                           <div>
                                <h5 class="mb-3">{{$title}}</h5>
                            </div>
                            <div class="sort-by-flter">
                                <span>Sort By: </span>
                                <span><a href="">Popularity</a></span>
                                <span><a href="">High To Low</a></span>
                                <span><a href="">Low To High</a></span>
                                <span><a href="">Discount</a></span>
                            </div>
                        </div>
                    </div>
                    @if(count($products))
                      @foreach($products as $product)
                    <div class="col-md-3">
                        <div class="diag-section"> 
                            <span class="diag-img"> 
                                <a href="{{route('frontend.product_detail',$product->id)}}">
                                    <?php
                                    $product_image = \App\Productimage::where('Product_Code','=',$product->product_code)->first();
                                    ?>
                                     @if($product_image)
                                    @if(!$product_image->PhotoFile_Name==NULL)
                                     <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}" class="img-responsive category_image" alt="Nestor Immunity Care">
                                    @else
                                    <img src="{{asset('default.jpg')}}" class="img-responsive category_image" alt="Nestor Immunity Care">
                                    @endif
                                    @else
                                    <img src="{{asset('default.jpg')}}" class="img-responsive category_image" alt="Nestor Immunity Care">
                                    @endif
                                </a> 
                            </span> 
                            <div class="diag-txt"> 
                                <span class="clsgetname ellipsis">{{$product->brand_name}}</span> 
                                <span class="drug-varients ellipsis">{{$product->generic_name}}</span> 
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
                    @else
                    <div class="col-md-12">
                        <div class="diag-section">
                           <div class="diag-txt"> 
                               <h1><span class="clsgetname ellipsis">Data Not Found</span> </h1>
                            </div> 
                        </div>
                    </div>
                    @endif
                     <ul class="pagination">
                <li>{{$products->links()}}</li> 
                     </ul>
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
var getQueryString = function (parameter) {
    var href = window.location.href;
    var reg = new RegExp('[?&]' + parameter + '=([^&#]*)', 'i');
    var string = reg.exec(href);
    return string ? string[1] : null;
};
// End url 
// // slider call
$('.slider').slider({
    range: true,
    min: 0,
    max: 1000,
    step: 1,
    values: [getQueryString('minval') ? getQueryString('minval') : 300, getQueryString('maxval') ? getQueryString('maxval') : 600],

    slide: function (event, ui) {

        $('.ui-slider-handle:eq(0) .price-range-min').html('' + ui.values[ 0 ]);
        $('.ui-slider-handle:eq(1) .price-range-max').html('' + ui.values[ 1 ]);
        $('.price-range-both').html('<i>' + ui.values[ 0 ] + ' - </i>' + ui.values[ 1 ]);

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

$('.ui-slider-range').append('<span class="price-range-both value"><i>' + $('.slider').slider('values', 0) + ' - </i>' + $('.slider').slider('values', 1) + '</span>');

$('.ui-slider-handle:eq(0)').append('<span class="price-range-min value">' + $('.slider').slider('values', 0) + '</span>');

$('.ui-slider-handle:eq(1)').append('<span class="price-range-max value">' + $('.slider').slider('values', 1) + '</span>');

</script>
@foreach($products as $product)
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
    function slider_submit()
    {
      var minval = $("#minval").val();
      var maxval = $("#maxval").val();
      var group_id = $(".group_id").val(); 
      
      alert(minval);
      alert(maxval);
                   $.ajax({
    url: "/search/group_product_by_price",
    data: {minval:minval,maxval:maxval,group_id:group_id},
    type: "GET",
    success:  function(data){
        $("#product_list_view").html(data);
        console.log(data);
    }
});
    }
     </script>