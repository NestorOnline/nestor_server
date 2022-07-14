@include('frontend.include.head')
@include('frontend.include.header')
<style>
.imageThumb {
    max-height: 75px;
    cursor: pointer;
}

.pip {
    display: inline-block;
    margin: 10px 10px 0 0;
}

.remove {
    display: block;
    color: #ee4380;
    text-align: center;
    cursor: pointer;
}

.remove:hover {
    background: white;
    color: black;
}

.min-100 {
    min-height: 100px
}
</style>
<div class="main-div">
    <div class="container-fluid">
        <div>
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <ul class="items">
                        <li class="home"> <a href="" title="Go to Home"> Home </a> </li>
                        <li class="home">Upload Prescription</li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
$gst_amount = 0;
$mrp_total = 0;
$total = 0;
$add_cart_data_total = 0;
$add_cart_datas = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->get();
foreach ($add_cart_datas as $add_cart_data) {
    $add_cart_data_total = $add_cart_data_total + $add_cart_data->amount * $add_cart_data->Qty + $add_cart_data->amount * $add_cart_data->Qty * 12 / 100;
}
$add_cart_data_total = $add_cart_data_total + 50;
?>
        <?php
if ($add_cart_datas == null) {
    $add_cart_datas = [];
}
$date1 = date('Y-m-d', strtotime("+1 day", strtotime(date('Y-m-d'))));
$date5 = date('Y-m-d', strtotime("+4 day", strtotime(date('Y-m-d'))));
?>

        @foreach($add_cart_datas as $key=>$add_cart_data)
        <?php
$subtotal = 0;
$product_cart = \App\Product::find($add_cart_data->product_id);
$subtotal = $add_cart_data->amount * $add_cart_data->Qty;
$total = $total + $subtotal;
$sales_scheme = \App\SalesScheme::where('Product_Code', '=', $product_cart->product_code)->first();
if ($product_cart->customer_mrp_price) {
    $mrp_total = $mrp_total + $product_cart->customer_mrp_price->Price * $add_cart_data->Qty;
}
if ($product_cart->customer_price) {
    $gst_amount = $gst_amount + $subtotal * $product_cart->customer_price->GST / 100;
}

?>
        @endforeach
        @include('flash')
        <div class="container">
            <br>
            <div class="row" style="background: white;">

                <div class="col-md-2">
                    <br>

                    <h3>Upload Prescription</h3>
                </div>
                <div class="col-md-10 hidden-xs">
                    <br>
                    <div class="product-details" style="height: 100px">
                        <div class="steps-from">
                            <ul class="steps-ul list-unstyled">
                                <li class="active li1">My Cart <span></span></li>
                                <li class="active li2">Upload Prescription<span> </span></li>
                                <li class="li3"> Checkout<span></span></li>
                                <li class="li4">Payment <span> </span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            {!!Form::open(['route'=>['frontend.checkout_upload_prescription'],'files'=>true,'class'=>'form-horizontal'])!!}
            <div class="row">


                <div class="col-md-8">
                    <div class="cart-product mt-3">
                        <h4>Upload</h4>
                        <div class="product-details">
                            <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                                <div class="rightside-details col pr-0">
                                    <div class="row m-0">
                                        <div class="product-item-name col pl-0">
                                            <a href="non-prescriptions/natural-power-capsule-60s">lease upload images of
                                                valid prescription from your doctor.</a>
                                        </div>
                                    </div>
                                    <div class="deliveryby row m-0 mt-2">
                                        <div class="item-prices col-12 p-0 text-left">
                                            <div class="discount-val text-center my-4"><label
                                                    for="upload_prescription"><a class="btn btn-sm btn-info"
                                                        style="color: white"><span
                                                            id="row_itmdiscprice_922086">Upload</span></a></div>
                                            <input type="file" id="upload_prescription" multiple
                                                name="upload_prescription[]" style="display:none" id="">
                                            <div class="min-100">
                                                <div id="added_image"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="cart-product mt-3">
                        <div class="totalamt-col">
                            <h4>Schedule Free Doctor Consultation<span class="save-price"><input type="radio"
                                        name="free_doctor_consult" id="radio_1"></span></h4>
                            <div class="process-col">
                                <div class="totalamt"><label for="radio_1" class="">No Prescription Don't Worry Consult
                                        Certificate Doctor to Get a Valid Prescription</label>
                                </div>
                            </div>
                            <div class="process-col">
                                <div class="totalamt"><label for="radio_2" class="">Free Doctor Consultation</label>
                                </div>
                                <p>you Will Recieve a Call Within Next 2-4 Working Hour</p>
                                <p>Our Working Hours from 9 AM To 9 PM</p>
                                <p>Your Prescription Will be Sent Directly to the Pharmacist for processing</p>
                            </div>

                        </div>
                    </div>
                </div>
                <?php
