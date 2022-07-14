@include('frontend.include.head')
@include('frontend.include.header')
                <?php
                $category = \App\Category::find($product->category_id);
                $group = \App\Group::find($product->group_id);
                $groupcategory = \App\Groupcategory::find($product->groupcategory_id);
                $category = \App\Category::find($product->category_id);              
                $product_price = \App\Productprice::where('Product_Code','=',$product->product_code)->where('ProductPriceType_Code','=','9')->first();
                $package = \App\Package::find($product->package_id);
                ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="breadcrumbs">
                <ul class="items">
                   <?php
                    $single_group=\App\Group::where('id','=',$product->group_id)->first();
                    $single_groupcategory= \App\Groupcategory::where('id','=',$product->groupcategory_id)->first();
                    ?>
                   <li class="home"> <a href="{{route('home')}}" title="Go to Home"> Home </a> </li>
                        <li class="home"> <a href="{{route('frontend.group_page',$single_group->url_name)}}" title="Go to {{$single_group->name}}"> {{$single_group->name}} </a> </li>
                        <li class="home"> <a href="{{route('frontend.groupcategory_page',[$single_group->url_name,$single_groupcategory->url_name])}}" title="Go to {{$single_groupcategory->name}}"> {{$single_groupcategory->name}} </a> </li>
                </ul>
            </div>
        </div>
        <div class="col-md-5">
            <ul id="glasscase" class="gc-start">
                 <?php
                                    $product_images = \App\Productimage::where('Product_Code','=',$product->product_code)->get();
                                   
                                    ?>
                                    @foreach($product_images as $product_image)
                                    @if($product_image)
                <li>
                   
                                    
                                    <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}" alt="Nestor Immunity Care">
                                  
                                   
                </li>
                  @endif
                 @endforeach
            </ul>
        </div>
        <div class="col-md-7">
            <div class="delivery-box-div">
                <h4>{{$product->brand_name}}</h4>               
                <span class="tag-detail" style="background: #7bd9ba;color: white">@if($category){{$category->name}}@endif</span>
                <p>{{$product->generic_name}}</p>
                @if($product_price)
                <h3>Price: <small></small> <em class="fa fa-inr"></em> {{$product_price->Price}}/-</h3>
               @endif
               
                
                @if($package)                 
                 <p><b>Packaging:</b>{{$package->Packing_Description}}</p>
                 @endif
               @if($product->manufacture)
               <p><b>Mfr:</b> {{$product->manufacture}}</p>
               @endif
                    <h5>QTY:- </h5>
                    <form action="{{route('frontend.buy_now',$product->id)}}" method="get">
                <div class="row">
                    <div class="col-md-3">
                        <div class="qty-div">
                                <span class="qty_minus" data-id="1">-</span>
                                <input name="Qty" type="number" required="" id="Qty" class="qty_1" min="1" value="1">
                                <span class="qty_plus" data-id="1">+</span>
                            </div>
                    </div>
                    <div class="col-md-3 ">
                        <div>
                            @if($product_price)
                            <input type="hidden" id="amount" value="{{$product_price->Price}}">
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
                    @if($sales_scheme)
                    <div class="col-md-6 mt-3">
                        <div>
                            <div class="offers-box">
                                <h5>Applicable Offers</h5>
                                <p><em class="fa fa-tag"></em> Buy {{$sales_scheme->NextMinSaleQty_ForScheme}} Get {{$sales_scheme->Free_Qty}} Free</p>
                                <p><small>If You Buy One Then You Could Get One  Free</small></p>
                            </div>
                        </div>
                    </div> 
                    @endif
                    <div class="col-md-12 mt-3">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="delivery-box">
                                    <div>
                                        <p><em class="fa-map-marker fa"></em> Delivery to :</p>
                                        <div class="input-group">
                                            <div class="input-group-prepend delivery-input">
                                                <input type="text" class="form-control" id="pincode_value" onkeyup="calc()" placeholder="Enter delivery pincode" aria-label="Username" aria-describedby="">
                                                <span class="input-group-text b-unset" id="basic-addon1"><a class="font-14" href="">check</a></span>
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
                                         <h5 id="pincode_check_data" style="color: red"></h5>                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    </form>
                  @if($product->is_display_expiry=='1') 
                  <?php
                  $expire_date = \App\Stock::where('Product_Code','=',$product->product_code)->first();
                  ?>
                  @if($expire_date)
                <p><b>Before Date: </b> {{$expire_date->EXP_Date->format('d')}} {{$expire_date->EXP_Date->format('M')}} {{$expire_date->EXP_Date->format('Y')}}</p>
                  @endif
                   @endif
                <p style="color: #1daf63"><b>In stock</b></p>
                <p>Sold by <span style="color: #328cad">Nestor Pharmaceuticals Limited </span> and Fulfilled by <span style="color: #328cad">Nestor</span>.</p>
            </div>
        </div>
        <div class="col-md-8">
            <div class="">
                <div class="delivery-box-div mt-3 pro-det">                         
                         @if($descriptiontypes)
                    @foreach($descriptiontypes  as $descriptiontype)
                    <?php
                    $descriptions = \App\Description::where('product_code','=',$product->product_code)->where('description_type_code','=',$descriptiontype->id)->get();
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
                <div class="delivery-box-div mt-3">
                    <h4>Related Products</h4>
                    <div class="row other-sec-devide">
                        <div class="col-md-2 p-2">
                            <img src="img/op-1.jpg" alt="" class="w-100">
                        </div>
                        <div class="col-md-10">
                            <h6><a href="">COMPLAN CHOCOLATE REFILL 500GM</a></h6>
                            <p class="m-0"><em class="fa fa-inr"></em> 80</p>
                            <p class="m-0">Save upto 5%</p>
                        </div>
                    </div>
                    <div class="row other-sec-devide">
                        <div class="col-md-2 p-2">
                            <img src="img/op-1.jpg" alt="" class="w-100">
                        </div>
                        <div class="col-md-10">
                            <h6><a href="">COMPLAN CHOCOLATE REFILL 500GM</a></h6>
                            <p class="m-0"><em class="fa fa-inr"></em> 80</p>
                            <p class="m-0">Save upto 5%</p>
                        </div>
                    </div>
                    <div class="row other-sec-devide">
                        <div class="col-md-2 p-2">
                            <img src="img/op-1.jpg" alt="" class="w-100">
                        </div>
                        <div class="col-md-10">
                            <h6><a href="">COMPLAN CHOCOLATE REFILL 500GM</a></h6>
                            <p class="m-0"><em class="fa fa-inr"></em> 80</p>
                            <p class="m-0">Save upto 5%</p>
                        </div>
                    </div>
                    <div class="row other-sec-devide">
                        <div class="col-md-2 p-2">
                            <img src="img/op-1.jpg" alt="" class="w-100">
                        </div>
                        <div class="col-md-10">
                            <h6><a href="">COMPLAN CHOCOLATE REFILL 500GM</a></h6>
                            <p class="m-0"><em class="fa fa-inr"></em> 80</p>
                            <p class="m-0">Save upto 5%</p>
                        </div>
                    </div>
                    <div class="row other-sec-devide">
                        <div class="col-md-2 p-2">
                            <img src="img/op-1.jpg" alt="" class="w-100">
                        </div>
                        <div class="col-md-10">
                            <h6><a href="">COMPLAN CHOCOLATE REFILL 500GM</a></h6>
                            <p class="m-0"><em class="fa fa-inr"></em> 80</p>
                            <p class="m-0">Save upto 5%</p>
                        </div>
                    </div>
                    <div class="row other-sec-devide">
                        <div class="col-md-2 p-2">
                            <img src="img/op-1.jpg" alt="" class="w-100">
                        </div>
                        <div class="col-md-10">
                            <h6><a href="">COMPLAN CHOCOLATE REFILL 500GM</a></h6>
                            <p class="m-0"><em class="fa fa-inr"></em> 80</p>
                            <p class="m-0">Save upto 5%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                                <a href="{{route('frontend.product_detail',[$prod->group->url_name,$prod->group_category->url_name,$prod->url_name])}}">
                                   <?php
                                    $product_image = \App\Productimage::where('Product_Code','=',$prod->product_code)->first();
                                    ?>
                                    @if($product_image)
                                    <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}" class="img-responsive category_image" alt="Nestor Immunity Care">
                                    @endif
                                </a> 
                            </span> 
                            <div class="diag-txt"> 
                            <span class="clsgetname ellipsis" style="display: -webkit-box;
