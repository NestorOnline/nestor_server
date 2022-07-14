@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container">
        <div>
            <div class="row">
                <div class="col-md-12">
                    <div class="py-3">
                        <h3>Order Review</h3>
                    </div>
                </div>
                <div class="col-md-8">
                    <div>
                        <div>
                            <div>
                                <div class="cart-product">
                                    <h4>MEDICINES</h4>
                                     <?php
                                  $gst_amount = 0;
                                  $total =0;
                                   $date1= date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))));
                                               $date5= date('Y-m-d', strtotime("+4 day", strtotime(date('Y-m-d'))));
                                  ?>
                                    @foreach($add_to_cards as $add_cart_data)
                                    <?php
                                    $subtotal = 0;
                                    $product_cart=\App\Product::find($add_cart_data->product_id);  
                                    $package = \App\Package::find($product_cart->package_id);  
                                         
                                    $sales_scheme = \App\SalesScheme::where('Product_Code','=',$product_cart->product_code)->first();
                                    $subtotal = $add_cart_data->amount*$add_cart_data->Qty;
                                    $total = $total + $subtotal;
                                    $product_price = \App\Productprice::where('Product_Code','=',$product_cart->product_code)->where('ProductPriceType_Code','=','9')->first();                            
                                   if($product_price){
                                    $gst_amount = $gst_amount + $subtotal*$product_price->GST/100;
                                   }
                                    ?>
                                    <div class="product-details">
                                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                                            <div class="leftside-icons col-md-2 p-0">
                                                <a class="product-item-photo" title="{{$product_cart->brand_name}}">
                                                                                           <?php
                                    $product_image = \App\Productimage::where('Product_Code','=',$product_cart->product_code)->first();
                                    ?>
                                    @if($product_image)
                                    <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}"   class="pro-img" alt="Nestor Immunity Care">
                                    @endif
                                                </a>
                                            </div>
                                            <div class="rightside-details col pr-0">
                                                <div class="row m-0">
                                                    <div class="product-item-name col pl-0">
                                                        <a href="{{route('frontend.product_detail',[$product_cart->group->url_name,$product_cart->group_category->url_name,$product_cart->url_name])}}{{$product_cart->brand_name}}">{{$product_cart->generic_name}} ({{$product_cart->brand_name}})</a>
                                                    </div>
                                                    <div class="item-prices col-2 p-0 text-right">
                                                        <div class="discount-val"><span id="row_itmdiscprice_922086">Rs.{{$subtotal}}</span></div>
                                                    </div>
                                                </div>
                                                <div class="row m-0 mt-2">
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0">Mfr: Numinous Products Pvt Ltd</p>
                                                    </div>
                                                </div>
                                                <div class="row m-0 mt-1">
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0">
                                                        @if($package)
                                                        {{$package->Packing_Description}}
                                                        @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row m-0 mt-1">
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0">Seller : PLANET PHARMA</p>
                                                    </div>
                                                </div>
                                                <div class="deliveryby row m-0 mt-2">
                                                    <div class="date deldate col pl-0">
                                                        <div class="deliveryby">Quantity :- {{$add_cart_data->Qty}}</div>
                                                    </div>
                                                    <div class="date deldate col pl-0">
                                                        <div class="deliveryby">Amount :- {{$add_cart_data->Qty}} X {{$add_cart_data->amount}}</div>
                                                    </div>
                                                    <div class="item-qty col-5 p-0">
                                                        <div>
                                                            <div class="form-group m-0 text-right">
                                                                <div class="deliveryby"> Delivery between {{date("M", strtotime($date1))}} {{date("d", strtotime($date1))}}- {{date("M", strtotime($date5))}}  {{date("d", strtotime($date5))}}  </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="cart-product mt-3">
                                    <h4>Delivery Address</h4>
                                    <div class="product-details" id="Add_address">
                                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                                            <div class="rightside-details col pr-0">
                                                @if($address)
                                                @if($address->full_name&&$address->address1&&$address->city&&$address->pincode&&$address->state)
                                                <div class="row m-0">
                                                    <div class="product-item-name col pl-0">
                                                        <a href="#">{{$address->full_name}}</a>
                                                    </div>
                                                </div>
                                                <div class="row m-0 mt-2">
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0">{{$address->address1}}</p>
                                                    </div>
                                                </div>
                                                <div class="row m-0 mt-2">
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0">{{$address->address1}}</p>
                                                    </div>
                                                </div>
                                                <div class="row m-0 mt-1">
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0">{{$address->city}} ( {{$address->pincode}} ), {{$address->state}}</p>
                                                    </div>
                                                </div>
                                                <div class="deliveryby row m-0 mt-2">
                                                    <div class="date deldate col pl-0">
                                                        <div class="deliveryby">+91 {{$address->phone_no}}</div>
                                                    </div>
                                                    <div class="item-prices col-2 p-0 text-right">
                                                        <div class="discount-val"><a href="javascript:void(0)" data-toggle="modal" data-target="#modify_address"><span id="row_itmdiscprice_922086">Change</span></a></div>
                                                    </div>
                                                    
                                                    <div class="item-prices col-2 p-0 text-right">
                                                        <div class="discount-val"><a href="{{route('dashboard.delivery_address',\Auth::user()->id)}}" data-toggle="modal" data-target="#modify_address"><span id="row_itmdiscprice_922086">Change Address</span></a></div>
                                                    </div>
                                                </div>
                                                @endif
                                                @else
                                                <div class="row m-0">
                                                    <div class="product-item-name col pl-0">
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modify_address"><span id="row_itmdiscprice_922086">Add Address</span></a>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <?php
                $grand_total =0;
                $delevery_charge=0;
                $grand_total =$total+$gst_amount+ $delevery_charge - $wallet;
                ?>
                <div class="col-md-4">
                    <div>
                        <div class="totalamt-col">
                            <h4>ORDER DETAILS</h4>
                            <div class="allcalculation">
                                <div class="subtoal"><label _ngcontent-tlt-c6="">MRP Total</label><span id="cart_sub_total">Rs.{{number_format($total, 2, '.', '')}}</span></div>
                                <div class="shipping-charges"><label _ngcontent-tlt-c6="">GST Amount</label>Rs.<span id="gst_amount"> {{number_format($gst_amount, 2, '.', '')}}</span></div>
                                <div class="shipping-charges"><label _ngcontent-tlt-c6="">Delivery Charges</label><span id="cart_del_charge">Rs.50.00</span></div>
                                 @if($wallet)
                                <div class="shipping-charges"><label _ngcontent-tlt-c6="">Wallet Amount</label><span id="cart_del_charge">-Rs.{{number_format($wallet, 2, '.', '')}}</span></div>
                                 @endif
                            </div>
                            <div class="process-col">
                                <div class="totalamt"><span class="text">Payable
