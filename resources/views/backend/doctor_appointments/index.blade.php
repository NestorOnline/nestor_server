@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Doctor Appointment List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Group List</li>
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
                        <div class="card-header">
                            <h3 class="card-title">Doctor Appointment List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Chemist</th>
                                        <th>Call Back No.</th>
                                        <th>Email</th>
                                        <th>Previous Prescription</th>
                                        <th>Symptom</th>
                                        <th>Schedule At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctor_appointments as $key=>$doctor_appointment)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            @if($doctor_appointment->chemist)
                                            Party-Name: {{$doctor_appointment->chemist->Party_Name}}
                                            <br>Registered No.: {{$doctor_appointment->chemist->Mobile_No}}
                                            @endif
                                        </td>
                                        <td>{{$doctor_appointment->mobile}}</td>
                                        <td>{{$doctor_appointment->email}}</td>
                                        <td><a class="btn btn-sm btn-info" href="{{asset($doctor_appointment->file_attechment)}}" target="_blank">Prescription File</a></td>
                                        <td>{{$doctor_appointment->symptoms}}</td>
                                        <td width="120">
                                            @if($doctor_appointment->schedule_date)
                                            {{$doctor_appointment->schedule_date->format('d-M-Y')}}
                                            <br>
                                            {{$doctor_appointment->schedule_time}}
                                            @endif
                                        </td>

                                        <td>
                                            @if($doctor_appointment->doctor_id)
                                            @if($doctor_appointment->status==6)
                                            
                                            
                                            <a href="{{route('backend.doctor_appointments.rejected',$doctor_appointment->id)}}"
                                                class="btn btn-sm btn-danger">Rejected</a>
                                            @else
                                            @if(count($doctor_appointment->doctor_prescription_products)>=1)

                                            @else
                                            <a href="{{route('backend.doctor_appointments.doctor_call_missed',$doctor_appointment->id)}}"
                                                class="btn btn-sm btn-warning">If Call Missed</a>
                                            @endif
                                            <a href="{{route('backend.doctor_appointments.prescribed_now',$doctor_appointment->id)}}"
                                                class="btn btn-sm btn-primary">Prescribed Now</a>

                                            <a href="{{route('backend.doctor_appointments.rejected',$doctor_appointment->id)}}"
                                                class="btn btn-sm btn-danger">Rejected</a>
                                            @endif
                                            @else
                                            <div class="modal fade" id="myModal{{$key}}" role="dialog">
                                                <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">

                                                            <h4 class="modal-title">Book An Appointment</h4><button
                                                                type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {!!Form::open(['route'=>['backend.doctor_appointments.accepted',$doctor_appointment->id],'files'=>true,'class'=>'form-horizontal'])!!}
                                                            {{csrf_field()}}
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    @if($doctor_appointment->chemist)
                                                                    <input class="form-control"
                                                                        value="{{$doctor_appointment->chemist->Party_Name}}">

                                                                    @else

                                                                    @endif
                                                                </div>

                                                                <div class="col-md-6">
                                                                    @if($doctor_appointment->chemist)
                                                                    <input class="form-control"
                                                                        value="{{$doctor_appointment->chemist->Mobile_No}}">
                                                                    @else

                                                                    @endif
                                                                </div>


                                                                <div class="col-md-6">
                                                                    <label for="dateschedule_date"
                                                                        class="control-label">Schedule
                                                                        Date</label>
                                                                    <input id="schedule_date" type="date"
                                                                        class="form-control" name="schedule_date"
                                                                        value="{{date('Y-m-d')}}" required
                                                                        autofocus>
                                                                    @if ($errors->has('schedule_date'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('schedule_date') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label for="schedule_time" class="control-label">
                                                                        Name</label>
                                                                    <input id="schedule_time" type="time"
                                                                        class="form-control" name="schedule_time"
                                                                        value="{{date('H:i:s')}}" required
                                                                        autofocus>
                                                                    @if ($errors->has('schedule_time'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('schedule_time') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <div class="col-md-8 col-md-offset-4">
                                                                    <button type="submit" class="btn btn-primary">
                                                                        Submit
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            {!!Form::close()!!}
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                            <a data-toggle="modal" data-target="#myModal{{$key}}"
                                                href="javascript:void(0);" class="btn btn-sm btn-success">Accepted</a>
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
