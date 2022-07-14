@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <ul class="items">
                        <li class="home"> <a href="{{route('home')}}" title="Go to Home"> Home </a> </li>
                        <li class="home"> <a href="{{route('dashboard.my_profile')}}" title="Go to Home"> Dashboard </a>
                        </li>
                        <li class="home">Doctor All Appointment</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            @include('frontend.include.dashboard_sidebar')
            <div class="col-md-9">
                <div class="cart-product mt-3">
                    <div class="product-details">
                        <div class="product-itemdetails row" valign="middle" id="itemid-922086">
                            <div class="rightside-details col pr-0">
                                <div class="row m-0">
                                    <div class="catag-name col pl-0">
                                        <style>
                                        #customers {
                                            font-family: Arial, Helvetica, sans-serif;
                                            border-collapse: collapse;
                                            width: 100%;
                                        }

                                        #customers td,
                                        #customers th {
                                            border: 1px solid #ddd;
                                            padding: 8px;
                                            color: #000000;
                                        }

                                        #customers tr:nth-child(even) {
                                            background-color: #ffffff;
                                        }

                                        #customers tr:hover {
                                            background-color: #ddd;
                                        }

                                        #customers th {
                                            padding-top: 12px;
                                            padding-bottom: 12px;
                                            text-align: left;
                                            background-color: #ffffff;
                                            color: #003579;
                                        }
                                        </style>

                                        <h4>Doctor All Appointment</h4>

                                        <table id="customers">
                                            <thead>
                                                <tr>
                                                    <th>S. No.</th>
                                                    <th>Request No.</th>
                                                    <th>DATE TIME</th>
                                                    <th>Patient Contact No.</th>
                                                    <th>Doctor Consultation Status</th>
                                                    <th>Remarks</th>
                                                 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($doctor_appointments as $key=>$doctor_appointment)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>#{{ $doctor_appointment->id }}</td>
                                                    <td>{{ $doctor_appointment->created_at->format('d-M-Y')}}</td>
                                                    <td>{{ $doctor_appointment->mobile }}</td>
                                                    <td>
                                                        @if($doctor_appointment->status==6)
                                                        <?php
$order = \App\Order::where('doctorappointment_id',$doctor_appointment->id)->get()
                                                        ?>
                                                        @if(count($order))
                                                        Payment Completed
                                                        @else
                                                        Prescription Generated
                                                        @endif
                                                        
                                                        @else
                                                        Doctor will call You Soon
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <center>
                                                        @if($doctor_appointment->status==6)
                                                        <?php
$order = \App\Order::where('doctorappointment_id',$doctor_appointment->id)->get()
                                                        ?>
                                                        @if(count($order))

<a href="{{route('frontend.prescription_print',$doctor_appointment->id)}}">
                                                        Download Your Prescription
                                                        </a>
                                                        <br>
                                                        Or
                                                        <br>
                                                        @else
                                                        @endif
                                                    <a href="{{route('dashboard.doctor_prescribed_product',$doctor_appointment->id)}}">
                                                        Add Prescribed items into cart
                                                        </a>
                                                        @else
                                                        Prescription Pending
                                                        @endif
                                    </center>
                                                    </td>
                                                    
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontend.include.footer')