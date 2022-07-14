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
                        <li class="home">Book Doctor Appointment</li>
                    </ul>
                </div>
            </div>
        </div>
        @include('flash')
        <div class="container">
            {!!Form::open(['route'=>['frontend.book_an_appointment'],'files'=>true,'class'=>'form-horizontal'])!!}
            <input type="hidden" name="user_id" value="{{\Auth::user()->id}}">
            <div class="row">
                <div class="col-md-6">
                    <div class="cart-product mt-3">
                        <h4>Upload Previous Prescription</h4>
                        <div class="product-details">
                            <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                                <div class="rightside-details col pr-0">
                                    <div class="row m-0">
                                        <div class="product-item-name col pl-0">
                                            <a href="non-prescriptions/natural-power-capsule-60s">Please upload your prescription.</a>
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
                            <div class="product-details">
                                <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                                    <div class="rightside-details col pr-0">
                                        <div class="row m-0">
                                            <div class="product-item-name col pl-0">
                                                <textarea name="symptoms" class="form-control" placeholder="Symptoms"
                                                    maxlength="185"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="cart-product mt-3">
                        <div class="totalamt-col">
                            <h4>Schedule Free Doctor Consultation<span class="save-price"><input type="radio"
                                        name="free_doctor_consult" id="radio_1" checked="checked"></span></h4>
                            <div class="process-col">
                                <label for="radio_1" class="">
                                Please upload your prescription for free consultation with the doctor to validate your prescription.
                                </label>

                            </div>
                            <div class="process-col">
                                <div class="totalamt"><label for="radio_2" class="">Free Doctor Consultation</label>
                                </div>
                                <p>You will be contacted soon</p>
                                <p>* Mon-Sat (9 AM To 9 PM) </p>
                            </div>
                        </div>
                    </div>
                    <div class="cart-product mt-3">
                        <div class="product-details">
                            <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                                <div class="rightside-details col pr-0">
                                    <div class="row m-0">
                                        <div class="col-sm-6">
                                            <div class="product-item-name col pl-0">
                                                <label> You will be contacted on Mobile No.</lebel>
                                                    <input type="number" name="mobile" class="form-control"
                                                        value="{{\Auth::user()->mobile}}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6" style="display: none">
                                            <div class="product-item-name col pl-0">
                                                <label>Doctor Type</lebel>
                                                    <input name="doctor_type" type="hidden" class="form-control" value="1" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 col-xs-12"></div>
                <div class="col-md-2 col-xs-12">
                    <br>
                    <center style="text-align: center;">
                        <button class="add-to-cart" type="submit">
                            Book Now
                        </button>
                    </center>
                </div>
                <div class="col-md-5 col-xs-12"></div>
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
