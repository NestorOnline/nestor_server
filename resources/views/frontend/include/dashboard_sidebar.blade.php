<div class="col-md-3">
    <div class="sidebar">
        <div class="profile-avtar">
            @if(\Auth::user()->profile_image)
            <img src="{{asset(\Auth::user()->profile_image)}}" alt="">
            @else
            <img src="{{asset('img/icons/doctor.png')}}" alt="">
            @endif
            <br>
            <br>
            <a href="{{route('dashboard.upload_image')}}">Change</a>

        </div>
        <div class="profile-detail">

            @if(\Auth::user()->role=='Chemist')
            <?php
$chemist = \App\Chemist::where('user_id', '=', \Auth::user()->user_id)->first();
?>
            @if($chemist)
            <h4>{{$chemist->chemist_name}}</h4>
            @endif
            @endif

            <h4 style="margin-top: 50px">{{\Auth::user()->mobile}}</h4>
        </div>
        <div class=profile-listing>
            <ul class="list-unstyled">
                @if($site_route=='dashboard.delivery_address')
                <li class="active">
                    @else
                <li>
                    @endif
                    <a href="{{route('dashboard.delivery_address',\Auth::user()->id)}}">
                        <em class="fa fa-user-circle"></em> Delivery Address
                    </a>
                </li>

                @if($site_route=='dashboard.sales_schemes')
                <li class="active">
                    @else
                <li>
                    @endif
                    <!-- <a href="{{route('dashboard.sales_schemes',\Auth::user()->id)}}">
                                    <em class="fa fa-gift"></em> Offer
                                </a> -->
                </li>
                @if($site_route=='dashboard.order_history')
                <li class="active">
                    @else
                <li>
                    @endif
                    <a href="{{route('dashboard.order_history',\Auth::user()->id)}}">
                        <em class="fa fa-shopping-bag"></em> My Order History
                    </a>
                </li>
                @if(!\Auth::user()->role=='Chemist')
                @if($site_route=='dashboard.my_prescription')
                <li class="active">
                    @else
                <li>
                    @endif
                    <a href="{{route('dashboard.my_prescription')}}">
                        <em class="fa fa-filter"></em> My Prescription
                    </a>
                </li>
                @endif
                <!-- @if($site_route=='dashboard.subscription')
                        <li class="active">
                        @else
                        <li>
                        @endif
                                <a href="{{route('dashboard.subscription')}}">
                                    <em class="fa fa-play"></em> Subscription
                                </a>
                            </li> -->
                <!-- @if($site_route=='dashboard.my_wallet')
                        <li class="active">
                        @else
                        <li>
                        @endif
                                <a href="{{route('dashboard.my_wallet')}}">
                                    <em class="fa fa-wallet"></em> My Wallet
                                </a>
                            </li> -->
                <!-- @if($site_route=='dashboard.refer_earn')
                        <li class="active">
                        @else
                        <li>
                        @endif
                                <a href="{{route('dashboard.refer_earn')}}">
                                    <em class="fa fa-coins"></em> Refer &amp; Earn
                                </a>
                            </li> -->
                <!-- <li>
                                <a href="#">
                                    <em class="fa fa-question"></em> Help
                                </a>
                            </li>
                            @if($site_route=='dashboard.legal_information')
                        <li class="active">
                        @else
                        <li>
                        @endif
                                <a href="{{route('dashboard.legal_information')}}">
                                    <em class="fa fa-info"></em> Legal Information
                                </a>
                            </li> -->
                @if($site_route=='dashboard.contact_us')
                <li class="active">
                    @else
                <li>
                    @endif
                    <a href="{{route('dashboard.contact_us')}}">
                        <em class="fa fa-phone"></em> Contact Us
                    </a>
                </li>
                <li>
                    <a href="{{route('dashboard.account_summery')}}">
                        <em class="fa fa-list"></em> Account Summary
                    </a>
                </li>
                @if(\Auth::user()->role=='User')
                <li>
                    <a href="{{route('dashboard.doctor_appointment_list')}}">
                        <em class="fa fa-list"></em> Doctor Appointment List
                    </a>
                </li>
                
                @endif
                <!-- @if($site_route=='dashboard.diagnostics_faq')
                        <li class="active">
                        @else
                        <li>
                        @endif
                                <a href="{{route('dashboard.diagnostics_faq')}}">
                                    <em class="fa fa-star"></em> Diagnostics FAQ
                                </a>
                            </li> -->
            </ul>
        </div>
    </div>
</div>