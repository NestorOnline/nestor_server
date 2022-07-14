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
                        <li class="home">Delivery Address</li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
$statesOp = '';
$citiesOp = '';

foreach ($states as $state) {
    $statesOp = $statesOp . '<option value="' . $state->id . '">' . $state->name . '</option>';
    foreach ($state->cities as $city) {
        $citiesOp = $citiesOp . '<option value="' . $city->id . '" class="' . $state->id . '">' . $city->name . '</option>';
    }
}
?>
        @include('flash')
        <div class="row">
            @include('frontend.include.dashboard_sidebar')
            <div class="col-md-9">

                <div class="cart-product mt-3">
                    @foreach($addresses as $address)
                    @if($address->Address1&&$address->City_Code)
                    @if($address->set_as_a_default=='Yes')
                    <h4 style="color: #00cc33">Primary Delivery Address</h4>
                    @elseif($address->set_as_a_current=='Yes')
                    <h4 style="color: #a04e4e">Last Order Delivery Address</h4>
                    @else
                    <h4>Delivery Address</h4>
                    @endif

                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                            <div class="rightside-details col pr-0">
                                <div class="row m-0">
                                    <div class="product-item-name col pl-0">
                                        @if($address->address_type=='is_home')
                                        <a href="#" class="btn btn-sm"
                                            style="color: white; background-color: gray">Home</a>
                                        @endif
                                        @if($address->address_type=='is_work')
                                        <a href="#" class="btn btn-sm"
                                            style="color: white; background-color: gray">Work</a>
                                        @endif
                                    </div>
                                </div>
                                <br>
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <p class="form m-0">{{$address->Contact_Person}} &#160; &#160; &#160; &#160;
                                            &#160;{{$address->Mobile_No}}</p>
                                    </div>
                                </div>
                                <div class="row m-0 mt-2">
                                    <div class="catag-name col pl-0">
                                        <p class="form m-0">
                                            @if($address->Address1)
                                            {{$address->Address1}},
                                            @endif
                                            @if($address->Address2)
                                            {{$address->Address2}},
                                            @endif
                                            @if($address->Address3)
                                            {{$address->Address3}},
                                            @endif

                                            <?php
$city = \App\City::find($address->City_Code);
?>

                                            @if($city)
                                            {{$city->name}},
                                            @else
                                            {{$address->city}},
                                            @endif

                                            <?php
$state = \App\State::find($address->State_Code);
?>

                                            @if($state)
                                            {{$state->name}}
                                            @else
                                            {{$address->state}}
                                            @endif

                                            @if($address->PIN)
                                            -{{$address->PIN}}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="row m-0 mt-2">
                                    <div class="catag-name col pl-0">

                                    </div>
                                    <div class="item-prices col-2 p-0 text-right">

                                        <div class="discount-val">
                                            @if($address->set_as_a_current!='Yes')
                                            <a href="{{route('dashboard.set_as_a_current',$address->id)}}"
                                                style="color: #ea2732">Set As A Current</a>
                                            <br>
                                            @endif
                                            <a href="{{route('dashboard.edit_address',$address->id)}}"
                                                class="btn btn-xs btn-info">Edit</a>
                                            <a href="{{route('dashboard.delete_address',$address->id)}}"
                                                class="btn btn-xs btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                <div class="col-md-4 offset-md-4">
                    <div><a href="{{route('dashboard.add_address')}}" class="add-to-cart">Add Address</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($addresses as $address)
<div class="modal" id="modify_address{{$address->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Address</h3>
            </div>
            {!!Form::open(['route'=>['dashboard.edit_address',$address->id],'files'=>true,'class'=>'form-horizontal'])!!}
            <div class="modal-body">
                <div class="select-add-box">
                    <div class="row">
                        <input type="hidden" name="user_id" value="{{\Auth::user()->id}}">
                        <input type="hidden" name="address_id" value="{{$address->id}}">
                        <div class="col-md-12">
                            <label for=""><strong>Full Name</strong></label>
                            <div class="input-group mb-5">
                                <div>
                                    <span class="basic-addon1"></span>
                                    <input type="text" name="full_name" value="{{$address->full_name}}"
                                        class="form-control" placeholder="Enter Full Name" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for=""><strong>Address Line 1</strong></label>
                            <div class="input-group mb-5">
                                <div>
                                    <span class="basic-addon1"></span>
                                    <input type="text" name="address1" value="{{$address->address1}}"
                                        class="form-control" placeholder="Enter Address Line 1" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for=""><strong>Address Line 2</strong></label>
                            <div class="input-group mb-5">
                                <div>
                                    <span class="basic-addon1"></span>
                                    <input type="text" name="address2" value="{{$address->address2}}"
                                        class="form-control" placeholder="Enter Address Line 2" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for=""><strong>State</strong></label>
                            <div class="input-group mb-5">
                                <div>
                                    <span class="basic-addon1"></span>
                                    <select id="state_id" name="state_id" class="form-control" required autofocus>
                                        {!!$statesOp!!}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for=""><strong>City</strong></label>
                            <div class="input-group mb-5">
                                <div>
                                    <span class="basic-addon1"></span>
                                    <select id="city_id" class="form-control" name="city_id" required autofocus>
                                        {!!$citiesOp!!}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for=""><strong>PIN</strong></label>
                            <div class="input-group mb-5">
                                <div>
                                    <span class="basic-addon1"></span>
                                    <input type="text" name="pincode" value="{{$address->pincode}}" class="form-control"
                                        placeholder="Enter Your PIN" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for=""><strong>Mobile No.</strong></label>
                            <div class="input-group mb-5">
                                <div class="input-group-prepend">
                                    <span class="input-group-text basic-addon1" id="basic-addon1">+91</span>
                                    <input type="number" name="phone_no" class="form-control"
                                        value="{{$address->phone_no}}" placeholder="Enter your Mobile No."
                                        aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save Address</button>
                <a type="button" href="javascript:void(0)" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endforeach

@include('frontend.include.footer')