$grand_total = 0;
$delevery_charge = 50;
$cart_total_charge = 0;
$cart_total_charge = $total + $gst_amount + $delevery_charge;
$grand_total = $cart_total_charge - $wallet;
?>
                <div class="col-md-4">
                    <div>
                        <div class="totalamt-col">
                            <h4>ORDER DETAILS</h4>
                            <div class="allcalculation">
                                <div class="subtoal" style="display: none"><label _ngcontent-tlt-c6="">Total
                                        MRP</label><span>Rs.<span id="mrp_total">
                                            {{number_format($mrp_total, 2, '.', ',')}}</span></span>
                                </div>
                                <div class="subtoal"><label _ngcontent-tlt-c6="">Item Amount</label><span
                                        id="cart_sub_total">Rs. {{number_format($total, 2, '.', ',')}}</span></div>
                                <div class="shipping-charges"><label _ngcontent-tlt-c6="">GST Amount</label><span
                                        id="gst_amount">Rs. {{number_format($gst_amount, 2, '.', ',')}}</span></div>
                                <div class="shipping-charges"><label _ngcontent-tlt-c6="">Delivery Charges</label><span
                                        id="cart_del_charge">Rs. 50.00</span></div>
                            </div>
                            <div class="allcalculation">
                                <div class="shipping-charges"><label _ngcontent-tlt-c6="">Order Value</label><span
                                        id="cart_del_charge">Rs.
                                        {{number_format($cart_total_charge, 2, '.', ',')}}</span></div>
                                @if($wallet)
                                <div class="shipping-charges"><label _ngcontent-tlt-c6="">Wallet Amount</label><span
                                        id="cart_del_charge">-Rs. {{number_format($wallet, 2, '.', ',')}}</span></div>
                                @endif
                            </div>
                            <div class="process-col">
                                <div class="totalamt"><span class="text">Payable
                                        Amount</span><span class="save-price">Rs.
                                        @if($grand_total < 0) 0 @else {{number_format($grand_total, 2, '.', '')}} @endif
                                            </span>
                                </div>
                            </div>
                            <div class="p-3">
                                <button class="add-to-cart" type="submit">Continue for payment</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
    @include('frontend.include.footer')
    <script>
    $(document).ready(function() {
        if (window.File && window.FileList && window.FileReader) {
            $("#upload_prescription").on("change", function(e) {
                var files = e.target.files,
                    filesLength = files.length;
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i]
                    var fileReader = new FileReader();
                    fileReader.onload = (function(e) {
                        var file = e.target;
                        $("<span class=\"pip\">" +
                            "<img class=\"imageThumb\" src=\"" + e.target.result +
                            "\" title=\"" + file.name + "\"/>" +
                            "<br/><span class=\"remove\"><em class='fa fa-trash'></em></span>" +
                            "</span>").insertAfter("#added_image");
                        $(".remove").click(function() {
                            $(this).parent(".pip").remove();
                        });
                    });
                    fileReader.readAsDataURL(f);
                }
                console.log(files);
            });
        } else {
            alert("Your browser doesn't support to File API")
        }
    });
    </script>