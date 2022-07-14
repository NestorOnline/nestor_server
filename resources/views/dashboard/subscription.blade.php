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
                        <li class="home">Subscription</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            @include('frontend.include.dashboard_sidebar')
            <div class="col-md-9">
                <div class="cart-product mt-3"> 
                    <h4 style="color: #003579">Get monthly refills delivered!</h4>
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                            <div class="rightside-details col pr-0">
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579"></h4>
                                        <p class="form m-0">Subscribe for 12 months and get the next  <br> month free for Orders placed above Rs. 1000.  <br> *T&C Apply
                                            
                                        </p>
                                    </div>
                                </div>
                                <br>
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579"></h4>
                                        <p class="form m-0"></p>
                                    </div>
                                </div>
                                <br>
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579"></h4>
                                        <p class="form m-0"> 
                                            </p>
                                    </div>
                                </div>
                                <br>
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579"></h4>
                                        <p class="form m-0">
                                             
                                        </p>
                                    </div>
                                </div>
                                <br>
                                 <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579"></h4>
                                        <p class="form m-0">
                                             
                                        </p>
                                    </div>
                                </div>
                                <br>
                                 <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579"></h4>
                                        <p class="form m-0">
                                            
                                        </p>
                                    </div>
                                </div>
                                <br>
                                 <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579"></h4>
                                        <p class="form m-0">
                                            
                                        </p>
                                    </div>
                                </div>
                                <br>
                                 <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579"></h4>
                                        <p class="form m-0">
                                             
                                        </p>
                                    </div>
                                </div>
                                <br>
                                 <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579"></h4>
                                        <p class="form m-0">
                                             
                                        </p>
                                    </div>
                                </div>
                                <br>
                                 <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579"></h4>
                                        <p class="form m-0">
                                             
                                        </p>
                                    </div>
                                </div>
                                <br>
                                 <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579"></h4>
                                        <p class="form m-0">
                                             
                                        </p>
                                    </div>
                                </div>
                                <br>
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <a href="{{route('dashboard.contact_us')}}" class="btn btn-primary">
                                            CREATE NEW REFILL
                                        </a>
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



