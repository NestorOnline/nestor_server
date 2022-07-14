@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order Record</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Order Record</li>
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
            <select name="report_for" class="form-control">
                <option value="">---Select---</option>
                <option value='month_wise' {{'month_wise' == $report_for? 'selected':''}}>Month Wise</option>
                <option value='state_wise' {{'state_wise' == $report_for? 'selected':''}}>State Wise</option>
            </select>
        </div>
        <div class="col-sm-3">
            <select name="year" class="form-control">
                <option value="">---Select---</option>
                <option value='2021' {{'2021' == $year? 'selected':''}}>2021</option>
                <option value='2022' {{'2022' == $year? 'selected':''}}>2022</option>
                <option value='2023' {{'2023' == $year? 'selected':''}}>2023</option>
                <option value='2024' {{'2024' == $year? 'selected':''}}>2024</option>
                <option value='2025' {{'2025' == $year? 'selected':''}}>2025</option>
                <option value='2026' {{'2026' == $year? 'selected':''}}">2026</option>
                <option value='2027' {{'2027' == $year? 'selected':''}}>2027</option>
                <option value='2028' {{'2028' == $year? 'selected':''}}>2028</option>
                <option value='2029' {{'2029' == $year? 'selected':''}}>2029</option>
                <option value='2030' {{'2030' == $year? 'selected':''}}>2030</option>
            </select>
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
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>State</th>
                                        <th>JAN-{{$year}}</th>
                                        <th>FEB-{{$year}}</th>
                                        <th>MAR-{{$year}}</th>
                                        <th>APR-{{$year}}</th>
                                        <th>MAY-{{$year}}</th>
                                        <th>JUN-{{$year}}</th>
                                        <th>JUL-{{$year}}</th>
                                        <th>AUG-{{$year}}</th>
                                        <th>SEP-{{$year}}</th>
                                        <th>OCT-{{$year}}</th>
                                        <th>NOV-{{$year}}</th>
                                        <th>DEC-{{$year}}</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($states as $state)
                                    <?php

$orders_from_web1 = \App\Order::where('State_Code', '=', $state->id)->whereMonth('Order_Date', '01')
    ->whereYear('Order_Date', $year)->sum('Grand_Total');
$orders_from_Payment_Amount1 = \App\Order::where('State_Code', '=', $state->id)->whereMonth('Order_Date', '01')
    ->whereYear('Order_Date', $year)->sum('Payment_Amount');
$orders_from_Wallet_Amount1 = \App\Order::where('State_Code', '=', $state->id)->whereMonth('Order_Date', '01')
    ->whereYear('Order_Date', $year)->sum('WalletAmount');

$orders_from_web2 = \App\Order::where('State_Code', '=', $state->id)->whereMonth('Order_Date', '02')
    ->whereYear('Order_Date', $year)->sum('Grand_Total');
$orders_from_Payment_Amount2 = \App\Order::where('State_Code', '=', $state->id)->whereMonth('Order_Date', '02')
    ->whereYear('Order_Date', $year)->sum('Payment_Amount');
$orders_from_Wallet_Amount2 = \App\Order::where('State_Code', '=', $state->id)->whereMonth('Order_Date', '02')
    ->whereYear('Order_Date', $year)->sum('WalletAmount');

$orders_from_web3 = \App\Order::where('State_Code', '=', $state->id)->whereMonth('Order_Date', '03')
    ->whereYear('Order_Date', $year)->sum('Grand_Total');
$orders_from_web4 = \App\Order::where('State_Code', '=', $state->id)->whereMonth('Order_Date', '04')
    ->whereYear('Order_Date', $year)->sum('Grand_Total');
$orders_from_web5 = \App\Order::where('State_Code', '=', $state->id)->whereMonth('Order_Date', '05')
    ->whereYear('Order_Date', $year)->sum('Grand_Total');
$orders_from_web6 = \App\Order::where('State_Code', '=', $state->id)->whereMonth('Order_Date', '06')
    ->whereYear('Order_Date', $year)->sum('Grand_Total');
$orders_from_web7 = \App\Order::where('State_Code', '=', $state->id)->whereMonth('Order_Date', '07')
    ->whereYear('Order_Date', $year)->sum('Grand_Total');
$orders_from_web8 = \App\Order::where('State_Code', '=', $state->id)->where('Order_Date', '=', '08')->whereYear('Order_Date', $year)->sum('Grand_Total');
$orders_from_web9 = \App\Order::where('State_Code', '=', $state->id)->whereMonth('Order_Date', '09')
    ->whereYear('Order_Date', $year)->sum('Grand_Total');
$orders_from_web10 = \App\Order::where('State_Code', '=', $state->id)->whereMonth('Order_Date', '10')
    ->whereYear('Order_Date', $year)->sum('Grand_Total');
$orders_from_web11 = \App\Order::where('State_Code', '=', $state->id)->whereMonth('Order_Date', '11')
    ->whereYear('Order_Date', $year)->sum('Grand_Total');
$orders_from_web12 = \App\Order::where('State_Code', '=', $state->id)->whereMonth('Order_Date', '12')
    ->whereYear('Order_Date', $year)->sum('Grand_Total');
?>
                                    <tr>
                                        <td>{{$state->name}}</td>
                                        <td>{{$orders_from_web1}}</td>
                                        <td>{{$orders_from_web2}}</td>
                                        <td>{{$orders_from_web3}}</td>
                                        <td>{{$orders_from_web4}}</td>
                                        <td>{{$orders_from_web5}}</td>
                                        <td>{{$orders_from_web6}}</td>
                                        <td>{{$orders_from_web7}}</td>
                                        <td>{{$orders_from_web8}}</td>
                                        <td>{{$orders_from_web9}}</td>
                                        <td>{{$orders_from_web10}}</td>
                                        <td>{{$orders_from_web11}}</td>
                                        <td>{{$orders_from_web12}}</td>
                                    </tr>
                                    @endforeach

                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <center>
                        <a href="{{route('backend.orders.order_report')}}" class="btn btn-sm btn-info">Back</a>
                    </center>
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