-webkit-line-clamp: 2;
-webkit-box-orient: vertical;
overflow: hidden;
text-overflow: ellipsis;">{{$prod->brand_name}}</span> 
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
                        <?php
            $product_price = \App\Productprice::where('Product_Code','=',$prod->product_code)->where('ProductPriceType_Code','=','9')->first();                             
            ?>
                                @if($product_price)
                                <span class="price">Rs. {{number_format($product_price->Price, 2, '.', '')}}</span> 
                                @endif
                            </div> 
                            <div class="dia-bottom"> 
                               <span class="book-now"><a href="{{route('frontend.buy_now',$prod->id)}}">Buy Now</a></span>
                                @if($product_price)
                                <input type="hidden" class="amount{{$prod->id}}" value="{{$product_price->Price}}">
                                @endif
                                <input type="hidden" class="product_id{{$prod->id}}" value="{{$prod->id}}">
                                <input type="hidden" class="Qty{{$prod->id}}" value="1">
                                <span class="book-now"><a type="button" class="add-to-your-cart{{$prod->id}}">Add to Cart</a></span> 
                            </div> 
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
    <div class="add-to-cart-fix">
        <div class="fix-card">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-1 p-2">
                            <img src="{{asset($prod->image)}}" alt="" class="w-100">
                        </div>
                        <div class="col-md-11">
                            <h6><a href="">{{$product->brand_name}}</a></h6>
                            @if($product_price)
                            <p class="m-0"><em class="fa fa-inr"></em> {{$product_price->Price}}</p>
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
    $(document).ready( function () {
        $('#glasscase').glassCase({ 'thumbsPosition': 'left', 'widthDisplay' : 450, 'heightDisplay':400});
        $('#exampleFormControlSelect1').selectpicker();
    });
