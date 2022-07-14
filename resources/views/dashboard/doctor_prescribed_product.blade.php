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
                                                    <th>Doctor</th>
                                                    <th>Patient Detail</th>
                                                    <th>Appointment Schedule AT</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($doctor_appointment)
                                                <tr>
                                                    <td>{{ $doctor_appointment->created_at->format('d-M-Y')}}</td>
                                                    <td>{{ $doctor_appointment->mobile }}</td>
                                                    <td>
                                                        @if($doctor_appointment->schedule_date)
                                                        {{$doctor_appointment->schedule_date->format('d-M-Y')}}
                                                        {{$doctor_appointment->schedule_time}}
                                                        @endif
                                                    </td>
                                                    <td>{{ $doctor_appointment->status }}</td>

                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        @if(count($doctor_appointment->doctor_prescription_products))
                                        <table id="customers">
                                            <thead>
                                                <tr>
                                                    <th>S. No.</th>
                                                    <th>Product</th>
                                                    <th>Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($doctor_appointment->doctor_prescription_products as
                                                $key=>$doctor_prescription_product)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>
                                                        {{$doctor_prescription_product->product->generic_name}}
                                                        ({{$doctor_prescription_product->product->brand_name}})
                                                    </td>
                                                    <td>{{$doctor_prescription_product->qty}}</td>

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                        <a class="add-to-cart"
                                            href="{{route('dashboard.doctor_prescribed_product_add_to_mycart',$doctor_appointment->id)}}">Add
                                            To
                                            My Cart</a>
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