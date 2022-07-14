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
            <div class="card card-default">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                @if($patient_detail)
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            @if($patient_detail->Patient_Name)
                                            <th>Patient Name</th>
                                            @endif
                                            @if($patient_detail->Patient_Age)
                                            <th>Patient Age</th>
                                            @endif
                                            @if($patient_detail->Sex)
                                            <th>Sex</th>
                                            @endif
                                            @if($patient_detail->Mobile_No)
                                            <th>Mobile No</th>
                                            @endif
                                        </tr>
                                        <tr>
                                            @if($patient_detail->Patient_Name)
                                            <td>{{$patient_detail->Patient_Name}}</td>
                                            @endif
                                            @if($patient_detail->Patient_Age)
                                            <td>{{$patient_detail->Patient_Age}}</td>
                                            @endif
                                            @if($patient_detail->Sex)
                                            <td>{{$patient_detail->Sex}}</td>
                                            @endif
                                            @if($patient_detail->Mobile_No)
                                            <td>{{$patient_detail->Mobile_No}}</td>
                                            @endif
                                        </tr>

                                        <tr>
                                            @if($patient_detail->Food_Allergies)
                                            <th>Food Allergies</th>
                                            @endif
                                            @if($patient_detail->High_Blood_Pressure)
                                            <td>{{$patient_detail->High_Blood_Pressure}}</td>
                                            @endif
                                            @if($patient_detail->Heart_Disease)
                                            <th>Heart Disease</th>
                                            @endif
                                            @if($patient_detail->Diabetic)
                                            <th>Diabetic</th>
                                            @endif
                                        </tr>
                                        <tr>
                                           
                                            @if($patient_detail->Tendency_Bleed)
                                            <td>{{$patient_detail->Tendency_Bleed}}</td>
                                            @endif
                                            @if($patient_detail->Heart_Disease)
                                            <td>{{$patient_detail->Heart_Disease}}</td>
                                            @endif
                                            @if($patient_detail->High_Blood_Pressure)
                                            <td>{{$patient_detail->High_Blood_Pressure}}</td>
                                            @endif
                                        </tr>

                                        <tr>
                                           
                                           
                                            @if($patient_detail->Otders)
                                            <th colspan="4">{{$patient_detail->Otders}}</th>
                                            @endif
                                        </tr>
                                       
                                        
                                       
                                    </thead>
                                </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Add Product</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                class="fas fa-times"></i></button>
                    </div>

                 </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {!!Form::open(['files'=>true,'class'=>'form-horizontal'])!!}
                    {{csrf_field()}}
                    <input type="hidden" name="patient_detail_id" value="{{$patient_detail->id}}">
                    <input type="hidden" name="doctorappointment_id" value="{{$patient_detail->doctorappointment_id}}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Add Prescriped Item in Doctor Prescription</label>
                                <select name="product_id[]" class="select2" multiple="multiple"
                                    data-placeholder="Select a Product" style="width: 100%;" required>
                                    <?php
$products = \App\Product::where('Prescription_Required', 1)->where('go_live', 1)->get();
?>
                                    @foreach($products as $product)
                                    <option value="{{$product->id}}">
                                        {{$product->generic_name}}
                                        ({{$product->brand_name}})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>Prescription Type</label>
                            <?php
$doctor_prescription_abbreviation1s = \App\DoctorPrescriptionAbbreviations::where('prescription_type', 1)->get();
?>
                            <select class="select2" style="width: 100%;" name="doses_id">
                                <option value="">Select</option>
                                @foreach($doctor_prescription_abbreviation1s as $doctor_prescription_abbreviation1)
                                <option value="{{$doctor_prescription_abbreviation1->id}}">
                                    {{$doctor_prescription_abbreviation1->abbreviation_code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Taking At</label>
                            <?php
$doctor_prescription_abbreviation2s = \App\DoctorPrescriptionAbbreviations::where('prescription_type', 2)->get();
?>
                            <select class="select2" style="width: 100%;" name="taken_id">
                                <option value="">Select</option>
                                @foreach($doctor_prescription_abbreviation2s as $doctor_prescription_abbreviation2)
                                <option value="{{$doctor_prescription_abbreviation2->id}}">
                                    {{$doctor_prescription_abbreviation2->abbreviation_code}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1">
                            <label>For Days</label>
                            <select class="select2" style="width: 100%;" name="no_of_day">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="30">30</option>
                                <option value="35">35</option>
                                <option value="40">40</option>
                                <option value="45">45</option>
                                <option value="50">50</option>
                                <option value="55">55</option>
                                <option value="60">60</option>
                                <option value="65">65</option>
                                <option value="70">70</option>
                                <option value="75">75</option>
                                <option value="80">80</option>
                                <option value="85">85</option>
                                <option value="90">90</option>
                                <option value="95">95</option>
                                <option value="100">100</option>

                            </select>
                        </div>

                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary" style="margin: 30px">
                                Add
                            </button>
                        </div>
                    </div>
                    {!!Form::close()!!}



                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Medicine Name</th>
                                <th class="text-center">Dosage</th>
                                <th class="text-center">Duration</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">No. Of Days</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doctor_prescription_products as $doctor_prescription_product)
                            <tr>
                                <td>
                                    @if($doctor_prescription_product->product)
                                    {{$doctor_prescription_product->product->generic_name}}
                                    ({{$doctor_prescription_product->product->brand_name}})
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($doctor_prescription_product->doctor_prescription_abbreviation_doses)
                                    {{$doctor_prescription_product->doctor_prescription_abbreviation_doses->abbreviation_code}}

                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($doctor_prescription_product->doctor_prescription_abbreviation_takes)
                                    {{$doctor_prescription_product->doctor_prescription_abbreviation_takes->abbreviation_code}}

                                    @endif
                                </td>
                                <td class="text-center">{{$doctor_prescription_product->qty}}</td>
                                <td class="text-center">{{$doctor_prescription_product->no_of_day}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <center>
                        <a class="btn btn-info"
                            href="{{route('backend.doctor_appointments.prescription_submit_now',$patient_detail->doctorappointment_id)}}">Prescription
                            Submit Now
                        </a>
                    </center>
                </div>
            </div>
        </div>
    </section>



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