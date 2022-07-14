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
                        <li class="home">Contact us</li>
                    </ul>
                </div>
            </div>
        </div>
        @include('flash')
        <div class="row">
            @include('frontend.include.dashboard_sidebar')

            <div class="col-md-9">
                <div class="cart-product mt-3">
                    <h4 style="color: #003579">You Are Free To Contact Us At Our Toll Free No. -01244522400 </h4>
                    <h4>Or</h4>
                    <h4>How would you like us to contact you?*</h4>
                    {!!Form::open(['route'=>['dashboard.contact_us'],'files'=>true,'class'=>'form-horizontal'])!!}
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                            <div class="rightside-details col-md-12 pr-0">
                                <label for=""><small><strong>Mobile</strong></small></label>
                                <input type="number" name="mobile" class="form-control">
                            </div>

                            <div class="rightside-details col-md-12 pr-0">
                                <label for=""><small><strong>E-mail ID</strong></small></label>
                                <input type="email" name="email" class="form-control">
                            </div>

                            <div class="rightside-details col-md-12 pr-0">
                                <label for=""><small><strong>Purpose of Contact*</strong></small></label>
                                <div class="input-group mb-5">
                                    <div>
                                        <span class="basic-addon1"></span>
                                        <select name="purpose_of_contact" id="ddrpreason"
                                            tooltiptext="Select the reason" tabindex="13" class="form-control">
                                            <option disabled="" selected="" value="">Select the reason</option>
                                            <option value="Business Opportunities">Business Opportunities</option>
                                            <option value="Compliments/Testimonials">Compliments/Testimonials</option>
                                            <option value="General Enquiries">General Enquiries</option>
                                            <option value="Incomplete Order">Incomplete Order</option>
                                            <option value="Marketing Opportunities">Marketing Opportunities</option>
                                            <option value="New Drug/ Product enquiry / New strength">New Drug/ Product
                                                enquiry / New strength</option>
                                            <option value="Order Not Received">Order Not Received</option>
                                            <option value="Payment Issues">Payment Issues</option>
                                            <option value="Reward Program">Reward Program</option>
                                            <option value="Upload Prescription Issues">Upload Prescription Issues
                                            </option>
                                            <option value="Website Issues">Website Issues</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="rightside-details col-md-12 pr-0">
                                <label for=""><small><strong>Please state your message here*</strong></small></label>
                                <div class="input-group mb-3">
                                    <div>
                                        <span class="basic-addon1"></span>
                                        <textarea row="3" type="text" name="message" class="form-control"
                                            placeholder="Max 500 word" aria-label="Username"
                                            aria-describedby="basic-addon1" maxlength="500"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div><button type="submit" class="add-to-cart">Submit</button></div>
                            </div>
                        </div>
                    </div>
                    {!!Form::close()!!}

                </div>

            </div>

        </div>
    </div>
</div>

@include('frontend.include.footer')