</script>

@foreach($products as $prod)
 <script>
      $(document).ready(function(){
               $(".add-to-your-cart{{$prod->id}}").click(function(){                    
            var product_id = $(".product_id{{$prod->id}}").val();
            var Qty = $(".Qty{{$prod->id}}").val();
             var amount = $(".amount{{$prod->id}}").val();
              
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
      $(document).ready(function(){
               $(".add-to-your-cart").click(function(){                    
            var product_id = $("#product_id").val();
            var Qty = $("#Qty").val();
             var amount = $("#amount").val();
            
                   $.ajax({
    url: "/add_to_carts/add_cart/",
    data: {product_id:product_id,Qty:Qty,amount:amount},
    type: "GET",
    success:  function(data){
        $("#add_card_view").html(data);
        console.log(data);
    }
});
        });                     
        });
        
        </script>     
        
        <script>
    function calc()
    {
        var pincode = document.getElementById('pincode_value').value;
        if(pincode.length == 6){
           alert(pincode);
         $.ajax({
    url: "/frontend/pincode/check",
    data: {pincode:pincode},
    type: "GET",
    success:  function(data){
        $("#pincode_check_data").html(data);
        console.log(data);
    }
});
        }else{
         $("#pincode_check_data").html(" ");   
        }
    }
   </script>