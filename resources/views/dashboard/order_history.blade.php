@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <ul class="items">
                        <li class="home"> <a href="{{route('home')}}" title="Go to Home"> Home </a> </li>
                        <li class="home"> <a href="{{route('dashboard.my_profile')}}" title="Go to Home"> Dashboard </a>
                        </li>
                        <li class="home">Order History</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            @include('frontend.include.dashboard_sidebar')
            <div class="col-md-9">
                @foreach($orders as $order)
                <div class="cart-product mt-4">
                    <h4>Order History</h4>
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                            <div class="leftside-icons col-md-1 pr-0">
                                <a class="" title="Natural Power 500 mg Capsule 60's">
                                    <em class="fa fa-clock-o" style="color: red; font-size: 1.7em"></em>
                                </a>
                            </div>
                            <div class="rightside-details col p-0">
                                <div class="row m-0">
                                    <div class="product-item-name col pl-0">
                                        <p>Place Order at {{$order->created_at->format('d')}}
                                            {{$order->created_at->format('M')}}
                                            {{$order->created_at->format('Y')}}</p>
                                    </div>
                                    <div class="item-prices col-2 p-0 text-right">
                                        <a href="{{route('backend.chats.index')}}">
                                            <div class="discount-val"><span id="row_itmdiscprice_922086">Report An
                                                    issue</span></div>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">

                            <div class="rightside-details col p-0">
                                <div class="row m-0">
                                    <div class="product-item-name col pl-0">
                                        <?php
$orser_status = \App\OrderStatus::where('OrderStatus_Code', '=', $order->OrderStatus_Code)->first();
?>
                                        @if($orser_status)
                                        @if($orser_status->id=='7')
                                        <p style="color: #db1c0b"><strong>{{$orser_status->OrderStatus_Name}}</strong>
                                        </p>
                                        @else
                                        <p style="color: #009933"><strong>{{$orser_status->OrderStatus_Name}}</strong>
                                        </p>
                                        @endif
                                        @endif
                                        <strong>Order ID: </strong>NSRID-{{$order->id}}
                                    </div>
                                    <div class="product-item-name col pl-0">
                                        <p>
                                            <strong>{{$order->Party_Name}}</strong>
                                            <br>
                                            @if($order->Address1){{$order->Address1}},@endif
                                            @if($order->Address2){{$order->Address2}},@endif
                                            @if($order->Address3){{$order->Address3}},@endif
                                            <?php
$city = \App\City::find($order->City_Code);
?>

                                            @if($city)
                                            {{$city->name}},
                                            @endif
                                            <?php
$state = \App\State::find($order->State_Code);
?>
                                            @if($state)
                                            {{$state->name}}
                                            @endif- {{$order->PIN}}
                                        </p>
                                    </div>
                                    <div class="product-item-name col pl-0">
                                        <p>View {{count($order->orderproducts)}} items Ordered</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">

                            <div class="rightside-details col p-0">
                                <div class="row m-0">
                                    <div class="product-item-name col pl-0">
                                        <div class="p-3">

                                            <div class="col-md-4 offset-md-4">
                                                <div>
                                                    <a href="{{route('frontend.print_view',$order->id)}}"
                                                        class="add-to-cart">View Order Detail</a>
                                                    @if($order->Tracking_ID)
                                                    <a href="{{route('frontend.order_tracking',$order->id)}}"
                                                        style="margin-top: 5px" class="add-to-cart">View Tracking
                                                        Detail</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach

            </div>
        </div>
    </div>

    @include('frontend.include.footer')