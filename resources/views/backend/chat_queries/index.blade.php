@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chat Query</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Chat Query List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
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
                                        <th>Chat Issue</th>
                                        <th>Order No.</th>
                                        <th>Party Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($chat_queries as $key=>$chat_query)
                                    @if($chat_query->user_id)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <?php
$chat_question_option = \App\ChatquestionOption::find($chat_query->chat_question_id);
$order = \App\Order::find($chat_query->order_id);
?>
                                        <td>
                                            @if($chat_question_option)
                                            {{$chat_question_option->option}}
                                            @endif
                                            @if($chat_query->name)
                                            {{$chat_query->name}}
                                            @endif
                                            @if($chat_query->image)
                                            <img src="{{asset($chat_query->image)}}" style="width: 200px">
                                            {{$chat_query->name}}
                                            @endif
                                        </td>
                                        @if($order)
                                        <td>{{$order->Order_No}}</td>
                                        <td>
                                            {{$order->Party_Name}}
                                            <br>
                                            {{$order->Mobile_No}}
                                        </td>
                                        @else
                                        <td></td>
                                        <td></td>
                                        @endif
                                        <td>
                                        </td>
                                    </tr>
                                    @endif
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