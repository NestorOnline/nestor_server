@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Prescribed List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Prescribed List</li>
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
            <input name="date" type="date" class="form-control" value="{{$date}}">
        </div>
        <div class="col-sm-3">
            <select name="OrderFrom_Code" class="form-control">
                <option value="">All</option>
                <?php
$Orderreceivedfroms = \App\Orderreceivedfrom::all();
?>
                @foreach($Orderreceivedfroms as $Orderreceivedfrom)
                <option value="{{$Orderreceivedfrom->OrderReceivedFrom_Code}}"
                    {{$Orderreceivedfrom->OrderReceivedFrom_Code == $OrderFrom_Code? 'selected':''}}>
                    {{$Orderreceivedfrom->OrderReceivedFrom_Name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3">
            <button class="btn btn-sm btn-info" type="submit">View</button>
        </div>

    </div>
    {!!Form::close()!!}
    <br>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>ORDER NO.</th>
                                        <th>DATE</th>
                                        <th>NAME</th>
                                        <th>CITY</th>
                                        <th>STATE</th>
                                        <th>ORDER VALUE</th>
                                        <th>ORDER STATUS</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $key=>$order)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$order->Order_No}}</td>
                                        <td>{{$order->created_at->format('d-M-Y')}}</td>
                                        <td>{{$order->Party_Name}}</td>
                                        <?php
$city = \App\City::find($order->City_Code);
?>
                                        <td>
                                            @if($city)
                                            {{$city->name}}
                                            @endif
                                        </td>
                                        <?php
$state = \App\State::find($order->State_Code);
?>
                                        <td>
                                            @if($state)
                                            {{$state->name}}
                                            @endif
                                        </td>
                                        <td>{{$order->Grand_Total}}</td>


                                        <td>
                                            @if($order->petient_id)
                                            <strong style="color: #32CD32"> Forward
                                                Nestor</strong>
                                            @else
                                            <strong style="color: #DC143C"> Waiting For
                                                Prescribed</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$order->petient_id)
                                            <a href="{{route('backend.doctors.prescribed_order_detail',$order->id)}}"
                                                class="btn btn-sm btn-success">Prescribed Order</a>
                                            @else
                                            <a href="{{route('backend.doctors.prescribed_order_detail',$order->id)}}"
                                                class="btn btn-sm btn-success">View Order</a>
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
</div>

@stop