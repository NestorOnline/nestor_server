@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container">
        <div id="card_view">
                                 <?php                                  
                                  $total =0;
                                  if($add_cart_datas == null){
                                     $add_cart_datas = [];
                                    }
                                  ?>
            @if(count($add_cart_datas))
            <div class="row">
                <div class="col-md-12">
                    <div class="py-3">
                        <h3>Cart Items <span>(5)</span></h3>
                    </div>
                </div>
                <div class="col-md-8">
                    <div>
                        <div>
                            <div>
                                <div class="cart-product">
                                    <h4>Order Summary</h4>
                                 
                                    
                                    @foreach($add_cart_datas as $key=>$add_cart_data)
                                    <?php
                                    $subtotal = 0;
                                    $product_cart=\App\Product::find($add_cart_data->product_id);                                     
                                    $subtotal = $add_cart_data->amount*$add_cart_data->Qty;
                                    $total = $total + $subtotal;
                                    ?>
                                    <div class="product-details delete_mem{{$add_cart_data->product_id}}">
                                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                                            <div class="leftside-icons col-md-2 p-0">
                                                <a class="product-item-photo" title="{{$product_cart->brand_name}}">
                                                    <img src="{{asset($product_cart->image)}}" alt="" class="pro-img">
                                                </a>
                                            </div>
                                            <div class="rightside-details col pr-0">
                                                <div class="row m-0">
                                                    <div class="product-item-name col pl-0">
                                                        <a href="{{$product_cart->brand_name}}">{{$product_cart->brand_name}}</a>
                                                    </div>
                                                    <div class="item-prices col-2 p-0 text-right">
                                                        <div class="discount-val"><span id="row_itmdiscprice_922086">Rs.{{$subtotal}}</span></div>
                                                    </div>
                                                </div>
                                                <div class="row m-0 mt-3">
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0">Mfr: Nestor Pharmaceuticals Limited</p>
                                                        <p class="form m-0">Unit Price : Rs. {{$product_cart->actual_amount}}/-</p>
                                                    </div>
                                                    <div class="item-qty col-3 p-0">
                                                        <div>
                                                            <div class="form-group align-select m-0">
                                                                <h5>QTY:- </h5>
                                                                <div class="qty-div">
                                                                    <span class="qty_minus" data-id="{{$add_cart_data->product_id}}" onclick="quantity{{$add_cart_data->product_id}}_change_minus()">-</span>
                                                                    <input type="number" required="" name="Qty" class="qty_{{$add_cart_data->product_id}}" min="1" max="10" onchange="quantity{{$add_cart_data->product_id}}_change()" value="{{$add_cart_data->Qty}}"  id="quantity_id{{$add_cart_data->product_id}}">
                                                                    <span class="qty_plus" data-id="{{$add_cart_data->product_id}}" onclick="quantity{{$add_cart_data->product_id}}_change_plus()">+</span>
                                                                </div>
                                                                <input type="hidden" id="product_id{{$add_cart_data->product_id}}" value="{{$product_cart->id}}">
                                                                <input type="hidden" id="price_amount{{$add_cart_data->product_id}}" value="{{$product_cart->actual_amount}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="deliveryby row m-0 mt-2">
                                                    <div class="date deldate col pl-0">
                                                        <div class="deliveryby"> Delivery between Oct 22nd-24th </div>
                                                    </div>
                                                    <div class="remove-drug col-2 p-0 text-right">                                                      
                                                        <input type="hidden" id="sub_total{{$add_cart_data->product_id}}" class="form-control" name="total_amt" value="{{$subtotal}}">  
                                                        <button type="button" class="removeitem{{$add_cart_data->product_id}}" onclick="remove{{$add_cart_data->product_id}}_function()" value="{{$add_cart_data->product_id}}" title="Remove item">Remove</button>
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
                <?php
                $grand_total =0;
                $delevery_charge=50;
                $grand_total =$total + $delevery_charge - $wallet;
                ?>
                <div class="col-md-4">
                    <div>
                        <div class="totalamt-col">
                            <h4>PAYMENT DETAILS</h4>
                            <div class="allcalculation">
                                
                                <div class="subtoal"><label _ngcontent-tlt-c6="">MRP Total</label>Rs.<span id="cart_sub_total" > {{$total}}</span></div>
                                <div class="shipping-charges"><label _ngcontent-tlt-c6="">Delivery Charges</label>Rs.<span id="cart_del_charge"> {{$delevery_charge}}</span></div>
                                @if($wallet)
                                 <div class="shipping-charges"><label _ngcontent-tlt-c6="">Wallet Amount</label>Rs.<span id="cart_del_charge"> -{{$wallet}}</span></div>
                                 @endif
                            </div>
                            <div class="process-col">
                                <div class="totalamt"><span class="text">TOTAL AMOUNT</span>Rs.<span class="save-price" id="grand_total_amount"> {{$grand_total}}</span></div>
                            </div>
                            <div class="p-3">
                                <a href="{{route('frontend.checkout')}}" class="add-to-cart">Continue for payment</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
             <div>
                                    <span class="book-now"><a href="{{route('home')}}" class="btn btn-sm btn-block">Back To Home Page</a></span>
                                </div>
            @endif
        </div>
         <div id="empty_card_view" style="display: none">
                                    <span class="book-now"><a href="{{route('home')}}" class="btn btn-sm btn-block">Back To Home Page</a></span>
                                </div>
    </div>
