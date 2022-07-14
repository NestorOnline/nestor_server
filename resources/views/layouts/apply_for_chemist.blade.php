@include('frontend.include.head')
@include('frontend.include.header')
<div class="container p-4">
    <div class="row">
        <div class="col-md-12">
            <div class="delivery-box-div">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <h3>Chemist Detail Form</h3>
                        </div>
                    </div>
                    @include('flash')
                    {!!Form::open(['files'=>true,'class'=>'form-horizontal'])!!} 
                    <div class="col-md-6">
                        <div>
                            <div class="mt-5">
                                <div>
                                    <label for=""><small><strong>Chemist Name</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="text" name="chemist_name" class="form-control" placeholder="Enter Chemist*" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    
                                    <label for=""><small><strong>Email </strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="email" name="email" class="form-control" placeholder="Enter email" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    
                                    <label for=""><small><strong>Mobile*</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="text" name="mobile" class="form-control" placeholder="Enter Mobile*" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    
                                    <label for=""><small><strong>Password *</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="text" name="password" class="form-control" placeholder="Password *" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                     
                                     <label for=""><small><strong>Confirm Password *</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="text" name="confirmation_password" class="form-control" placeholder="Enter Confirm Password *" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                                                     
                                    <label for=""><small><strong>GST</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="text" name="gst" class="form-control" placeholder="Enter gst" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    
                                    <label for=""><small><strong>DL No. *</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="text" name="drug_license_no" class="form-control" placeholder="Enter DL no." aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <div class="mt-5">
                                <div>
                                    <label for=""><small><strong>Contact Person</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="text" name="contact_person" class="form-control" placeholder="Contact person detail" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div> 
                                    
                                    <label for=""><small><strong>Designation </strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="text" name="designation" class="form-control" placeholder="Enter designation" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    
                                    <label for=""><small><strong>Address</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="text" name="address" class="form-control" placeholder="Enter Address" aria-label="Address" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    
                                    <label for=""><small><strong>City</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="text" name="city" class="form-control" placeholder="Enter city" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    
                                    <label for=""><small><strong>State</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="text" name="state" class="form-control" placeholder="Enter state" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                      <label for=""><small><strong>Pin Code</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="text" name="pincode" class="form-control" placeholder="Enter Pin Code" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                   
                                    <label for=""><small><strong>Upload Drug Licence File *</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class=""></span>
                                            <input type="file" class="" name="drug_licence"  aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div><button type="submit" class="add-to-cart">Continue</button></div>
                    </div>
                       {!!Form::close()!!} 
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontend.include.footer')
