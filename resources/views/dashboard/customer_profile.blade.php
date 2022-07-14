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
                        <li class="home">My Profile</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            @include('frontend.include.dashboard_sidebar')
            <div class="col-md-9">
                <div class="cart-product mt-3">
                    <h4 style="color: #003579"></h4>
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                            <div class="rightside-details col pr-0">
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
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

                                        <h4>PROFILE INFORMATION</h4>
                                        @if($customer)
                                        <table id="customers">
                                            <tr>
                                                <th>Mobile</th>
                                                <th>Name</th>
                                            </tr>
                                            <tr>
                                                <td>{{$customer->Mobile_No}}</td>
                                                <td>{{$customer->Party_Name}}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">Email</th>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{{$customer->Email_ID}} <button
                                                        class="book-now-cart pull-right" data-toggle="modal"
                                                        data-target="#myModal">Modify</button></td>
                                            </tr>
                                            <div class="modal fade" id="myModal" role="dialog">
                                                <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">

                                                            <h4 class="modal-title">Edit Profile</h4>
                                                            <button type="button" class="close pull-right"
                                                                data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {!!Form::open(['route'=>['dashboard.profile_update'],'files'=>true,'class'=>'form-horizontal'])!!}
                                                            <div class="row">
                                                                <input type="hidden" name="user_id"
                                                                    value="{{$customer->user_id}}">
                                                                <input type="hidden" name="chemist_id"
                                                                    value="{{$customer->id}}">
                                                                <div class="col-md-12">
                                                                    <label for=""><strong>Mobile No.</strong></label>
                                                                    <div class="input-group mb-5">
                                                                        <div class="input-group-prepend">
                                                                            <input type="number" name="Mobile_No"
                                                                                class="form-control"
                                                                                value="{{$customer->Mobile_No}}"
                                                                                placeholder="Enter your Mobile No."
                                                                                readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label for=""><strong>Full Name</strong></label>
                                                                    <div class="input-group mb-5">
                                                                        <div>
                                                                            <span class="basic-addon1"></span>
                                                                            <input type="text" name="Party_Name"
                                                                                value="{{$customer->Party_Name}}"
                                                                                class="form-control"
                                                                                placeholder="Enter Full Name"
                                                                                aria-label="Username"
                                                                                aria-describedby="basic-addon1">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label for=""><strong>Email</strong></label>
                                                                    <div class="input-group mb-5">
                                                                        <div>
                                                                            <span class="basic-addon1"></span>
                                                                            <input type="text" name="Email_ID"
                                                                                value="{{$customer->Email_ID}}"
                                                                                class="form-control"
                                                                                placeholder="Enter Email Address">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="input-group mb-5">
                                                                        <div>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Update
                                                                                Profile</button>
                                                                            <a type="button" href="javascript:void(0)"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal">Cancel</a>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                            {!!Form::close()!!}
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </table>
                                        @endif

                                        @if($address)
                                        <h4>Customer Address Information</h4>
                                        <table id="customers">
                                            <tr>
                                                <th>PINCODE</th>
                                                <th>ADDRESS LINE 1</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $address->PIN }}</td>
                                                <td>{{ $address->Address1 }}</td>
                                            </tr>
                                        </table>

                                        <table id="customers">
                                            <tr>
                                                <th>ADDRESS LINE 2</th>
                                                <th>ADDRESS LINE 3</th>

                                            </tr>
                                            <tr>
                                                <td>{{ $address->Address2 }}</td>
                                                <td>{{ $address->Address3 }}</td>

                                            </tr>

                                        </table>

                                        <table id="customers">
                                            <tr>
                                                <th>STATE</th>
                                                <th>CITY</th>

                                            </tr>
                                            <tr>
                                                <?php
$city = \App\City::find($address->City_Code);
?>
                                                <td>
                                                    @if($city)
                                                    {{$city->name}}
                                                    @endif
                                                </td>
                                                <?php
$state = \App\State::find($address->State_Code);
?>
                                                <td>
                                                    @if($state)
                                                    {{$state->name}}
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
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
</div>
@include('frontend.include.footer')