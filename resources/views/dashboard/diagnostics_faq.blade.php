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
                        <li class="home">Diagnostics FAQ</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            @include('frontend.include.dashboard_sidebar')
            <div class="col-md-9">

                <div class="cart-product mt-3"> 
                    <h4>Diagnostics FAQ</h4>
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                            <div class="rightside-details col pr-0">
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <p class="form m-0">
                                            Can't find what you need ? Our Diagnostics support team is available to assist you. Kindly,
                                            let us know what issue you are facing by sending us an email on cs_diagnostics@netmeds.com or reach us at 1234567890.
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
