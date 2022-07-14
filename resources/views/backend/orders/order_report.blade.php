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
                @for($x=2021; $x<=date('Y'); $x++) <option value="{{$x}}" {{$x == $year? 'selected':''}}>{{$x}}
                    </option>
                    @endfor
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
                                    <tr style="text-align: center!important">
                                        <th>S. No. </th>
                                        <th>MONTH</th>
                                        <th>ORDER FROM WEBSITE</th>
                                        <th>ORDER FROM APP</th>
                                        <th>BANK VOLUME</th>
                                        <th>REWARD POINT</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <?php
$s_no = 1;
$grand_total_of_app = 0;
$grand_total_of_web = 0;
$grand_Payment_Amount = 0;
$grand_Wallet_Amount = 0;
$grand_total = 0;
?>
                                <tbody>

                                    @for($month=12; $month>=1; $month--)
                                    @if(date('m')>=$month)
                                    <?php
$orders_from_web = \App\Order::where('OrderFrom_Code', '=', 2)->whereMonth('created_at', $month)
    ->whereYear('created_at', $year)->sum('Grand_Total');
$orders_from_app = \App\Order::where('OrderFrom_Code', '=', 1)->whereMonth('created_at', $month)
    ->whereYear('created_at', $year)->sum('Grand_Total');
$orders_from_Payment_Amount = \App\Order::where('OrderFrom_Code', '=', 1)->whereMonth('created_at', $month)
    ->whereYear('created_at', $year)->sum('Payment_Amount');
$orders_from_Wallet_Amount = \App\Order::where('OrderFrom_Code', '=', 1)->whereMonth('created_at', $month)
    ->whereYear('created_at', $year)->sum('WalletAmount');

$total = 0;
$total = $orders_from_web + $orders_from_app;
$grand_total_of_app = $grand_total_of_app + $orders_from_app;
$grand_total_of_web = $grand_total_of_web + $orders_from_web;
$grand_total = $grand_total + $orders_from_web + $orders_from_app;
$grand_Payment_Amount = $grand_Payment_Amount + $orders_from_Payment_Amount;
$grand_Wallet_Amount = $grand_Wallet_Amount + $orders_from_Wallet_Amount;

?>
                                    <tr>
                                        <td style="text-align: center!important">{{$s_no}}</td>
                                        <td style="text-align: center!important">
                                            {{date('M-Y', strtotime($year.'-'.$month.'-1'))}} </td>
                                        <td style="text-align: right!important"><a
                                                href="{{route('backend.orders.order_report_date_wise')}}?date={{date('Y-m', strtotime($year.'-'.$month.'-1'))}}">{{number_format($orders_from_web, 2, '.', ',')}}</a>
                                        </td>
                                        <td style="text-align: right!important"><a
                                                href="{{route('backend.orders.order_report_date_wise')}}?date={{date('Y-m', strtotime($year.'-'.$month.'-1'))}}">{{number_format($orders_from_app, 2, '.', ',')}}</a>
                                        </td>
                                        <td style="text-align: right!important">
                                            {{number_format($orders_from_Payment_Amount, 2, '.', ',')}}</td>
                                        <td style="text-align: right!important">
                                            {{number_format($orders_from_Wallet_Amount, 2, '.', ',')}}</td>
                                        <td style="text-align: right!important"><a
                                                href="{{route('backend.orders.order_report_date_wise')}}?date={{date('Y-m', strtotime($year.'-'.$month.'-1'))}}">{{number_format($total, 2, '.', ',')}}</a>
                                        </td>
                                    </tr>
                                    <?php
$s_no = $s_no + 1;
?>
                                    @endif
                                    @endfor
                                    <tr style="text-align: right!important;font-weight: bold">
                                        <td colspan="2" style="text-align: center!important">Grand Total </td>
                                        <td style="text-align: right!important">
                                            {{number_format($grand_total_of_web, 2, '.', ',')}}</td>
                                        <td style="text-align: right!important">
                                            {{number_format($grand_total_of_app, 2, '.', ',')}}</td>
                                        <td style="text-align: right!important">
                                            {{number_format($grand_Payment_Amount, 2, '.', ',')}}</td>
                                        <td style="text-align: right!important">
                                            {{number_format($grand_Wallet_Amount, 2, '.', ',')}}</td>
                                        <td style="text-align: right!important">
                                            {{number_format($grand_total, 2, '.', ',')}}</td>
                                    </tr>



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