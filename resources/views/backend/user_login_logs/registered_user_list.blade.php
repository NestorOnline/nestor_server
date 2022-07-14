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
                        <li class="breadcrumb-item active">Registered User List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    {!!Form::open(['files'=>true,'method'=>'get','class'=>'form-horizontal'])!!}
    <div class="row">
        <label for="generic_name" class="col-md-1 control-label">State</label>
        <div class="col-sm-2">
            <select name="state_code" class="form-control">
                <option value="">--Select State--</option>
                @foreach($states as $state)
                <option value='{{$state->id}}' {{$state_code == $state->state_code? 'selected':''}}>{{$state->name}}
                </option>
                @endforeach
            </select>
        </div>
        <label for="generic_name" class="col-md-1 control-label">User Type</label>
        <div class="col-sm-2">
            <select name="registered_for" class="form-control">
                <option value='Admin' {{'Admin' == $registered_for? 'selected':''}}>Admin</option>
                <option value='Chemist' {{'Chemist' == $registered_for? 'selected':''}}>Chemist</option>
                <option value='User' {{'User' == $registered_for? 'selected':''}}>User</option>
                <option value='All' {{'All' == $registered_for? 'selected':''}}>All</option>
            </select>
        </div>
        <div class="col-sm-2">
            <input type="date" name="start_date" value="{{$start_date}}" class="form-control">
        </div>
        <div class="col-sm-2">
            <input type="date" name="end_date" value="{{$end_date}}" class="form-control">
        </div>
        <div class="col-sm-2">
            <button class="btn btn-sm btn-info" type="submit">View</button>
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
                                        <th>ACTION</th>
                                        <th>PARTY TYPE</th>
                                        <th>USER NAME</th>
                                        <th>PARTY CODE</th>
                                        <th>REGISTERED TIME</th>
                                        <th>DL No.</th>
                                        <th>GST</th>
                                        <!-- <th>IP ADDRESS</th> -->
                                        <th>PLATEFORM</th>
                                        <!-- <th>REFERRAL</th> -->
                                        <!-- <th>LOCATION</th> -->
                                        <th>CITY </th>
                                        <th>STATE </th>
                                        <th>PINCODE </th>
                                        <th>
                                            {!!Form::open(['files'=>true,'method'=>'get','class'=>'form-horizontal'])!!}
                                            <input type="hidden" name="start_date" value="{{$start_date}}">
                                            <input type="hidden" name="end_date" value="{{$end_date}}">
                                            <input type="hidden" name="registered_for" value="{{$registered_for}}">
                                            <label for="generic_name" class="control-label">User For</label>
                                            <select name="user_for" onchange="submit()" class="form-control">
                                                <option value='' {{'All' == $user_for? 'selected':''}}>All</option>
                                                <option value='3' {{'3' == $user_for? 'selected':''}}>Testing</option>
                                                <option value='1' {{'1' == $user_for? 'selected':''}}>Active</option>
                                            </select>
                                            {!!Form::close()!!}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $key=>$user)
                                    <?php
$chemist = \App\Chemist::where('user_id', $user->id)->first();
?>

                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            @if($chemist)
                                            <a href="{{route('backends.chemists.view_profile',$user->id)}}">
                                                View Chemist Profile
                                            </a>
                                            @else
                                            <a href="#">
                                                View Chemist Profile
                                            </a>
                                            @endif
                                        </td>
                                        <td>{{$user->role}}</td>
                                        <td>
                                            {{$user->mobile}}
                                            @if($chemist)
                                            -{{$chemist->Party_Name}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($chemist)
                                            {{$chemist->Party_Code}}
                                            @endif
                                        </td>
                                        <td>{{$user->created_at}}</td>
                                        @if($chemist)
                                        <td>{{$chemist->DL_No}}</td>
                                        <td>{{$chemist->GSTIN}}</td>
                                        <!-- <td>{{$user->ip_address}}</td> -->
                                        <td>WEB</td>
                                        <!-- <td>Nothing</td> -->
                                        <!-- <td> @if($chemist){{$chemist->Geolocation}}@endif</td> -->
                                        @if($chemist)
                                        <?php
$city = \App\City::where('city_code', $chemist->City_Code)->first();
$state = \App\State::where('state_code', $chemist->State_Code)->first();
?>
                                        <td> @if($city){{$city->name}}@endif</td>
                                        <td> @if($state){{$state->name}}@endif</td>
                                        <td> @if($chemist){{$chemist->PIN}}@endif</td>
                                        @endif
                                        @else
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        @endif
                                        <td>
                                            @if($user->ApprovalSatus_Code==3)
                                            Testing
                                            @else
                                            Active
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