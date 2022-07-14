@include('frontend.include.head')
@include('frontend.include.header')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="breadcrumbs">
                <ul class="items">
                    <li class="home"> <a href="" title="Go to Home"> Home </a> </li>
                    <li class="home"> <a href="" title="Go to Non-Prescription"> Non-Prescription </a> </li>
                    <li class="home"> <a href="" title="Go to Personal Care"> Personal Care </a> </li>
                </ul>
            </div>
        </div>
        <div class="col-md-5">
            <ul id="glasscase" class="gc-start">
                <li><img src="{{asset($product->image)}}" alt="Text" data-gc-caption="Your caption text" /></li>
                <li><img src="{{asset('img/pro-3.jpg')}}" alt="Text" /></li>
                <li><img src="https://source.unsplash.com/featured?tEchnology" alt="Text" /></li>
                <li><img src="https://source.unsplash.com/featured?teChnology" alt="Text" /></li>
                <li><img src="https://source.unsplash.com/featured?tehNology" alt="Text" /></li>
            </ul>
        </div>
        <div class="col-md-7">
            <div class="delivery-box-div">
                <h4>{{$product->brand_name}}</h4>
                <span class="tag-detail">Fever</span>
                <p> {{$product->generic_name}}</p>
                <h3><small><em class="fa fa-inr"></em></small> {{$product->actual_amount}} <small><s><em class="fa fa-inr"></em> {{$product->mrp_amount}}</s> <small>(Inclusive of all Taxes)</small></small></h3>
                <h5>Product Information</h5>
                <p>Baby's skin is 30% thinner than the adult skin which makes it more vulnerable to damage, and their skin can lose moisture 5 times quicker than the adult skin, which can make it highly dry. Baby Dove Rich Moisture Bar, in the net quantity of 75gms, is the perfect solution to all these issues.</p>
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <div class="offers-box">
                                <h5>Applicable Offers</h5>
                                <p><em class="fa fa-tag"></em> MedPlus Wallet</p>
                                <p><small>18.69% Instant Discount MedPlus Wallet </small></p>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-2">
                        <div>
                            <div class="form-group align-select">
                                <label for="exampleFormControlSelect1">QTY</label>
                                <select class="form-control" id="Qty">
                                    <option data-icon="glyphicon-ok">1</option>
                                    <option data-icon="glyphicon-ok">2</option>
                                    <option data-icon="glyphicon-ok">3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div>
                            <input type="hidden" id="amount" value="{{$product->actual_amount}}">
                            <input type="hidden" id="product_id" value="{{$product->id}}">
                            <button  class="add-to-cart" id="add-to-your-cart">Add to Cart</button>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="delivery-box">
                            <div class="delivery-img mr-3">
                                <img src="img/icons/truck.png" alt="">
                            </div>
                            <div>
                                <p>Delivery charges may apply</p>
                                <h6>Delivery by Oct 17, 2020</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="delivery-box">
                            <div>
                                <p><em class="fa-map-marker fa"></em> Delivery to :</p>
                                <div class="input-group">
                                    <div class="input-group-prepend delivery-input">
                                        <input type="text" class="form-control" id="pincode_value" onkeyup="calc()" placeholder="Enter delivery pincode" aria-label="Username" aria-describedby="">
                                        <span class="input-group-text b-unset" id="basic-addon1"><a class="font-14" href="">check</a></span>                                        
                                    </div>
                                    <h5 id="pincode_check_data" style="color: red"></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="">
                <div class="delivery-box-div mt-3 pro-det">
                    <h4>Product Information</h4>
                    <p>Horlicks Protein+ is a scientifically formulated daily nutrition drink for adult men which helps 
                        support muscle mass and maintains strength over time. It contains 3 times more protein than most
                         other leading health food drinks. It works well as an exercise drink or supplement for men working out at the gym.</p>
                         <p>Horlicks Protein+ is a scientifically formulated daily nutrition drink for adult men which helps 
                        support muscle mass and maintains strength over time. It contains 3 times more protein than most
                         other leading health food drinks. It works well as an exercise drink or supplement for men working out at the gym.</p>
                    <h4>Benefits of the Horlicks Protein+ 400 gm Pet Jar (Vanilla)</h4>
                    <ul class="pl-5">
                        <li>Contains a blend of three high quality proteins Whey, Soy and Casein</li>
                        <li>Triple protein blend providing fast and sustained release of amino acids over time</li>
                    </ul>
                    <h4>Product Specifications of the Horlicks Protein+ 400 gm Pet Jar (Vanilla)</h4>
                    <ul class="pl-5">
                        <li>Flavour: Vanilla</li>
                        <li>Container: Pet Jar</li>
                        <li>Pack of 1 x 400 gm</li>
                        <li>Vegetarian product</li>
                        <li>Shelf Life: 15 months</li>
                        <li>Contains added flavor</li>
                        <li>Contains natural permitted color</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="product-side-list">
                <div class="delivery-box-div mt-3">
                    <h4>Other Products</h4>
                    <div class="row other-sec-devide">
                        <div class="col-md-2 p-2">
                            <img src="{{asset('img/op-1.jpg')}}" alt="" class="w-100">
                        </div>
                        <div class="col-md-10">
                            <h5><a href="">COMPLAN CHOCOLATE REFILL 500GM</a></h5>
                            <p class="m-0"><em class="fa fa-inr"></em> 80</p>
                            <p class="m-0">Save upto 5%</p>
                        </div>
                    </div>
                    <div class="row other-sec-devide">
                        <div class="col-md-2 p-2">
                            <img src="{{asset('img/op-1.jpg')}}" alt="" class="w-100">
                        </div>
                        <div class="col-md-10">
                            <h5><a href="">COMPLAN CHOCOLATE REFILL 500GM</a></h5>
                            <p class="m-0"><em class="fa fa-inr"></em> 80</p>
                            <p class="m-0">Save upto 5%</p>
                        </div>
                    </div>
                    <div class="row other-sec-devide">
                        <div class="col-md-2 p-2">
                            <img src="{{asset('img/op-1.jpg')}}" alt="" class="w-100">
                        </div>
                        <div class="col-md-10">
                            <h5><a href="">COMPLAN CHOCOLATE REFILL 500GM</a></h5>
                            <p class="m-0"><em class="fa fa-inr"></em> 80</p>
                            <p class="m-0">Save upto 5%</p>
                        </div>
                    </div>
                    <div class="row other-sec-devide">
                        <div class="col-md-2 p-2">
                            <img src="{{asset('img/op-1.jpg')}}" alt="" class="w-100">
                        </div>
                        <div class="col-md-10">
                            <h5><a href="">COMPLAN CHOCOLATE REFILL 500GM</a></h5>
                            <p class="m-0"><em class="fa fa-inr"></em> 80</p>
                            <p class="m-0">Save upto 5%</p>
                        </div>
                    </div>
                    <div class="row other-sec-devide">
                        <div class="col-md-2 p-2">
                            <img src="{{asset('img/op-1.jpg')}}" alt="" class="w-100">
                        </div>
                        <div class="col-md-10">
                            <h5><a href="">COMPLAN CHOCOLATE REFILL 500GM</a></h5>
                            <p class="m-0"><em class="fa fa-inr"></em> 80</p>
                            <p class="m-0">Save upto 5%</p>
                        </div>
                    </div>
                    <div class="row other-sec-devide">
                        <div class="col-md-2 p-2">
                            <img src="{{asset('img/op-1.jpg')}}" alt="" class="w-100">
                        </div>
                        <div class="col-md-10">
                            <h5><a href="">COMPLAN CHOCOLATE REFILL 500GM</a></h5>
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
                    <div class="item">
                        <div class="diag-section"> 
                            <span class="diag-img"> 
                                <a href="">
                                    <img src="{{asset('img/pro-1.jpg')}}" class="img-responsive category_image" alt="Nestor Immunity Care">
                                </a> 
                            </span> 
                            <div class="diag-txt"> 
                                <span class="clsgetname ellipsis">Nestor Immunity Care</span> 
                                <span class="drug-varients ellipsis">Healthians</span> 
                            </div> 
                            <div class="diag-price"> 
                            <span class="price">Rs. 5999.00</span> 
                                <span class="final_price"><s>Rs. 1099.00</s></span> 
                                <span class="save">(save upto 80%)</span>
                            </div> 
                            <div class="dia-bottom"> 
                                <span class="book-now"><a href="">Buy Now</a></span>
                                <span class="book-now"><a href="">Add to Cart</a></span>  
                            </div> 
                        </div>
                    </div>
                    <div class="item">
                        <div class="diag-section"> 
                            <span class="diag-img"> 
                                <a href="">
                                    <img src="{{asset('img/pro-2.jpg')}}" class="img-responsive category_image" alt="Nestor Immunity Care">
                                </a> 
                            </span> 
                            <div class="diag-txt"> 
                                <span class="clsgetname ellipsis">Nestor Immunity Care</span> 
                                <span class="drug-varients ellipsis">Healthians</span> 
                            </div> 
                            <div class="diag-price"> 
                            <span class="price">Rs. 5999.00</span> 
                                <span class="final_price"><s>Rs. 1099.00</s></span> 
                                <span class="save">(save upto 80%)</span>
                            </div> 
                            <div class="dia-bottom"> 
                                <span class="book-now"><a href="">Buy Now</a></span>
                                                                <span class="book-now"><a href="">Add to Cart</a></span>  
                            </div> 
                        </div>
                    </div>
                    <div class="item">
                        <div class="diag-section"> 
                            <span class="diag-img"> 
                                <a href="">
                                    <img src="{{asset('img/pro-3.jpg')}}" class="img-responsive category_image" alt="Nestor Immunity Care">
                                </a> 
                            </span> 
                            <div class="diag-txt"> 
                                <span class="clsgetname ellipsis">Nestor Immunity Care</span> 
                                <span class="drug-varients ellipsis">Healthians</span> 
                            </div> 
                            <div class="diag-price"> 
                            <span class="price">Rs. 5999.00</span> 
                                <span class="final_price"><s>Rs. 1099.00</s></span> 
                                <span class="save">(save upto 80%)</span>
                            </div> 
                            <div class="dia-bottom"> 
                                <span class="book-now"><a href="">Buy Now</a></span>
                                                                <span class="book-now"><a href="">Add to Cart</a></span>  
                            </div> 
                        </div>
                    </div>
                    <div class="item">
                        <div class="diag-section"> 
                            <span class="diag-img"> 
                                <a href="">
                                    <img src="{{asset('img/pro-4.jpg')}}" class="img-responsive category_image" alt="Nestor Immunity Care">
                                </a> 
                            </span> 
                            <div class="diag-txt"> 
                                <span class="clsgetname ellipsis">Nestor Immunity Care</span> 
                                <span class="drug-varients ellipsis">Healthians</span> 
                            </div> 
                            <div class="diag-price"> 
                            <span class="price">Rs. 5999.00</span> 
                                <span class="final_price"><s>Rs. 1099.00</s></span> 
                                <span class="save">(save upto 80%)</span>
                            </div> 
                            <div class="dia-bottom"> 
                                <span class="book-now"><a href="">Buy Now</a></span>
                                                                <span class="book-now"><a href="">Add to Cart</a></span>  
                            </div> 
                        </div>
                    </div>
                    <div class="item">
                        <div class="diag-section"> 
                            <span class="diag-img"> 
                                <a href="">
                                    <img src="{{asset('img/pro-2.jpg')}}" class="img-responsive category_image" alt="Nestor Immunity Care">
                                </a> 
                            </span> 
                            <div class="diag-txt"> 
                                <span class="clsgetname ellipsis">Nestor Immunity Care</span> 
                                <span class="drug-varients ellipsis">Healthians</span> 
                            </div> 
                            <div class="diag-price"> 
                            <span class="price">Rs. 5999.00</span> 
                                <span class="final_price"><s>Rs. 1099.00</s></span> 
                                <span class="save">(save upto 80%)</span>
                            </div> 
                            <div class="dia-bottom"> 
                                <span class="book-now"><a href="">Buy Now</a></span>
                                <span class="book-now"><a href="">Add to Cart</a></span>  
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('frontend.include.footer')

<script src="{{asset('js/zoom.js')}}"></script>

<script type="text/javascript">
    $(document).ready( function () {
        $('#glasscase').glassCase({ 'thumbsPosition': 'left', 'widthDisplay' : 450, 'heightDisplay':400});
        $('#exampleFormControlSelect1').selectpicker();
    });
</script>

 <script>
      $(document).ready(function(){
               $("#add-to-your-cart").click(function(){                    
            var product_id = $("#product_id").val();
            var Qty = $("#Qty").val();
             var amount = $("#amount").val();
              alert(Qty);
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