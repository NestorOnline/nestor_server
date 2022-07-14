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
                        <li class="home">Legal Information</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            @include('frontend.include.dashboard_sidebar')
            <div class="col-md-9">
                <div class="cart-product mt-3"> 
                    <h4 style="color: #003579">Legal Information</h4>
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                            <div class="rightside-details col pr-0">
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579">How does your referral program work?</h4>
                                        <p class="form m-0">
                                            You can invite your friends and family to become members of the Netmeds community through a referral code.
                                            Once they have placed and received their first order using your referral code, you will receive an e-gift voucher from us.
                                        </p>
                                    </div>
                                </div>
                                <br>
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579">Where should I check my referral code?</h4>
                                        <p class="form m-0"> Referring your friends is as simple as these 3 steps:</p>
                                        <p> <span style="color: #003579">Step 1:</span> Once you submit your friends' name and email ID, a Referral code for Flat 20% off Medicines on their 'First Purchase' will be emailed to them on your behalf.</p>
                                        <p><span style="color: #003579">Step 2:</span> When your friends place their first order using the referral code, they will receive Flat 20% OFF on order of Medicines worth Rs. 500 or more.</p>
                                        <p><span style="color: #003579">Step 3:</span> After your friend's first order is delivered, we will credit your NMS Wallet with Rs. 150 NMS SuperCash (Max. 25 Referrals only)</p>
                                      
                                    </div>
                                </div>
                                <br>
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579">Why did I not get the referral benefit?</h4>
                                        <p class="form m-0">If you were not notified about your referral benefit, it is likely that one or more of the following scenarios could have taken place:
                                            <br>
<span style="color: #003579">1.</span> The referred member did not apply your referral code while placing the order
<br>
<span style="color: #003579">2.</span> The user clicked on your link but did not create an account or complete their first purchase
<br>
<span style="color: #003579">3.</span> The referred member placed an eligible order, but the order was not fulfilled
<br>
<span style="color: #003579">4.</span> The person who used the code is a Netmeds customer
<br>
<span style="color: #003579">5.</span> Your referral benefit has expired 

                                        </p>
                                    </div>
                                </div>
                                <br>
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579">Is there an expiry date to my referral benefit?</h4>
                                        <p class="form m-0">
                                            Yes. The referral benefit is valid for 45 days from the date it was credited to your account.
                                        </p>
                                    </div>
                                </div>
                                <br>
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <a href="{{route('dashboard.contact_us')}}" class="btn btn-primary">
                                            Slill Need Help?
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

