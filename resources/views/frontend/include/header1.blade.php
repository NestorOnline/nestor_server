<div class="main-head responsive-head custom-nav">
    <div class="top-head">
        <div class="menu-head">
            <div class="logo-head mob-show-bar">
                <a href="javascript:void(0)" class="">
                    <img src="{{asset('img/icons/bars.png')}}" alt="">
                </a>
            </div>
            <div class="logo-head">
                <a href="{{route('home')}}">
                    <img src="{{asset('img/nestor_logo.png')}}" alt="">
                </a>
            </div>

            <div class="search-bar">
                <div class="block-search">

                    <div class="pinCode" id="location_box">
                        <a href="{{route('get_location_zip')}}"><span class="fa fa-map-marker"></span></a>
                        @guest
                        <?php
$pincode_value = request()->cookie('zip_code');
$pin_code = json_decode($pincode_value);
?>
                        @if($pin_code)
                        <span> Delivering to <br>
                            <input type="number" value="{{$pin_code}}" placeholder="Pin Code"
                                onKeyPress="if(this.value.length==6) return false;" id="pinInput" maxlength="10">
                            <img src="img/icons/edit.png" class="pin-edit" alt="">
                        </span>
                        @else
                        <span> Delivering to <br>
                            <input type="number" value="110001" placeholder="Pin Code"
                                onKeyPress="if(this.value.length==6) return false;" id="pinInput" maxlength="10">
                            <img src="img/icons/edit.png" class="pin-edit" alt="">
                        </span>
                        @endif
                        @else
                        <?php
$pincode = \App\Address::where('user_id', '=', \Auth::user()->id)
    ->where('set_as_a_default', '=', 'Yes')
    ->where('set_as_a_current', '=', 'Yes')
    ->first();
?>
                        @if($pincode)
                        <span> Delivering to <br>
                            <input type="number" value="{{$pincode->PIN}}" placeholder="Pin Code"
                                onKeyPress="if(this.value.length==6) return false;" id="pinInput" maxlength="10">
                            <img src="img/icons/edit.png" class="pin-edit" alt="">
                        </span>
                        @else
                        <span> Delivering to <br>
                            <input type="number" value="110001" placeholder="Pin Code"
                                onKeyPress="if(this.value.length==6) return false;" id="pinInput" maxlength="10">
                            <img src="img/icons/edit.png" class="pin-edit" alt="">
                        </span>
                        @endif
                        @endguest

                    </div>
                    <div class="auto-search">
                        <form id="search_form" action="{{route('search.all')}}" method="GET">
                            <div class="search-section">
                                <div class="algolia-autocomplete"
                                    style="position: relative; display: block; direction: ltr;">
                                    <input tabindex="0" id="search_names" type="text" name="search_names"
                                        onkeyup="search_function()" class="input-text algolia-search-input aa-input"
                                        autocomplete="off" spellcheck="false" autocorrect="off" autocapitalize="off"
                                        placeholder="Search for medicine &amp; wellness product" role="combobox"
                                        aria-autocomplete="list" aria-expanded="false"
                                        aria-owns="algolia-autocomplete-listbox-0" dir="auto"
                                        style="position: relative; vertical-align: top;">
                                </div>
                                <div class="search-listing" id="add_search_product">
                                    <ul class="list-unstyled">
                                    </ul>
                                </div>
                            </div>
                            <button class="iconSearch" type="submit"></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mob-flex-icons">
                <div class="search_icon">
                    <a href="javascript:void(0)" title="Search for product">
                        <div class="text">
                        </div>
                    </a>
                </div>
                @guest
                <div class="location_icon">
                    <a href="{{route('frontend.upload_prescription')}}" title="Upload Your  Precription">
                        <div class="text" style="color: white">
                            Upload
                        </div>
                    </a>
                </div>
                @else
                @if(\Auth::user()->role=='User')
                <div class="location_icon">
                    <a href="{{route('frontend.upload_prescription')}}" title="Upload Your  Precription">
                        <div class="text" style="color: white">
                            Upload
                        </div>
                    </a>
                </div>
                @else
                <div class="location_icon">
                </div>
                @endif
                @endguest
                <div class="uPres">
                    <a href="{{route('backend.notification')}}" title="notification">

                        <div class="text">
                            <!-- For  Show No. OF Notification
                        <span class="counter-number">0</span>
                            -->
                        </div>

                    </a>
                </div>
                @guest
                <?php
$value = request()->cookie('add_cart');
$add_cart_datas = json_decode($value);
if ($add_cart_datas == null) {
    $add_cart_datas = [];
}
$add_total = 0;

