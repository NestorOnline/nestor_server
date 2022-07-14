@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- <a href="{{route('backend.sales_schemes.create')}}" class="btn btn-sm btn-info">Add                             <h3 class="card-title">Offer List</h3>
</a>  -->
<!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Offer List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Schemes</th>
                                        <th>Product</th>
                                        <th>Scheme On</th>
                                        <th>Next Min. Order Qty</th>
                                        <th>Free Qty</th>
                                        <th>Effective From</th>
                                        <th>Effective To</th>
                                        <th>Image</th>
                                        <th>Upload</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales_schemes as $key=>$sales_scheme)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        
                                        <td>{{$sales_scheme->SalesScheme_Name}}</td>
                                        <?php
                                    $product = \App\Product::where('product_code','=',$sales_scheme->Product_Code)->first();
                                        ?>
                                        <td>
                                            @if($product)
                                            {{$product->brand_name}}
                                            @endif
                                        </td>
                                        <td>{{$sales_scheme->SchemeOn}}</td>
                                        <td>{{$sales_scheme->NextMinSaleQty_ForScheme}}</td>
                                        <td>{{$sales_scheme->Free_Qty}} </td>
                                        <td>
                                            @if($sales_scheme->Effective_From)
                                            {{$sales_scheme->Effective_From->format('d-M-Y')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($sales_scheme->Effective_To)
                                            {{$sales_scheme->Effective_To->format('d-M-Y')}}
                                            @endif
                                        </td>
                                        <td>
                                               @if($sales_scheme->Image)
 <img src="{{asset($sales_scheme->Image)}}" alt="" style="width: 60%!important;
    border-radius: 10px;">
                            @else
 <img src="{{asset('img/schemes.png')}}" alt="" style="width: 60%!important;
    border-radius: 10px;">
                            @endif
                                        </td>
                                        <td>  
                                          <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal{{$sales_scheme->id}}">Change Image</button>
                                        

  <!-- Modal -->
  <div class="modal fade" id="myModal{{$sales_scheme->id}}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{$sales_scheme->SalesScheme_Name}}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
            {!!Form::open(['route'=>['backend.sales_schemes.image_upload',$sales_scheme->id],'files'=>true,'class'=>'form-horizontal'])!!} 
            <div class="col-md-12">
                <input type="hidden" name="sales_scheme_id"  value="{{$sales_scheme->id}}">
                <input type="file" name="Image" class="form-control">
            </div>
            <br>
            <div class="col-md-12">
         <button type="submit" class="btn btn-primary">
                 Submit
          </button>
            </div>
            {!!Form::close()!!} 
        </div>
      </div>
      
    </div>
  </div></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                               
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


@stop