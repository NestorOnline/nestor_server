@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Registered User List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Testing User List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    {!!Form::open(['route'=>['backend.user_login_logs.change_into_testing'],'files'=>true,'class'=>'form-horizontal'])!!}
    <div class="row">
        <div class="col-sm-1">
        </div>
        <label for="mobile" class="col-md-1 control-label">Mobile</label>
        <div class="col-sm-2">
            <input type="number" name="mobile" class="form-control">
        </div>
        <div class="col-sm-2">
            <button class="btn btn-sm btn-info" type="submit">Change into Testing</button>
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
                                        <th>S. No. </th>
                                        <th>USER NAME</th>
                                        <th>REGISTERED TIME</th>
                                        <th>IP ADDRESS</th>
                                        <th>PLATEFORM</th>
                                        <th>REFERRAL</th>
                                        <th>LOCATION</th>
                                        <th>
                                            USER FOR
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $key=>$user)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$user->role}}</td>
                                        <?php
$chemist = \App\Chemist::find($user->user_id);
?>
                                        <td>
                                            {{$user->mobile}}
                                            @if($chemist)
                                            -{{$chemist->Party_Name}}
                                            @endif
                                        </td>
                                        <td>{{$user->created_at}}</td>
                                        <td>{{$user->ip_address}}</td>
                                        <td>WEB</td>
                                        <td>Nothing</td>
                                        <td> @if($chemist){{$chemist->Geolocation}}@endif</td>
                                        <td>
                                            @if($user->ApprovalSatus_Code==3)
                                            Testing
                                            @else
                                            Active
                                            @endif
                                            <a class="btn btn-xs btn-success"
                                                href="{{route('backend.user_login_logs.change_user',$user->id)}}">Change</a>
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