Amount</span><span class="save-price">Rs. {{number_format($grand_total, 2, '.', '')}}</span></div>
                            </div>
                            <div class="p-3">
                                @if($address->full_name&&$address->address1&&$address->city&&$address->pincode&&$address->state)
                                  <a href="{{route('payment.pay')}}" class="add-to-cart">Pay</a>
                                 @else
                                 <a type="button" class="add-to-cart" id="check_address">Pay</a>
                                 @endif
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modify_address" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Address</h3>
            </div>
            <div class="modal-body">
                <div class="select-add-box">
                    <div class="row">
                     
                        <div class="col-md-12">
                            <label for=""><strong>Full Name</strong></label>
                            <div class="input-group mb-5">
                                <div>
                                    <span class="basic-addon1"></span>
                                    <input type="text" class="form-control" id="full_name_value"  placeholder="enter your Full name" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                <div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for=""><strong>Address1</strong></label>
                            <div class="input-group mb-5">
                                <div >
                                    <span class="basic-addon1"></span>
                                    <input type="text" class="form-control" id="address_value1"  placeholder="Enter Your Address 1" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for=""><strong>Address2</strong></label>
                            <div class="input-group mb-5">
                                <div >
                                    <span class="basic-addon1"></span>
                                    <input type="text" class="form-control" id="address_value2"  placeholder="Enter Your Address 2" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                           <div class="col-md-12">
                            <label for=""><strong>Pin Code</strong></label>
                            <div class="input-group mb-5">
                                <div >
                                    <span class="basic-addon1"></span>
                                    <input type="text" class="form-control" id="pincode_value" onkeyup="calc()"  placeholder="enter your pin code" aria-label="Username" aria-describedby="basic-addon1">
                                <h5 id="pincode_check_data" style="color: red"></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for=""><strong>City</strong></label>
                            <div class="input-group mb-5">
                                <div >
                                    <span class="basic-addon1"></span>
                                  <input type="text" class="form-control" id="city_value"  placeholder="enter your pin code" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for=""><strong>State</strong></label>
                            <div class="input-group mb-5">
                                <div >
                                    <span class="basic-addon1"></span>
                                    <input type="text" class="form-control"  id="state_value"  aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group mb-5">
                                <div class="input-group-prepend">
                                    <span class="input-group-text basic-addon1" id="basic-addon1">+91</span>
                                    <input type="number" class="form-control" id="phone_no_value"  placeholder="Enter your Phone no" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a type="button" href="javascript:void(0)"  onclick="myFunction()" class="btn btn-primary">Save Address</a>
                <a type="button" href="javascript:void(0)" class="btn btn-secondary" id="cancel-btn" data-dismiss="modal">Cancel</a>
            </div>
        </div>
    </div>
</div>

@include('frontend.include.footer')
        <script>
    function calc()
    {
        var pincode = document.getElementById('pincode_value').value;    
        if(pincode.length == 6){
           
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
   
<script>
$(document).ready( function () {
    $('#glasscase').glassCase({ 'thumbsPosition': 'left', 'widthDisplay' : 450, 'heightDisplay':400});
    $('.quantity').selectpicker();
});
</script>
<script>
    function myFunction()
    {
         
        var full_name = document.getElementById('full_name_value').value;
     
        var address1 = document.getElementById('address_value1').value;
        var address2 = document.getElementById('address_value2').value;
        var pincode = document.getElementById('pincode_value').value;
        var city = document.getElementById('city_value').value;
        var state = document.getElementById('state_value').value;
        var phone_no = document.getElementById('phone_no_value').value;
 alert(full_name);
        if(pincode.length == 6){
           
         $.ajax({
    url: "/frontend/add_address",
    data: {full_name:full_name,address1:address1,address2:address2,pincode:pincode,city:city,state:state,phone_no:phone_no},
    type: "GET",
    success:  function(data){
        $("#Add_address").html(data);
         document.getElementById("cancel-btn").click();   
    }
});
        }else{
         $("#pincode_check_data").html(" ");   
        }
    }
   </script>
        
 <script>
      $(document).ready(function(){
               $("#check_address").click(function(){
        var full_name = document.getElementById('full_name').value;
        var address1 = document.getElementById('address_value1').value;
        var address2 = document.getElementById('address_value2').value;
        var pincode = document.getElementById('pincode_value').value;
        var city = document.getElementById('city_value').value;
        var state = document.getElementById('state_value').value;
        var phone_no = document.getElementById('phone_no_value').value;
                   if(full_name&&address1&&pincode&&city&&state&&phone_no){
                      location.replace("http://nestor_update.testing/payment/pay");  
                   }else{
                     alert('Please Add Your Address');    
                   }
                     
        });                     
        });       
</script>


