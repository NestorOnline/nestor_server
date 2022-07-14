<div class="col-md-3">
                <div class="sidebar">
                    <div class="profile-avtar">
                        <img src="{{asset('img/icons/doctor.png')}}" alt="">
                    </div>
                    <div class="profile-detail">
                        <h4>{{\Auth::user()->mobile}}</h4>
                    </div>
                    <div class=profile-listing>
                        <ul class="list-unstyled">
                            <li class="active">
                                <a href="{{route('dashboard.delivery_address',\Auth::user()->id)}}">
                                    <em class="fa fa-user-circle"></em> Delivery Address
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <em class="fa fa-gift"></em> Offers
                                </a>
                            </li>
                            <li>
                                <a href="{{route('dashboard.order_history',\Auth::user()->id)}}">
                                    <em class="fa fa-shopping-bag"></em> My Order History
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <em class="fa fa-filter"></em> My Prescription
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <em class="fa fa-play"></em> My Subscription 
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <em class="fa fa-wallet"></em> My Wallet  
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <em class="fa fa-coins"></em> Refer &amp; Earn  
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <em class="fa fa-question"></em> Help
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <em class="fa fa-info"></em> Legal Information
                                </a>
                            </li>
                            <li>
                                <a href="{{route('dashboard.contact_us')}}">
                                    <em class="fa fa-phone"></em> Contact Us
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <em class="fa fa-star"></em> Rate Us
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>