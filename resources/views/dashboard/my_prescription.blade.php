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
                        <li class="home">My Prescription</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            @include('frontend.include.dashboard_sidebar')
            <div class="col-md-9">
                <div class="cart-product mt-3"> 
                    <h4 style="color: #003579">My Prescription</h4>
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                            <div class="rightside-details col pr-0">
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579">Do generic/alternative medication require Rx too?</h4>
                                        <p class="form m-0">
                                            Yes, a prescription in required for generic/alternate medication.
                                            If you do not have one, we will can help you consult a doctor and get you a prescription.
                                        </p>
                                    </div>
                                </div>
                                <br>
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579">If I don't have a prescription then what is the procedure?</h4>
                                        <p class="form m-0"> You can place the order online. We will arrange for a doctor to consult with you and prescribe the required medication.</p>
                                    </div>
                                </div>
                                <br>
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579">What is the waiting time to receive an online prescription?</h4>
                                        <p class="form m-0">An online prescription can be arranged within 2 to 4 hours of raising a request for the same.
                                            </p>
                                    </div>
                                </div>
                                <br>
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <h4 style="color: #003579">Where do I send my prescription for an order which I've placed today?</h4>
                                        <p class="form m-0">
                                            You can send your prescription to this WhatsApp number: 1234567890
                                        </p>
                                    </div>
                                </div>
                                <br>
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <a href="{{route('dashboard.contact_us')}}" class="btn btn-primary">
                                            Still Need Help?
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


