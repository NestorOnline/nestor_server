@extends('backend.theme.formtheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Priscription Detail</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Priscription Detail</li>
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
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            Selec Your Patient
                                        </th>
                                        <th>
                                            Add New
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            {!!Form::open(['files'=>true,'method'=>'GET','class'=>'form-horizontal'])!!}
                                            <input type="hidden" name="doctor_appointment_id"
                                                value="{{$doctor_appointment->id}}">
                                            <select class="form-control petient_id" name="petient_id"
                                                onchange="submit();">
                                                <option value="">----- Select Petient----</otion>
                                                    @foreach($patients as $patient)
                                                <option value="{{$patient->id}}">{{$patient->Patient_Name}} </otion>
                                                    @endforeach
                                            </select>
                                            {!!Form::close()!!}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#myModal">
                                                Add Patient
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>



                            @include('flash')
                            <div class="modal" id="myModal">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <p>Add Petient Detail</p>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            {!!Form::open(['route'=>['backend.patient_details.create'],'files'=>true,'class'=>'form-horizontal'])!!}
                                            {{ csrf_field() }}
                                            <input type="hidden" name="user_id"
                                                value="{{$doctor_appointment->user_id}}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('Patient_Name') ? ' has-error' : '' }}">
                                                        <label for="heading"
                                                            class="col-md-12 control-label">Patient_Name</label>
                                                        <div class="col-md-12">
                                                            <input id="Patient_Name" type="text" class="form-control"
                                                                name="Patient_Name" value="{{ old('Patient_Name') }}"
                                                                required autofocus>
                                                            @if ($errors->has('Patient_Name'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('Patient_Name') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('Patient_Age') ? ' has-error' : '' }}">
                                                        <label for="heading"
                                                            class="col-md-12 control-label">Patient_Age</label>
                                                        <div class="col-md-12">
                                                            <input id="product_name" type="text" class="form-control"
                                                                name="Patient_Age" value="{{ old('Patient_Age') }}"
                                                                required autofocus>
                                                            @if ($errors->has('Patient_Age'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('Patient_Age') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('Sex') ? ' has-error' : '' }}">
                                                        <label for="heading" class="col-md-12 control-label">Sex</label>
                                                        <div class="col-md-12">
                                                            <input id="product_name" type="text" class="form-control"
                                                                name="Sex" value="{{ old('Sex') }}" required autofocus>
                                                            @if ($errors->has('Sex'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('Sex') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('Mobile_No') ? ' has-error' : '' }}">
                                                        <label for="heading"
                                                            class="col-md-12 control-label">Mobile_No</label>
                                                        <div class="col-md-12">
                                                            <input id="Mobile_No" type="text" class="form-control"
                                                                name="Mobile_No" value="{{ old('Mobile_No') }}" required
                                                                autofocus>
                                                            @if ($errors->has('Mobile_No'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('Mobile_No') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('Food_Allergies') ? ' has-error' : '' }}">
                                                        <label for="heading"
                                                            class="col-md-12 control-label">Food Allergies</label>
                                                        <div class="col-md-12">
                                                            <input id="Food_Allergies" type="text" class="form-control"
                                                                name="Food_Allergies"
                                                                value="{{ old('Food_Allergies') }}" required autofocus>
                                                            @if ($errors->has('Food_Allergies'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('Food_Allergies') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="display: none">

                                                    <div
                                                        class="form-group{{ $errors->has('Tendency_Bleed') ? ' has-error' : '' }}">
                                                        <label for="heading"
                                                            class="col-md-12 control-label">Tendency_Bleed</label>
                                                        <div class="col-md-12">
                                                            <input id="Tendency_Bleed" type="text" class="form-control"
                                                                name="Tendency_Bleed"
                                                                value="Tendency_Bleed" required autofocus>
                                                            @if ($errors->has('Tendency_Bleed'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('Tendency_Bleed') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('Heart_Disease') ? ' has-error' : '' }}">
                                                        <label for="heading"
                                                            class="col-md-12 control-label">Heart Disease</label>
                                                        <div class="col-md-12">
                                                            <input id="Heart_Disease" type="text" class="form-control"
                                                                name="Heart_Disease" value="{{ old('Heart_Disease') }}"
                                                                required autofocus>
                                                            @if ($errors->has('Heart_Disease'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('Heart_Disease') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                                <div class="col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('High_Blood_Pressure') ? ' has-error' : '' }}">
                                                        <label for="heading"
                                                            class="col-md-12 control-label">High Blood Pressure</label>
                                                        <div class="col-md-12">
                                                            <input id="High_Blood_Pressure" type="text"
                                                                class="form-control" name="High_Blood_Pressure"
                                                                value="{{ old('High_Blood_Pressure') }}" required
                                                                autofocus>
                                                            @if($errors->has('High_Blood_Pressure'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('High_Blood_Pressure') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('Diabetic') ? ' has-error' : '' }}">
                                                        <label for="heading"
                                                            class="col-md-12 control-label">Diabetic</label>
                                                        <div class="col-md-12">
                                                            <input id="Diabetic" type="text" class="form-control"
                                                                name="Diabetic" value="{{ old('Diabetic') }}" required
                                                                autofocus>
                                                            @if ($errors->has('Diabetic'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('Diabetic') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div
                                                        class="form-group{{ $errors->has('Others') ? ' has-error' : '' }}">
                                                        <label for="heading"
                                                            class="col-md-12 control-label">Others</label>
                                                        <div class="col-md-12">
                                                            <input id="Others" type="text" class="form-control"
                                                                name="Others" value="{{ old('Others') }}" required
                                                                autofocus>
                                                            @if ($errors->has('Others'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('Others') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="display: none">
                                                    <div
                                                        class="form-group{{ $errors->has('Surgery') ? ' has-error' : '' }}">
                                                        <label for="heading"
                                                            class="col-md-12 control-label">Surgery</label>
                                                        <div class="col-md-12">
                                                            <input id="Surgery" type="text" class="form-control"
                                                                name="Surgery" value="Surgery" required
                                                                autofocus>
                                                            @if ($errors->has('Surgery'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('Surgery') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="display: none">
                                                    <div
                                                        class="form-group{{ $errors->has('Accident') ? ' has-error' : '' }}">
                                                        <label for="heading"
                                                            class="col-md-12 control-label">Accident</label>
                                                        <div class="col-md-12">
                                                            <input id="Accident" type="text" class="form-control"
                                                                name="Accident" value="Accident" required
                                                                autofocus>
                                                            @if ($errors->has('Accident'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('Accident') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                                <div class="col-md-6" style="display: none">
                                                    <div
                                                        class="form-group{{ $errors->has('Family_Medical_History') ? ' has-error' : '' }}">
                                                        <label for="heading"
                                                            class="col-md-12 control-label">Family_Medical_History</label>
                                                        <div class="col-md-12">
                                                            <input id="Family_Medical_History" type="text"
                                                                class="form-control" name="Family_Medical_History"
                                                                value="Family_Medical_History" required
                                                                autofocus>
                                                            @if($errors->has('Family_Medical_History'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('Family_Medical_History') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="display: none">
                                                    <div
                                                        class="form-group{{ $errors->has('Current_Medication') ? ' has-error' : '' }}">
                                                        <label for="heading"
                                                            class="col-md-12 control-label">Current_Medication</label>
                                                        <div class="col-md-12">
                                                            <input id="Current_Medication" type="text"
                                                                class="form-control" name="Current_Medication"
                                                                value="Current_Medication" required
                                                                autofocus>
                                                            @if ($errors->has('Current_Medication'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('Current_Medication') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="display: none">
                                                    <div
                                                        class="form-group{{ $errors->has('Female_Pregnancy') ? ' has-error' : '' }}">
                                                        <label for="heading"
                                                            class="col-md-12 control-label">Female_Pregnancy</label>
                                                        <div class="col-md-12">
                                                            <input id="Female_Pregnancy" type="text"
                                                                class="form-control" name="Female_Pregnancy"
                                                                value="Female_Pregnancy" required
                                                                autofocus>
                                                            @if ($errors->has('Female_Pregnancy'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('Female_Pregnancy') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="display: none">
                                                    <div
                                                        class="form-group{{ $errors->has('Breast_Feeding') ? ' has-error' : '' }}">
                                                        <label for="heading"
                                                            class="col-md-12 control-label">Breast_Feeding</label>
                                                        <div class="col-md-12">
                                                            <input id="Breast_Feeding" type="text" class="form-control"
                                                                name="Breast_Feeding"
                                                                value="Breast_Feeding" required autofocus>
                                                            @if ($errors->has('Breast_Feeding'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('Breast_Feeding') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
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
                            <!-- Main content -->
                        </div>
                        <script>
                        function get_detail_on_patient_select() {
                            var petient_id = $('.petient_id').val();
                            if (petient_id) {
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('backend.patient_details.get_detail_on_patient_select') }}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        petient_id: petient_id
                                    },
                                    success: function(data) {
                                        $('.get_petient_detail').html(data);
                                    }
                                });
                            } else {
                                $('.get_petient_detail').html("");
                            }
                        }
                        </script>
                        @stop