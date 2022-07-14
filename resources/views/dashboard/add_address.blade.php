@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <ul class="items">
                        <li class="home"> <a href="{{route('home')}}" title="Go to Home"> Home </a> </li>
                        <li class="home"> <a href="{{route('dashboard.my_profile')}}" title="Go to Home"> Dashboard </a>
                        </li>
                        <li class="home">Address Address</li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
$statesOp = '';
$citiesOp = '';

foreach ($states as $state) {
    $statesOp = $statesOp . '<option value="' . $state->id . '">' . $state->name . '</option>';
    foreach ($state->cities as $city) {
        $citiesOp = $citiesOp . '<option value="' . $city->id . '" class="' . $state->id . '">' . $city->name . '</option>';
    }
}
?>
        @include('flash')
        <div class="row">
            @include('frontend.include.dashboard_sidebar')
            <div class="col-md-9">

                <div>
                    <div class="cart-product mt-3">
                        <h4>Add A New Address</h4>
                        {!!Form::open(['route'=>['dashboard.add_address'],'files'=>true,'class'=>'form-horizontal'])!!}

                        <div class="select-add-box">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for=""><strong>Name*</strong></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="text" name="Contact_Person" id="Contact_Person"
                                                class="form-control" value="{{old('Contact_Person')}}"
                                                placeholder="Enter your Name" aria-label="Username"
                                                aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><strong>Mobile No.*</strong></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input  type="text" maxlength="10" min=10 max="10"onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" pattern="[0-9]{10}" name="Mobile_No" class="form-control"
                                                value="{{old('Mobile_No')}}" placeholder="Enter your 10 Digit No."
                                                aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><strong>PIN*</strong></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input   type="text" maxlength="6" min=6 max="6" pattern="[0-9]{6}" name="PIN" id="pincode" onkeyup="calc()"
                                                value="{{old('pincode')}}" class="form-control"
                                                placeholder="Enter your pin code" aria-label="Username"
                                                aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <div class="rightside-details col-md-6 pr-0">
                                    <label for=""><strong>Address Line 1*</strong></label>
                                    <div class="input-group mb-3">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="text" class="form-control" name="Address1" id="Address1"
                                                value="{{old('Address1')}}" placeholder="Enter Line Address 1"
                                                aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <div class="rightside-details col-md-6 pr-0">
                                    <label for=""><strong>Address Line 2</strong></label>
                                    <div class="input-group mb-3">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="text" class="form-control" name="Address2" id="Address2"
                                                value="{{old('Address2')}}" placeholder="Enter Line Address 2"
                                                aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <div class="rightside-details col-md-6 pr-0">
                                    <label for=""><strong>Address Line 3</strong></label>
                                    <div class="input-group mb-3">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="text" class="form-control" name="Address3" id="Address3"
                                                value="{{old('Address3')}}" placeholder="Enter Line Address 3"
                                                aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <div class="rightside-details col-md-6 pr-0">
                                    <label for=""><strong>State*</strong></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <select name="State_Code" id="state_id" tooltiptext="Select the reason"
                                                tabindex="13" class="form-control ">
                                                <option value="">---Select---</option>
                                                {!!$statesOp!!}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="rightside-details col-md-6 pr-0">
                                    <label for=""><strong>City*</strong></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <select name="City_Code" id="city_id" tooltiptext="Select the reason"
                                                tabindex="13" class="form-control ">
                                                <option value="">---Select---</option>
                                                {!!$citiesOp!!}
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <label for=""><strong>Address Type*</strong></label>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="radio" class="" name="address_type" value="is_home"
                                                id="is_home" aria-describedby="basic-addon1"> <span>Home</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="radio" class="" name="address_type" value="is_work"
                                                id="is_work" aria-describedby="basic-addon1"> <span>Work</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="hide_form btn btn-primary">Submit</button>
                                <button type="button" class="hide_form btn btn-primary"
                                    onclick="cancel_button()">Cancel</button>
                            </div>
                        </div>
                        {!!Form::close()!!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('frontend.include.footer')
<script src="{{asset('js\ajax.googleapis.com-ajax-1.11.2-jquery-min.js')}}"></script>
<script src="{{asset('js\malsup.github.io.js')}}"></script>
<script src="{{asset('jquery.chained.min.js')}}"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $("#city_id").chained("#state_id");
});
</script>
<script>
function calc() {
    var pincode = document.getElementById('pincode').value;
    if (pincode.length == 6) {

        $.ajax({
            url: "/dashboard/pincode/check",
            data: {
                pincode: pincode
            },
            type: "GET",
            success: function(data) {

                if (data.message == "Data Fetch Successfully") {
                    $("#state_id").val(data.data.state_id).trigger("change");
                    $("#city_id").val(data.data.city_id).trigger("change");
                } else {
                    $("#state_id").val("").trigger("change");
                    $("#city_id").val("").trigger("change");
                }
                // setTimeout(() => {
                //     console.log($('#city_id'));
                //     // $('select[name^="city_id"] option[value="127"]').attr("selected","selected");
                //     // $("#city_id").val("127").trigger("change");
                // }, 5000);


                // $('#state_id').value = data.data.state_id;
                // $('#city_id').value = data.data.city_id;
                // $('select[name^="state_id"] option[value="19"]').attr("selected","selected");
                // $('select[name^="city_id"] option[value="35"]').attr("selected","selected");
                // console.log($('#state_id'),$('#city_id'));
            }
        });
    } else {
        $("#state_id").val("").trigger("change");
        $("#city_id").val("").trigger("change");
    }
}
</script>

<script>
function cancel_button() {
    $("#Contact_Person").val("").trigger("change");
    $("#Mobile_No").val("").trigger("change");
    $("#pincode").val("").trigger("change");
    $("#Address1").val("").trigger("change");
    $("#Address2").val("").trigger("change");
    $("#Address3").val("").trigger("change");
    $("#state_id").val("").trigger("change");
    $("#city_id").val("").trigger("change");
}
</script>