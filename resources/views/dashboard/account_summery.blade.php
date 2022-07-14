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
                        <li class="home">ACCOUNT SUMMARY</li>
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

                                        <h4>ACCOUNT SUMMARY</h4>

                                        <table id="customers">
                                            <thead>
                                                <tr>
                                                    <th>S. No.</th>
                                                    <th>DATE TIME</th>
                                                    <th>Reference</th>
                                                    <th>Points Earn</th>
                                                    <th>Points Redeem</th>
                                                    <th>Balance Points</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($reward_ledgers as $key=>$reward_ledger)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>
                                                        @if($reward_ledger->Date_Time)
                                                        {{$reward_ledger->Date_Time->format('d-M-Y')}}
                                                        {{$reward_ledger->Date_Time->format('H:i')}}
                                                        @endif
                                                    </td>
                                                    <td>{{ $reward_ledger->Reference }}</td>


                                                    <td>{{ $reward_ledger->Credit }}</td>
                                                    <td>{{ $reward_ledger->Debit }}</td>
                                                    <td>{{ $reward_ledger->Balance }}</td>
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