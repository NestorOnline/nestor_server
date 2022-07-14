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
                        <li class="home">Contact us</li>
                    </ul>
                </div>
            </div>
        </div>
        @include('flash')
        <div class="row">
            @include('frontend.include.dashboard_sidebar')

            <div class="col-md-9">
                <div class="cart-product mt-3">
                    <h4 style="color: #003579">Change Password </h4>
                    </h4>
                    {!!Form::open(['route'=>['dashboard.changepassword'],'files'=>true,'class'=>'form-horizontal'])!!}
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                            <div class="rightside-details col-md-12 pr-0">
                                <label for=""><small><strong>Old Password</strong></small></label>
                                <input type="password" name="oldpassword" class="form-control">
                            </div>
                            <div class="rightside-details col-md-12 pr-0">
                                <label for=""><small><strong>New Password</strong></small></label>
                                <input type="password" name="newpassword" class="form-control">
                            </div>
                            <div class="rightside-details col-md-12 pr-0">
                                <label for=""><small><strong>Re-New Password</strong></small></label>
                                <input type="password" name="renewpassword" class="form-control">
                            </div>

                            <br> <br><br> <br>
                            <div class="col-md-3">
                                <div><button type="submit" class="add-to-cart">Submit</button></div>
                            </div>
                        </div>
                    </div>
                    {!!Form::close()!!}

                </div>

            </div>

        </div>
    </div>
</div>

@include('frontend.include.footer')