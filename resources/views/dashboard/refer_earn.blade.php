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
                        <li class="home">Refer & Earn</li>
                    </ul>
                </div>
            </div>
        </div>
        @include('flash')
        <div class="row">
            @include('frontend.include.dashboard_sidebar')

            <div class="col-md-9">
                <div class="cart-product mt-3">
                    <h4>Invite your friends and family get Instant Rewards</h4> 
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                            <div class="row m-0">
                                <div class="catag-name col pl-0">
                                    <h4 style="color: #003579">Invite your friends and family</h4>
                                    <p>share the Nestor app download link & Referral code with your friends and family</p>
                                    <h4 style="color: #003579">You get</h4>
                                    <p>Rs. 150 NP SuperCash - after your Friend’s first order is delivered!</p>
                                    <h4 style="color: #003579">Your Friends Get</h4>
                                    <p>Flat 20% off + 20% NP SuperCash on their first order (minimum order value Rs.500)</p>
                                    <a href="" class="add-to-cart">
                                        Your Referral Code: NP201<br>
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
