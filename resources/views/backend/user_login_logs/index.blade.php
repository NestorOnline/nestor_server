@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User Login logs List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User Login logs List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    {!!Form::open(['files'=>true,'method'=>'get','class'=>'form-horizontal'])!!}
    <div class="row">
        <div class="col-sm-1">
        </div>
        <label for="generic_name" class="col-md-1 control-label">User Type</label>
        <div class="col-sm-3">
            <select name="login_for" class="form-control">
                <option value='Admin' {{'Admin' == $login_for? 'selected':''}}>Admin</option>
                <option value='Chemist' {{'Chemist' == $login_for? 'selected':''}}>Chemist</option>
                <option value='User' {{'User' == $login_for? 'selected':''}}>User</option>
                <option value='All' {{'All' == $login_for? 'selected':''}}>All</option>
            </select>
        </div>
        <div class="col-sm-3">
            <input type="date" name="date" value="{{$date}}" class="form-control">
        </div>
        <div class="col-sm-2">
            <button class="btn btn-sm btn-info" type="submit">View</button>
        </div>

    </div>
    {!!Form::close()!!}

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
                                        <th>USER TYPE</th>
                                        <th>USER NAME</th>
                                        <th>LOGIN TIME</th>
                                        <th>IP ADDRESS</th>
                                        <th>PLATEFORM</th>
                                        <th>REFERRAL</th>
                                        <th>LOCATION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user_login_logs as $key=>$user_login_log)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$user_login_log->user_role}}</td>
                                        <?php
$chemist = \App\Chemist::find($user_login_log->user_id);
$user = \App\User::find($user_login_log->user_id);
?>
                                        <td>@if($user)
                                            {{$user->mobile}}
                                            @endif
                                            @if($chemist)
                                            -{{$chemist->Party_Name}}
                                            @endif</td>
                                        <td>{{$user_login_log->login_date_time}}</td>
                                        <td>{{$user_login_log->ip_address}}</td>
                                        <td>{{$user_login_log->plateform}}</td>
                                        <td>{{$user_login_log->referral}}</td>
                                        <td>{{$user_login_log->location}}</td>
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