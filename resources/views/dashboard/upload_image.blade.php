@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <ul class="items">
                        <li class="home"> <a href="{{route('home')}}" title="Go to Home"> Home </a> </li>
                        <li class="home"><a href="{{route('dashboard.contact_us')}}" title="Go to Dashboard"> Dashboard </a> </li>
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
                    <h4>How would you like us to Upload Profile Pic?*</h4>
                     {!!Form::open(['route'=>['dashboard.upload_image'],'files'=>true,'class'=>'form-horizontal'])!!}
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">                            
                            <div class="rightside-details col-md-12 pr-0">
                                <label for=""><small><strong>Profile Image</strong></small></label>
                                <input type="file" name="profile_image"  class="form-control">                               
                            </div>
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
