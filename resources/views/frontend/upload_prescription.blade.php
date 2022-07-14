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
    </div>

    <div class="container">

        {!!Form::open(['route'=>['frontend.upload_prescription_store'],'files'=>true,'class'=>'form-horizontal'])!!}
        <div class="row">
            <div class="col-md-12">
                <div class="py-3">
                    <h3>Upload Your Prescription</h3>
                </div>
            </div>

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
                                        <div class="discount-val text-center my-4"><label for="upload_prescription"><a
                                                    class="btn btn-sm btn-info" style="color: white"><span
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
            </div>
            <div class="col-md-4">
                <div>
                    <div class="totalamt-col">
                        <h4>PAYMENT DETAILS</h4>
                        <div class="process-col">
                            <div class="totalamt"><label for="radio_1" class="">Search and Add medicines</label><span
                                    class="save-price"><input type="radio" name="get_data" value="add_medicine"
                                        id="radio_1" checked="checked"></span>
                            </div>
                            <p>Nestor pharmacist/doctors will call to confirm medicines</p>
                        </div>
                        <div class="process-col">
                            <div class="totalamt"><label for="radio_2" class="">Get call from Nestor</label><span
                                    class="save-price"><input type="radio" name="get_data" value="get_call"
                                        id="radio_2"></span></div>
                            <p>Nestor pharmacist/doctors will call to confirm medicines</p>
                        </div>
                        <div class="p-3">
                            <button type="submit" class="add-to-cart">Continue</button>
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