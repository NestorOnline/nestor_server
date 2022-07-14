@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container">
        <div>
            <div class="row">
                <div class="col-md-12">
                    <div class="py-3">
                        <h3>My Orders</h3>
                    </div>
                </div>
                <div class="col-md-12">
                    <div>
                        <div>
                            <div>
                                <div class="cart-product">
                                    <h4>Delivery Address</h4>
                                    <div class="product-details">
                                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                                            <div class="rightside-details col pr-0">
                                                @if($order->Party_Name)
                                                <div class="row m-0">
                                                    <div class="product-item-name col pl-0">
                                                        <a
                                                            href="non-prescriptions/natural-power-capsule-60s">{{$order->Party_Name}}</a>
                                                    </div>
                                                </div>
                                                @endif
                                                @if($order->Address1)
                                                <div class="row m-0 mt-2">
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0">{{$order->Address1}},</p>
                                                    </div>
                                                </div>
                                                @endif
                                                @if($order->Address2)
                                                <div class="row m-0 mt-2">
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0">{{$order->Address2}},</p>
                                                    </div>
                                                </div>
                                                @endif
                                                @if($order->Address3)
                                                <div class="row m-0 mt-2">
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0">{{$order->Address3}},</p>
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="row m-0 mt-1">
                                                    <div class="catag-name col pl-0">
                                                        <p class="form m-0">
                                                            <?php
$city = \App\City::find($order->City_Code);
?>
                                                            @if($city)
                                                            {{$city->name}}
                                                            @endif
                                                            ( {{$order->PIN}} ),
                                                            <?php
$state = \App\State::find($order->State_Code);
?>
                                                            @if($state)
                                                            {{$state->name}}
                                                            @endif</p>
                                                    </div>
                                                </div>
                                                <div class="deliveryby row m-0 mt-2">
                                                    <div class="date deldate col pl-0">
                                                        <div class="deliveryby"> {{$order->Mobile_No}}</div>
                                                    </div>
                                                </div>
                                                @if($order->gst)
                                                <div class="deliveryby row m-0 mt-2">
                                                    <div class="date deldate col pl-0">
                                                        <div class="deliveryby"> GST: {{$order->GSTIN}}</div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-product mt-3">

                                    <!-- </div>
                                <div class="cart-product mt-3"> -->
                                    <h4>Order Tracking History</h4>
                                    <div class="product-details">
                                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                                            <style>
                                            #customers {
                                                font-family: Arial, Helvetica, sans-serif;
                                                border-collapse: collapse;
                                                width: 100%;
                                            }

                                            #customers td,
                                            #customers th {
                                                border: 1px solid #ddd;
                                                padding: 8px;
                                                color: #000000;
                                            }

                                            #customers tr:nth-child(even) {
                                                background-color: #ffffff;
                                            }

                                            #customers tr:hover {
                                                background-color: #ddd;
                                            }

                                            #customers th {
                                                padding-top: 12px;
                                                padding-bottom: 12px;
                                                text-align: left;
                                                background-color: #ffffff;
                                                color: #003579;
                                            }
                                            </style>
                                            @if($trackings->status)
                                            <table id="customers">
                                                <thead>
                                                    <tr>
                                                        <th colspan="5">Consignment No:
                                                            {{$trackings->trackHeader->strShipmentNo}}</th>
                                                    </tr>

                                                    <tr>
                                                        <th>DATE</th>
                                                        <th>Transaction Number</th>
                                                        <th>Location</th>
                                                        <th></th>
                                                        <th>Event</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach($trackings->trackDetails as $trackDetail)
                                                    <tr>
                                                        <td>

                                                            @if(isset($trackDetail->strActionDate))
                                                            <?php
$year = substr($trackDetail->strActionDate, 4, 4);
$month = substr($trackDetail->strActionDate, 2, 2);
$date = substr($trackDetail->strActionDate, 0, 2);
?>
                                                            {{$date }}:{{$month}}:{{$year}}
                                                            @endif
                                                            @if(isset($trackDetail->strActionTime))
                                                            <?php

$minutes = substr($trackDetail->strActionTime, 2, 2);
$hour = substr($trackDetail->strActionTime, 0, 2);
?>
                                                            {{$hour}}:{{$minutes}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($trackDetail->strManifestNo))
                                                            {{$trackDetail->strManifestNo}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($trackDetail->strOrigin))
                                                            {{$trackDetail->strOrigin}}
                                                            @endif
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                            @if(isset($trackDetail->strAction))
                                                            {{$trackDetail->strAction}}
                                                            @endif


                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            @endif
                                        </div>
                                    </div>
                                    <center>
                                        <a class="removeitem"
                                            href="{{route('dashboard.order_history',\Auth::user()->id)}}">Back</a>
                                    </center>
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