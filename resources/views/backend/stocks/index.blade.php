@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Stock Report List 1</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
               <li class="breadcrumb-item"><a href="#">Stock</a></li>
              <li class="breadcrumb-item active">Stock Report List 1</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    
    <section class="content">

       {!!Form::open(['files'=>true,'method'=>'GET','class'=>'form-horizontal'])!!}
       <div class="row">
       <div class="col-md-1">
       <label for="name" class="control-label">Office</label>
        </div>
        <div class="col-md-4">
      <select class="form-control" name="Office_Code" onchange="submit()">
      <option value="">All</option>
      @foreach($offices as $office)
        <option value="{{$office->Office_Code}}" {{$office->Office_Code==$Office_Code?'selected':''}}>{{$office->Location}}</option>
      @endforeach
      </select>
</div>
</div>
{!!Form::close()!!}
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">          
            <div class="card" style="overflow-x: auto;">
             
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th class="text-center" style="vertical-align: text-top;">S. No. </th>
                                <th  class="text-center" style="vertical-align: text-top">Code</th>
                                 <th class="text-center" style="vertical-align: text-top">Product</th>
                                  <th class="text-center" style="vertical-align: text-top">Packing</th>
                                   <th class="text-center" style="vertical-align: text-top">Physical Stock</th>
                                    <th class="text-center" style="vertical-align: text-top">Ordered Qty</th>
                                     <th class="text-center" style="vertical-align: text-top">Hold Qty</th>
                                     <th class="text-center" style="vertical-align: text-top">Qty for New Order</th>
                                     <th class="text-center" style="vertical-align: text-top">Chemist MRP</th>
                                     <th class="text-center" style="vertical-align: text-top">Chemist Rate</th>
                                     <th class="text-center" style="vertical-align: text-top">Customer MRP</th>
                                     <th class="text-center" style="vertical-align: text-top">Customer Rate</th>
                  </tr>
                  </thead>
                  <tbody>
                      
              @foreach($products as $key=>$product)
                         <tr>
                                <td>{{$key+1}}</td>
                                @if($product)
                                 <td>{{$product->Product_ID}}</td>  
                                 <td>{{$product->brand_name}}</td> 
                                 <?php
                                 $package = \App\Package::find($product->package_id);
                                 ?>
                                 @if($package)
                                 <td>{{$package->name}}</td> 
                                 @endif
                                @endif  
                                <?php
$office_stock = \App\Stock::where('Office_Code', $Office_Code)->where('Product_Code', $product->product_code)->first();
?>
                                @if($Office_Code)
                               @if($office_stock)
                                <td>{{$office_stock->Stock}}</td> 
                                <td>{{$office_stock->Ordered_Qty}}</td> 
                                 <td>{{$office_stock->Hold_Qty}}</td> 
                                <td>{{$office_stock->QtyForNewOrder}}</td> 
                                @else
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                 @endif
                                 @else
                                 <?php
                                 $Stock = 0;
                                 $Ordered_Qty =0;
                                 $Hold_Qty = 0;
                                 $QtyForNewOrder = 0;
$Stock = \App\Stock::where('Product_Code', $product->product_code)->sum('Stock');
$Ordered_Qty = \App\Stock::where('Product_Code', $product->product_code)->sum('Ordered_Qty');
$Hold_Qty = \App\Stock::where('Product_Code', $product->product_code)->sum('Hold_Qty');
$QtyForNewOrder = \App\Stock::where('Product_Code', $product->product_code)->sum('QtyForNewOrder');
?>
<td>{{$Stock}}</td>
                                <td>{{$Ordered_Qty}}</td>
                               <td>{{$Hold_Qty}}</td>
                               <td>{{$QtyForNewOrder}}</td>

                                 @endif
                                 <td class="text-right">
                                   @if($product->mrp_price)
                                   {{$product->mrp_price->Price}}
                                  @endif
                                  </td> 
                                <td class="text-right">
                                  @if($product->chemist_price)
                                {{$product->chemist_price->Price}}
                               @endif
                              </td>  
                                <td class="text-right">
                                  @if($product->customer_mrp_price)
                                {{$product->customer_mrp_price->Price}}
                               @endif
                              </td> 
                                <td class="text-right">
                                 @if($product->customer_price)  
                                {{$product->customer_price->Price}}
                                 @endif
                              </td> 
                              
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

