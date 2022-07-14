<div class="col-md-6">
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="cart-product mt-3">
                    <h4>Consult With a Doctor</h4>

                    {!!Form::open(['route'=>['dashboard.contact_us'],'files'=>true,'class'=>'form-horizontal'])!!}
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">

                            <div class="rightside-details col-md-12 pr-0">
                                <input type="hidden" name="doctor_specialization_id"
                                    value="{{$doctor_specialization_id}}" class="form-control">
                            </div>


                            <div class="rightside-details col-md-12 pr-0">
                                <label for=""><small><strong>Tell us Your Symptom or Health
                                            Problem*</strong></small></label>
                                <div class="input-group mb-3">
                                    <div>
                                        <span class="basic-addon1"></span>
                                        <textarea row="3" type="text" name="Symptom_Problem_Area" class="form-control"
                                            placeholder="Eg: Fevern Headeche" aria-label="Username"
                                            aria-describedby="basic-addon1" maxlength="500"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="rightside-details col-md-12 pr-0">
                                <p>A relevant speciality will be shown below</p>
                                <label for=""><small><strong>Mobile Number</strong></small></label>
                                <input type="number" name="mobile" class="form-control">
                            </div>

                            <div class="rightside-details col-md-12 pr-0">
                                <br>
                                <button type="submit" class="hide_form btn btn-primary">Continue</button>
                            </div>
                        </div>
                    </div>
                    {!!Form::close()!!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="cart-product mt-3">
                    <center>
                        <img src="{{asset('doctor_icon.png')}}" width="365">
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>