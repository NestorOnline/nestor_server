<div class="main-head responsive-head custom-nav">
    <div class="top-head">
        <div class="menu-head">
            <div class="logo-head">
                <a href="{{route('home')}}" class="mob-hide-logo">
                    <img src="{{asset('img/nestor-logo.jpeg')}}" alt="">
                </a>
            </div>
            <div class="search-bar">
                <div class="block-search">
                    <div class="pinCode" id="location_box"> 
                        <span> Delivering to <br> 
                            <select name="" id="">
                                <option value="">All Product</option>
                                <option value="">General Store</option>
                                <option value="">Pharmacy</option>
                            </select>
                        </span> 
                    </div>
                    <div class="auto-search">
                        <form id="search_form" action="" method="GET">
                            <div class="search-section">
                                <div class="algolia-autocomplete" style="position: relative; display: block; direction: ltr;">
                                    <input tabindex="0" id="search_names" type="text" name="q" onkeyup="search_function()" class="input-text algolia-search-input aa-input" autocomplete="off" spellcheck="false" autocorrect="off" autocapitalize="off" placeholder="Search for medicine &amp; wellness product" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-owns="algolia-autocomplete-listbox-0" dir="auto" style="position: relative; vertical-align: top;">
                                </div>
                                <div class="search-listing">
                                    <ul class="list-unstyled" id="add_search_product">
                                    </ul>
                                </div>
                            </div>
                            <button class="iconSearch" type="submit"></button> 
                        </form>
                    </div>
                </div>
            </div>
            <div class="location_icon"> 
                <a href="" title="choose your location">  
                    <div class="text"> 
                    </div> 
                </a> 
            </div>
            <div class="uPres"> 
                <a href="" title="notification"> 
                   
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
        if($add_cart_datas == null){
    $add_cart_datas = [];
        }
        $add_total = 0;
     
        ?>
             @else
              <?php
                $add_total = 0;
               $add_cart_datas = \App\Addtocard::where('user_id','=',\Auth::user()->id)->get();
                ?>
             @endguest
            <div class="mini-cart" id="add_card_view"> 
                <a href="{{route('frontend.cart')}}"> 
                    <div class="text"> 
                        <span class="counter-number" id="counter-number">{{count($add_cart_datas)}}</span> 
                    </div> 
                </a> 
               @if(count($add_cart_datas))
                <div class="cart-dropdown">
                    <div>
                        @foreach($add_cart_datas as $key=>$add_cart_data)
                        <?php
                        $card_pro = \App\Product::find($add_cart_data->product_id);
                        $add_total = $add_total + $add_cart_data->amount*$add_cart_data->Qty;
                        ?>
                        <div class="cart-list-drop">
                            <div class="drop-img">
                                 <?php
                                    $product_image = \App\Productimage::where('Product_Code','=',$card_pro->product_code)->first();
                                    ?>
                                    @if($product_image)
                                    <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}"  class="w-100" alt="Nestor Immunity Care">
                                    @endif
                            </div>
                            <div class="drop-des">
                                <p class="drop-p-name"><a href="#">{{$card_pro->brand_name}} {{$card_pro->generic_name}}</a></p>
                                <p class="drop-p-des">product description</p>
                                <p class="drop-pri"><em class="fa fa-inr"></em> <b id="amount_update{{$add_cart_data->product_id}}">{{number_format($add_cart_data->amount, 2, '.', '')}}</b> <span>Qty: <b id="Qty_update{{$add_cart_data->product_id}}">{{$add_cart_data->Qty}}</b></span></p>
                            </div>
                        </div>
                        @endforeach
                        <div class="pl-3 pr-3">
                            <div class="totalamt">
                            <span class="float-left">TOTAL AMOUNT</span><span class="save-price">Rs.<b id="total_amount_update">{{number_format($add_total, 2, '.', '')}}</b></span>
                            </div>
                        </div>
                        <!-- <div> -->
                        <p class="drop-p-name mt-0 m-3">
                            <a href="http://nestor_update.testing/frontend/cart" class="add-to-cart">View Cart</a>
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
                <div> 
                    <span style="color: white"> &nbsp;/</span>
                    <a href="{{url('/registerpage')}}" style="color: white">Sign up</a> 
                </div> 
            </div>
            @else
            <div class="after_login"> 
                    <div class="logged" style=""> 
                        <img src="{{asset('img/pro-file.jpeg')}}" alt=""><a href="{{route('dashboard.order_history',\Auth::user()->id)}}">{{\Auth::user()->mobile}}</a> 
                    </div> 
                    <ul class="list-unstyled dropdown-menu">                        
                        <li><a href="{{route('dashboard.order_history',\Auth::user()->id)}}">Dashboard</a></li>
                        <li><a href="#">My Profile</a></li>
                        <li><a href="#">My Wallet</a></li>
                        <li><a href="{{route('dashboard.order_history',\Auth::user()->id)}}">Order History</a></li>
                        <li><a href="{{route('auth.logout')}}">Logout</a></li>
                    </ul>
                </div>          
            @endguest
        </div>
        <!-- <div class="main-navigation">
            <div class="explorer-menu">
                <ul>
                    <li class="m-pro">
                        <a href="/prescriptions" class="m-pro1"> Medicine<small>Over 25000 products</small> </a> 
                        <ul style="min-width: 200px;">
                            <li><a href="/prescriptions">All Medicines</a></li>
                            <li><a href="/customer/buyagain">Previously Ordered Products</a></li>
                        </ul>
                    </li>
                    <li><a href="/wellness" class="h-pro">Wellness<small>Health products</small></a></li>
                    <li><a href="/health-packages" class="b-check">Diagnostic<small>Book tests &amp; checkups</small></a></li>
                    <li class="b-app">
                        <a href="/health-library" class="b-app1"> Health Corner<small>Trending tips from health experts</small> </a> 
                        <ul style="z-index: 2;">
                            <li><a href="/health-library">Health Library</a></li>
                            <li><a href="/patientsalike" target="_blank" rel="noopener">PatientsAlike</a></li>
                            <li><a href="/corona-awareness">Corona Awareness</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div> -->
    </div>
<div class="nav-sections">
        <div class="container">
            <nav class="navigation">
                <ul class="ui-menu">
                    @foreach($groups as $group)
                    <li>
                        <a class="level-top" href="{{route('frontend.group_page',$group->id)}}"><img src="{{asset($group->image)}}" alt="">{{$group->name}}</a>
                        <div class="dropdown-menu">
                            <ul class="list-unstyled  mega-menu">
                                @foreach($group->groupcategories as $groupcategory)
                                <li><a href="{{route('frontend.groupcategory_page',$groupcategory->id)}}">{{$groupcategory->name}}</a></li>
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