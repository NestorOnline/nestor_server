@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <ul class="items">
                         <li class="home"> <a href="{{route('home')}}" title="Go to Home"> Home </a> </li>
                        <li class="home"> <a href="{{route('dashboard.my_profile')}}" title="Go to Home"> Dashboard </a> </li>
                        <li class="home">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
                @include('frontend.include.dashboard_sidebar')
            <div class="col-md-9">
                <div class="cart-product mt-3">
                    <h4>Profile Information</h4>
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                            <div class="rightside-details col-md-6 pr-0">
                                <label for=""><small><strong>Email</strong></small></label>
                                <div class="input-group mb-5">
                                    <div>
                                        <span class="basic-addon1"></span>
                                        <input type="text" class="form-control" placeholder="Enter password" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                            <div class="rightside-details col-md-6 pr-0">
                                <label for=""><small><strong>First name</strong></small></label>
                                <div class="input-group mb-5">
                                    <div>
                                        <span class="basic-addon1"></span>
                                        <input type="text" class="form-control" placeholder="Enter password" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                            <div class="rightside-details col-md-6 pr-0">
                                <label for=""><small><strong>Gender</strong></small></label>
                                <div class="input-group mb-5">
                                    <div>
                                        <span class="basic-addon1"></span>
                                        <input type="text" class="form-control" placeholder="Enter password" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                            <div class="rightside-details col-md-6 pr-0">
                                <label for=""><small><strong>Mobile No.</strong></small></label>
                                <div class="input-group mb-5">
                                    <div>
                                        <span class="basic-addon1"></span>
                                        <input type="text" class="form-control" placeholder="Enter password" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 offset-md-4">
                                <div><a href="" class="add-to-cart">Modify and Save</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart-product mt-3">
                    <h4>Delivery Address</h4>
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                            <div class="rightside-details col pr-0">
                                <div class="row m-0">
                                    <div class="product-item-name col pl-0">
                                        <a href="non-prescriptions/natural-power-capsule-60s">Anurag Sharma</a>
                                    </div>
                                </div>
                                <div class="row m-0 mt-2">
                                    <div class="catag-name col pl-0">
                                        <p class="form m-0">NH-24 In Front of Mandi Gate,</p>
                                    </div>
                                </div>
                                <div class="row m-0 mt-1">
                                    <div class="catag-name col pl-0">
                                        <p class="form m-0">Behind Vishnu Temple, House No. 188,</p>
                                    </div>
                                </div>
                                <div class="row m-0 mt-1">
                                    <div class="catag-name col pl-0">
                                        <p class="form m-0">Samrthpur Auraiya (206122), Uttar Pradesh</p>
                                    </div>
                                </div>
                                <div class="deliveryby row m-0 mt-2">
                                    <div class="date deldate col pl-0">
                                        <div class="deliveryby">+91 7078639846</div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('frontend.include.footer')
