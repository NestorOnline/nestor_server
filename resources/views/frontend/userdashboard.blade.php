@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <ul class="items">
                        <li class="home"> <a href="" title="Go to Home"> Home </a> </li>
                        <li class="home">Prescription</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="sidebar">
                    <div class="profile-listing contact-box">
                        <ul class="list-unstyled">
                            <li>
                                <a href="">
                                    <em class="fa fa-user-circle"></em> Account Information
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <em class="fa fa-gift"></em> Offers
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <em class="fa fa-shopping-bag"></em> Nestor first
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <em class="fa fa-filter"></em> My Prescription
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <em class="fa fa-play"></em> My Subscription 
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <em class="fa fa-wallet"></em> My Wallet  
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <em class="fa fa-coins"></em> Refer &amp; Earn  
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <em class="fa fa-question"></em> Help
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <em class="fa fa-info"></em> Legal Information
                                </a>
                            </li>
                            <li class="active">
                                <a href="">
                                    <em class="fa fa-phone"></em> Contact Us
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <em class="fa fa-star"></em> Rate Us
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <em class="fa fa-sign-out-alt"></em> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                @if(\Auth::user()->role=='Chemist')
                @if(\Auth::user()->status =='verify')
                <h3 style="color: green;bakground: yellow">Chemist is Verified</h3>
                @else
                <h3 style="color: red;bakground: yellow">Chemist is not Verify Please Contact Your Administrator</h3>
                @endif
                @endif
                <div class="cart-product mt-3">
                    <h4>How would you like us to contact you?*</h4>
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                            <div class="rightside-details col-md-2 pr-0 mb-3">
                                <label for="con-che">
                                    <input type="radio" name="contact-radio" checked id="con-che"> Mobile
                                </label>
                            </div>
                            <div class="rightside-details col-md-2 pr-0 mb-3">
                                <label for="con-chek">
                                    <input type="radio" name="contact-radio" checked id="con-chek"> E-mail ID
                                </label>
                            </div>
                            <div class="rightside-details col-md-12 pr-0">
                                <label for=""><small><strong>Purpose of Contact*</strong></small></label>
                                <div class="input-group mb-5">
                                    <div>
                                        <span class="basic-addon1"></span>
                                        <select name="ddrpreason" id="ddrpreason" tooltiptext="Select the reason" tabindex="13" class="form-control "> 
                                            <option disabled="" selected="" value="">Select the reason</option> 
                                            <option value="Business Opportunities">Business Opportunities</option> 
                                            <option value="Compliments/Testimonials">Compliments/Testimonials</option> 
                                            <option value="General Enquiries">General Enquiries</option> 
                                            <option value="Incomplete Order">Incomplete Order</option> 
                                            <option value="Marketing Opportunities">Marketing Opportunities</option> 
                                            <option value="New Drug/ Product enquiry / New strength">New Drug/ Product enquiry / New strength</option> 
                                            <option value="Order Not Received">Order Not Received</option> 
                                            <option value="Payment Issues">Payment Issues</option> 
                                            <option value="Reward Program">Reward Program</option> 
                                            <option value="Upload Prescription Issues">Upload Prescription Issues</option> 
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
                                        <textarea row="3" type="text" class="form-control" placeholder="Max 500 word" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class=" style__filter-label___3Jy6h mb-3">
                                    <input type="checkbox"><span class="style__filter-checkbox___vU8YA"></span>
                                    <span class="style__filter-name___A2BgE">
                                        <span>
                                        Email me a copy of this message for my records. 
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <div class="col-md-3">
                                <div><a href="" class="add-to-cart">Submit</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontend.include.footer')