?>
                @else
                <?php
$add_total = 0;
$add_cart_datas = \App\Addtocard::where('user_id', '=', \Auth::user()->id)->get();
?>
                @endguest
                <div class="mini-cart" id="add_card_view">
                    <a href="{{route('frontend.cart')}}">
                        <div class="text">
                            <span class="counter-number">{{count($add_cart_datas)}}</span>
                        </div>
                    </a>
                    @if(count($add_cart_datas))
                    <div class="cart-dropdown">
                        <div>
                            <div class="cart-list-drop mt-3">
                                <div class="drop-des">
                                    <p class="drop-p-name">Order Summary</p>
                                    <p class="drop-pri"><b>{{count($add_cart_datas)}} Items</b></p>
                                </div>
                            </div>
                            @foreach($add_cart_datas as $key=>$add_cart_data)
                            <?php
$card_pro = \App\Product::find($add_cart_data->product_id);
$add_total = $add_total + $add_cart_data->amount * $add_cart_data->Qty;
?>
                            <div class="cart-list-drop">
                                <div class="drop-des">
                                    <p class="drop-p-name"><a href="#"> {{$card_pro->brand_name}}</a></p>
                                    <p class="drop-pri">Rs.<b
                                            id="amount_update{{$add_cart_data->product_id}}">{{number_format($add_cart_data->amount, 2, '.', '')}}</b>
                                        <span> X <b
                                                id="Qty_update{{$add_cart_data->product_id}}">{{$add_cart_data->Qty}}</b></span>
                                    </p>
                                </div>
                            </div>
                            @endforeach
                            <div class="pl-3 pr-3">
                                <div class="totalamt">
                                    <span class="">TOTAL AMOUNT</span><span class="save-price"><b
                                            id="total_amount_update">{{number_format($add_total, 2, '.', '')}}</b></span>
                                </div>
                            </div>
                            <!-- <div> -->
                            <p class="drop-p-name mb-3 mx-3">
                                <a href="{{route('frontend.cart')}}" class="add-to-cart">View Cart</a>
                            </p>
                            <!-- </div> -->
                        </div>
                    </div>
                    @endif
                </div>

                @guest
                <div class="login">
                    <div class="logged">
                        <a href="{{url('/loginpage')}}">Sign in</a>
                    </div>
                </div>
                <div>
                    <div class="mob-hide-logo">
                        <span style="color: white"> &nbsp;/</span>
                        <a href="{{url('/registerpage')}}" style="color: white">Sign up</a>
                    </div>
                </div>
                @else
                <div class="after_login">
                    <div class="logged" style="">
                        @if(\Auth::user()->profile_image)
                        <img src="{{asset(\Auth::user()->profile_image)}}" alt="">
                        @else
                        <img src="{{asset('img/icons/doctor.png')}}" alt="">
                        @endif
                        <a href="{{route('dashboard.my_profile')}}">{{\Auth::user()->mobile}}</a>
                    </div>
                    <ul class="list-unstyled dropdown-menu">
                        @if(\Auth::user()->role=='Chemist')
                        <li><a href="{{route('dashboard.my_profile')}}">My Profile</a></li>
                        @else
                        <li><a href="{{route('dashboard.customer_profile')}}">My Profile</a></li>
                        @endif
                        <!-- <li><a href="{{route('dashboard.my_wallet')}}">My Wallet</a></li> -->
                        <li><a href="{{route('dashboard.order_history',\Auth::user()->id)}}">Order History</a></li>
                        <li><a href="{{route('auth.logout')}}">Logout</a></li>
                    </ul>
                </div>
                @endguest
            </div>
        </div>

    </div>
    <div class="nav-sections">
        <div class="container">
            <nav class="navigation">
                <ul class="ui-menu">
                    <li class="close-sidebar">
                        <a href="javascript:void(0)" class="hide-sidebar"><em class="fa fa-times"></em></a>
                    </li>
                    @foreach($groups as $group)
                    <li>
                        <a class="level-top" href="{{route('frontend.group_page',$group->url_name)}}"><img
                                src="{{asset($group->image)}}" alt="">{{$group->name}}</a>
                        <div class="dropdown-menu">
                            <ul class="list-unstyled  mega-menu">
                                @foreach($group->groupcategories as $groupcategory)
                                <li><a
                                        href="{{route('frontend.groupcategory_page',[$group->url_name,$groupcategory->url_name])}}">{{$groupcategory->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
</div>