@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Payment Detail</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Payment Detail</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

{!!Form::open(['files'=>true,'method'=>'get','class'=>'form-horizontal'])!!} 
        <div class="row">
             
            <div class="col-sm-1">
</div>
<div class="col-sm-3">
<input name="date" type="date"  class="form-control" value="{{$date}}">
</div>
<div class="col-sm-3">
    <button class="btn btn-sm btn-info" type="submit">Submit</button>
</div>
      
</div>
{!!Form::close()!!} 
<br>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">          
            <div class="card">
              
              <!-- /.card-header -->
              <div class="card-body">
                <table  class="table table-bordered table-striped">
                  <thead>
                <tr style="text-align: center!important">
                                <th>S. No. </th> 
                                <th>Date Time</th>                              
                                 <th>Order Code</th>
                                 <th>Requested Amount</th>
                                 <th>Transaction Status</th> 
                            </tr>
                  </thead>
                
                  <tbody>
                    @foreach($payments as $key=>$payment)
                    <tr>
                       <td>{{$key+1}}</td>
                       <td>{{$payment->created_at->format('d-M-Y H:i:s')}}</td>
                       <td>@if($payment->Order_Code)
                         {{$payment->Order_Code}}
                            @else
                         Not Generated
                            @endif
                       </td>
                       <td>{{$payment->Requested_Amount}}</td>
                       <td>{{$payment->TransStatus}}</td>
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
</div>

@stop