</div>
@include('frontend.include.footer')
<script>
$(document).ready( function () {
    $('#glasscase').glassCase({ 'thumbsPosition': 'left', 'widthDisplay' : 450, 'heightDisplay':400});
    $('.quantity').selectpicker();
});
</script>
@foreach($add_cart_datas as $key=>$add_cart_data)
<script type="text/javascript">
      function remove{{$add_cart_data->product_id}}_function() {
                   alert('jbdsjbsdj');
                   var mb = document.getElementById("cart_sub_total");
                   var grand_total = document.getElementById("grand_total_amount");                  
            var remove_key = $(".removeitem{{$add_cart_data->product_id}}").val();
            var sub_total = $("#sub_total{{$add_cart_data->product_id}}").val();
          
            alert(sub_total);
              alert(remove_key);
                   $.ajax({
    url: "/add_to_carts/remove_cart/",
    data: {remove_key:remove_key,sub_total:sub_total},
    type: "GET",
    success:  function(data){
        $("#add_card_view").html(data);
       var cart_sub_total  = mb.innerHTML - sub_total;
       var grand_total_amount = grand_total.innerHTML - sub_total;
        document.getElementById("cart_sub_total").innerHTML =   cart_sub_total;
         document.getElementById("grand_total_amount").innerHTML =   grand_total_amount;
        console.log(data);
        $(".delete_mem" + remove_key).remove();
        if(cart_sub_total=="0"){
          $('#empty_card_view').css('display','block');
          $('#card_view').css('display','none');
          }
    }
});
      }
        
        </script>
        
   <script type="text/javascript">   
     function quantity{{$add_cart_data->product_id}}_change() {
          var price_amount = $("#price_amount{{$add_cart_data->product_id}}").val();
          var Qty = $("#quantity_id{{$add_cart_data->product_id}}").val();
          var product_id = $("#product_id{{$add_cart_data->product_id}}").val();
          var key_value = "{{$add_cart_data->product_id}}"; 
          var mb = document.getElementById("cart_sub_total");
          var grand_total = document.getElementById("grand_total_amount");
          var sub_total = $("#sub_total{{$add_cart_data->product_id}}").val();
          alert(mb.innerHTML);
         alert(Qty);
          alert(grand_total.innerHTML);
           alert(sub_total);
            alert(price_amount);            
             alert(grand_total.innerHTML);
             alert(grand_total.innerHTML);
         $.ajax({
    url: "/add_to_carts/change_qty/",
    data: {Qty:Qty,key_value:key_value,product_id:product_id}, 
    type: "GET",
    success:  function(data){
       var cart_sub_total  = mb.innerHTML - sub_total + Qty*price_amount;
       var grand_total_amount = grand_total.innerHTML - sub_total + Qty*price_amount;
       var update_subtotal = Qty*price_amount;
        document.getElementById("cart_sub_total").innerHTML =   cart_sub_total;
         document.getElementById("grand_total_amount").innerHTML =   grand_total_amount;
          document.getElementById("total_amount_update").innerHTML =   grand_total_amount;
           document.getElementById("Qty_update{{$add_cart_data->product_id}}").innerHTML =   Qty;

          console.log(data);
  $(".delete_mem{{$add_cart_data->product_id}}").html(data);
    }
});
             
     }
     </script>
     
     <script type="text/javascript">   
     function quantity{{$add_cart_data->product_id}}_change_minus() {
          var price_amount = $("#price_amount{{$add_cart_data->product_id}}").val();
          var Qty = $("#quantity_id{{$add_cart_data->product_id}}").val() - 1;             
          var product_id = $("#product_id{{$add_cart_data->product_id}}").val();
          var key_value = "{{$add_cart_data->product_id}}"; 
          var mb = document.getElementById("cart_sub_total");
          var grand_total = document.getElementById("grand_total_amount");
          var sub_total = $("#sub_total{{$add_cart_data->product_id}}").val();
           alert(Qty);
          alert(mb.innerHTML);
          alert(grand_total.innerHTML);
           alert(sub_total);
            alert(price_amount);
             alert(grand_total.innerHTML);
         $.ajax({
    url: "/add_to_carts/change_qty/",
    data: {Qty:Qty,key_value:key_value,product_id:product_id}, 
    type: "GET",
    success:  function(data){
 var cart_sub_total  = mb.innerHTML - sub_total + Qty*price_amount;
       var grand_total_amount = grand_total.innerHTML - sub_total + Qty*price_amount;
       var update_subtotal = Qty*price_amount;
        document.getElementById("cart_sub_total").innerHTML =   cart_sub_total;
         document.getElementById("grand_total_amount").innerHTML =   grand_total_amount;
          document.getElementById("total_amount_update").innerHTML =   grand_total_amount;
           document.getElementById("Qty_update{{$add_cart_data->product_id}}").innerHTML =   Qty;
          console.log(data);
  $(".delete_mem{{$add_cart_data->product_id}}").html(data);
    }
});
             
     }
     </script>
     <script type="text/javascript">   
     function quantity{{$add_cart_data->product_id}}_change_plus() {
         var price_amount = $("#price_amount{{$add_cart_data->product_id}}").val();
          var Qty = Number($("#quantity_id{{$add_cart_data->product_id}}").val()) + 1;             
          var product_id = $("#product_id{{$add_cart_data->product_id}}").val();
          var key_value = "{{$add_cart_data->product_id}}"; 
          var mb = document.getElementById("cart_sub_total");
          var grand_total = document.getElementById("grand_total_amount");
          var sub_total = $("#sub_total{{$add_cart_data->product_id}}").val();
          alert(Qty);
          alert(mb.innerHTML);
          alert(grand_total.innerHTML);
           alert(sub_total);
            alert(price_amount);
             alert(grand_total.innerHTML);
         $.ajax({
    url: "/add_to_carts/change_qty/",
    data: {Qty:Qty,key_value:key_value,product_id:product_id}, 
    type: "GET",
    success:  function(data){
   var cart_sub_total  = mb.innerHTML - sub_total + Qty*price_amount;
       var grand_total_amount = grand_total.innerHTML - sub_total + Qty*price_amount;
       var update_subtotal = Qty*price_amount;
        document.getElementById("cart_sub_total").innerHTML =   cart_sub_total;
         document.getElementById("grand_total_amount").innerHTML =   grand_total_amount;
          document.getElementById("total_amount_update").innerHTML =   grand_total_amount;
           document.getElementById("Qty_update{{$add_cart_data->product_id}}").innerHTML =   Qty;
          console.log(data);
  $(".delete_mem{{$add_cart_data->product_id}}").html(data);
    }
});
                     
     }
     </script>
        @endforeach