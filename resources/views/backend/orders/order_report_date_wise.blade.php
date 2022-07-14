@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Date Wise Order Record</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Date Wise Order Record</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


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
                                        <th>Date</th>
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
                                    @while($thisTime <= $endTime) <?php
$thisDate = date('Y-m-d', $endTime);

$endTime = strtotime('-1 day', $endTime); // increment for loop
?> <?php
$orders_from_web = \App\Order::where('OrderFrom_Code', '=', 2)->whereDate('created_at', $thisDate)
    ->sum('Grand_Total');
$orders_from_app = \App\Order::where('OrderFrom_Code', '=', 1)->whereDate('created_at', $thisDate)
    ->sum('Grand_Total');

$orders_from_Payment_Amount = \App\Order::where('OrderFrom_Code', '=', 1)->whereDate('created_at', $thisDate)->sum('Payment_Amount');
$orders_from_Wallet_Amount = \App\Order::where('OrderFrom_Code', '=', 1)->whereDate('created_at', $thisDate)->sum('WalletAmount');
$total = 0;
$total = $orders_from_web + $orders_from_app;
$grand_total_of_app = $grand_total_of_app + $orders_from_app;
$grand_total_of_web = $grand_total_of_web + $orders_from_web;
$grand_total = $grand_total + $orders_from_web + $orders_from_app;
$grand_Payment_Amount = $grand_Payment_Amount + $orders_from_Payment_Amount;
$grand_Wallet_Amount = $grand_Wallet_Amount + $orders_from_Wallet_Amount;
?> <tr>
                                        <td style="text-align: center!important">{{$s_no}}</td>
                                        <td style="text-align: center!important">
                                            {{DateTime::createFromFormat('Y-m-d', $thisDate)->format('d-M-Y')}} </td>
                                        <td style="text-align: right!important">
                                            <a href="{{url('orders/?date='.$thisDate.'&OrderFrom_Code=2')}}">{{number_format($orders_from_web, 2, '.', ',')}}
                                            </a>
                                        </td>
                                        <td style="text-align: right!important">
                                            <a href="{{url('orders/?date='.$thisDate.'&OrderFrom_Code=1')}}">
                                                {{number_format($orders_from_app, 2, '.', ',')}}
                                        </td>

                                        <td style="text-align: right!important">
                                            {{number_format($orders_from_Payment_Amount, 2, '.', ',')}}
                                        </td>

                                        <td style="text-align: right!important">
                                            {{number_format($orders_from_Wallet_Amount, 2, '.', ',')}}
                                        </td>
                                        <td style="text-align: right!important">
                                            <a href="{{url('orders/?date='.$thisDate)}}">
                                                {{number_format($total, 2, '.', ',')}}
                                            </a>
                                        </td>
                                        </tr>
                                        <?php
$s_no = $s_no + 1;
?>

                                        @endwhile
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