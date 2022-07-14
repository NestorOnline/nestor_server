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
                        <li class="home">My Wallet</li>
                    </ul>
                </div>
            </div>
        </div>
        @include('flash')
        <div class="row">
            @include('frontend.include.dashboard_sidebar')

            <div class="col-md-9">
                <div class="cart-product mt-3">
                    <h4>My Wallet</h4>
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                            <div class="row m-0">
                                <div class="catag-name col pl-0">
                                    <h4 style="color: #003579">Remaining Current Wallet Amount (Rs.): {{\Auth::user()->wallet}}</h4>

                                </div>
                            </div>
                        </div>
                    </div>
                    {!!Form::open(['route'=>['dashboard.wallet_recharge'],'files'=>true,'class'=>'form-horizontal'])!!}
                    <input type="hidden" name="user_id" value="{{\Auth::user()->id}}"  class="form-control"> 
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">                            
                            <div class="rightside-details col-md-12 pr-0">
                                <label for=""><small><strong>Recharge Amount (Rs.)</strong></small></label>
                                <input type="number" name="recharge_amount"  class="form-control">                               
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
