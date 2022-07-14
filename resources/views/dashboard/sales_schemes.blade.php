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
                        <li class="home">All Available offers</li>
                    </ul>
                </div>
            </div>
        </div>
        @include('flash')
        <div class="row">
            @include('frontend.include.dashboard_sidebar')

            <div class="col-md-9">
                <div class="product-details">
                    <h4>All Available Offer</h4>
                    <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                        
                        
                            

                       
                         <div class="product-side-list">
                <div class="delivery-box-div mt-3">
                    
                     @foreach($sales_schemes as $key=>$sales_scheme)
                    <div class="row other-sec-devide">
                        <div class="col-md-3 p-2">
                            @if($sales_scheme->Image)
 <img src="{{asset($sales_scheme->Image)}}" alt="" style="width: 60%!important;
    border-radius: 10px;">
                            @else
 <img src="{{asset('img/schemes.png')}}" alt="" style="width: 60%!important;
    border-radius: 10px;">
                            @endif
                           
                        </div>
                        <div class="col-md-9">
                            <h6><a href="">Buy {{$sales_scheme->NextMinSaleQty_ForScheme}} Get {{$sales_scheme->Free_Qty}} Free</a></h6>
                            <?php
                            $product = \App\Product::where('product_code','=',$sales_scheme->Product_Code)->first();
                            ?>
                            <p class="m-0">{{$product->brand_name}} (Buy {{$sales_scheme->NextMinSaleQty_ForScheme}} Get {{$sales_scheme->Free_Qty}} Free)</p>
                             <h5 style="color: #32c7a7">
                             @if($sales_scheme->Effective_From)
                                VALID From	&nbsp; 
                                <strong>
                                 {{$sales_scheme->Effective_From->format('d-M-Y')}}
                                 </strong> 
                                 @endif
                                
                                @if($sales_scheme->Effective_To)
                                  <strong>
                                 To 
                                   {{$sales_scheme->Effective_To->format('d-M-Y')}}
                                    </strong> 
                                 @endif
                                 
                            </h5>
                            <h6><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#exampleModal">
  View Detail
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buy {{$sales_scheme->NextMinSaleQty_ForScheme}} Get {{$sales_scheme->Free_Qty}} Free</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>{{$product->brand_name}} (Buy {{$sales_scheme->NextMinSaleQty_ForScheme}} Get {{$sales_scheme->Free_Qty}} Free)</p>
        <h5 style="color: #32c7a7">Sales Scheme Code</h5>
        <p>{{$sales_scheme->SalesScheme_Code}}</p>
      </div>
      
    </div>
  </div>
</div></h6>
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('frontend.include.footer')
