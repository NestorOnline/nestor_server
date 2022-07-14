@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chemist List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Chemist List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('flash')
    <?php
$statesOp = '';
$citiesOp = '';
foreach ($states as $state) {
    if ($state->id == $search_state_code) {
        $statesOp = $statesOp . '<option value="' . $state->id . '" selected="selected">' . $state->name . '</option>';
    } else {
        $statesOp = $statesOp . '<option value="' . $state->id . '">' . $state->name . '</option>';
    }
    foreach ($state->cities as $city) {
        if ($city->id == $search_city_code) {
            $citiesOp = $citiesOp . '<option value="' . $city->id . '" class="' . $state->id . '" selected="selected">' . $city->name . '</option>';
        } else {
            $citiesOp = $citiesOp . '<option value="' . $city->id . '" class="' . $state->id . '">' . $city->name . '</option>';
        }

    }
}
?>
    {!!Form::open(['files'=>true,'method'=>'get','class'=>'form-horizontal'])!!}

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <label for="generic_name" class="control-label">State</label>
                <select name="search_state_code" id="state_id" class="form-control">
                    <option value="">--Select State</option>
                    {!!$statesOp!!}
                </select>
            </div>
            <div class="col-sm-2">
                <label for="generic_name" class="control-label">City</label>
                <select name="search_city_code" id="city_id" class="form-control">
                    <option value="">--Select City</option>
                    {!!$citiesOp!!}
                </select>
            </div>
            <div class="col-sm-2">
                <label for="generic_name" class="control-label">Status</label>
                <select name="search_status" id="search_status" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Deactive</option>
                </select>
            </div>

            <div class="col-sm-2">
                <label for="generic_name" class="control-label">Date From</label>
                <input type="date" name="search_from_date" value="{{$search_from_date}}" class="form-control">
            </div>
            <div class="col-sm-2">
                <label for="generic_name" class="control-label">Date To</label>
                <input type="date" name="search_to_date" value="{{$search_to_date}}" class="form-control">
            </div>
            <div class="col-sm-2">
                <br>
                <button class="btn btn-sm btn-info" type="submit" style="margin-top: 10px">View</button>
                <a style="margin-top: 10px"
                    href="{{route('backend.chemists.export')}}?State_Code={{$search_state_code}}&search_from_date={{$search_from_date}}&search_to_date={{$search_to_date}}"
                    class="btn btn-sm btn-info">Export</a>
            </div>
        </div>
    </div>
    {!!Form::close()!!}

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h3 class="card-title">Chemist List
                                <!-- <a href="{{route('backend.chemists.create')}}"
                                            class="btn btn-sm btn-info pull-right">Add_Chemist</a> -->

                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>DATE</th>
                                        <th>Mobile No</th>
                                        <th>Party Name</th>
                                        <th>Party Code</th>
                                        <th>Conatct Person</th>
                                        <th>DL No.</th>
                                        <th>DL File</th>
                                        <th>
                                            <p style="width: 150px">
                                                DL Valid From
                                            <p>
                                        </th>
                                        <th>Email ID</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>PIN</th>
                                        <th>Party Type</th>
                                        <th>GST No.</th>
                                        <th>STATUS</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($chemists as $key=>$chemist)
                                    @if($chemist->admin_approval==1)
                                    <tr style="background-color: #fafad2">
                                        @elseif($chemist->admin_approval==6)
                                    <tr style="background-color: #d0f0c0">
                                        @elseif($chemist->admin_approval==2)
                                    <tr style="background-color: #ff9999">
                                        @else
                                    <tr style="background-color: #fafad2
">
                                        @endif


                                        <td>{{$key+1}}</td>
                                        <td>{{$chemist->created_at->format('d-M-Y')}}</td>
                                        <td>{{$chemist->Mobile_No}}</td>
                                        <td>{{$chemist->Party_Name}}</td>
                                        <td>{{$chemist->Party_Code}}</td>
                                        <td>{{$chemist->Contact_Person}}</td>
                                        <td>
                                            @if($chemist->DL_No)
                                            DL20: {{$chemist->DL_No}}
                                            @endif

                                            @if($chemist->DL_No_21)
                                            <br>
                                            DL21: {{$chemist->DL_No_21}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($chemist->DL_File)
                                            <a class="btn btn-xs btn-primary" href="{{asset($chemist->DL_File)}}"
                                                target="_blank">DL_20_File </a>
                                            @endif
                                            @if($chemist->DL_File_21)
                                            <a class="btn btn-xs btn-primary" href="{{asset($chemist->DL_File_21)}}"
                                                target="_blank">DL_21_File </a>
                                            @endif
                                        </td>
                                        <td>
                                            <p style="width: 150px"> @if($chemist->DL_Valid_From)
                                                DL20: {{$chemist->DL_Valid_From->format('d-M-Y')}}
                                                @endif

                                                @if($chemist->DL_Valid_From_21)
                                                <br>
                                                DL21: {{$chemist->DL_Valid_From_21->format('d-M-Y')}}
                                                @endif
                                            </p>
                                        </td>
                                        <td>{{$chemist->Email_ID}}</td>
                                        <td>@if($chemist->city){{$chemist->city->name}}@endif</td>
                                        <td>@if($chemist->state){{$chemist->state->name}}@endif</td>
                                        <td>{{$chemist->PIN}}</td>
                                        <td>
                                            @if($chemist->PartyType_Code==17)
                                            Chemist
                                            @else
                                            Customer
                                            @endif
                                        </td>
                                        <td>
                                            {{$chemist->GSTIN}}
                                        </td>
                                        <td>
                                            @if($chemist->admin_approval==6)
                                            <b style="color: #00cc00">Approved</b>
                                            @elseif($chemist->admin_approval==2)
                                            <b style="color: #00cc00">Rejected</b>
                                            @else
                                            <b style="color: #00cc00">Not Updated</b>
                                            @endif
                                        </td>
                                        <td>
                                            @if($chemist->admin_approval==6)
                                            <a href="{{route('backend.chemists.rejected',$chemist->id)}}"
                                                class="btn btn-sm btn-danger">Rejected</a>
                                            @elseif($chemist->admin_approval==2)
                                            <a href="{{route('backend.chemists.approved',$chemist->id)}}"
                                                class="btn btn-sm btn-success">Approved</a>
                                            @else
                                            <a href="{{route('backend.chemists.approved',$chemist->id)}}"
                                                class="btn btn-sm btn-success">Approved</a>
                                            <a href="{{route('backend.chemists.rejected',$chemist->id)}}"
                                                class="btn btn-sm btn-danger">Rejected</a>
                                            @endif

                                            <!-- <a href="{{route('backend.chemists.edit',$chemist->user_id)}}"
                                                class="btn btn-sm btn-info">Edit</a>
                                            <a href="{{route('backend.chemists.delete',$chemist->user_id)}}"
                                                class="btn btn-sm btn-dark">Delete</a> -->
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