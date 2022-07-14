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
                    <h4>All Available offers</h4>
                    <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                        
                        
                            

                       
                         <div class="product-side-list">
                <div class="delivery-box-div mt-3">
                    
                     @foreach($offers as $key=>$offer)
                    <div class="row other-sec-devide">
                        <div class="col-md-3 p-2">
                            <img src="{{asset($offer->image)}}" alt="" style="width: 60%!important;
    border-radius: 10px;">
                        </div>
                        <div class="col-md-9">
                            <h6><a href="">{{$offer->name}} </a></h6>
                            <p class="m-0"> {{$offer->description}}</p>
                             <h5 style="color: #32c7a7">VALID TILL:	&nbsp; <strong>21-03-2021</strong> 
                             &nbsp;
                             &nbsp;
                               @if($offer->code)
                               |
                             &nbsp;
                             CODE :  &nbsp;
                              {{$offer->code}}
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
        <h5 class="modal-title" id="exampleModalLabel">{{$offer->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>{{$offer->description}}</p>
         <h5 style="color: #32c7a7">	Eligibility</h5>
        <p>{{$offer->eligibility}}</p>
        <h5 style="color: #32c7a7">How To Get It</h5>
        <p>{{$offer->how_you_get}}</p>
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
