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
                        <li class="home">My Profile</li>
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

                                        <h4>PROFILE INFORMATION
                                            <a class="btn btn-sm btn-primary pull-right" href="javascript:void(0);"
                                                data-toggle="modal" data-target="#my_profile_modal">Update</a>
                                        </h4>
                                        <div class="modal fade" id="my_profile_modal" role="dialog">
                                            <div class="modal-dialog modal-lg">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Update profile</h4><button type="button"
                                                            class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!!Form::open(['route'=>['dashboard.profile_update'],'files'=>true,'class'=>'form-horizontal'])!!}
                                                        <input type="hidden" name="chemist_id" value="{{$chemist->id}}">
                                                        <div class="row">
                                                            <div class="col-md-6 col-xs-12">
                                                                <label for=""><strong>CHEMIST SHOP
                                                                        NAME*</strong></label>
                                                                <div class="input-group mb-5">
                                                                    <div>
                                                                        <span class="basic-addon1"></span>
                                                                        <input type="text" name="Party_Name"
                                                                            id="Party_Name" class="form-control"
                                                                            value="{{ $chemist->Party_Name }}"
                                                                            placeholder="Enter Party Name"
                                                                            aria-label="Username"
                                                                            aria-describedby="basic-addon1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-xs-12">
                                                                <label for=""><strong>MOBILE NUMBER*</strong></label>
                                                                <div class="input-group mb-5">
                                                                    <div>
                                                                        <span class="basic-addon1"></span>
                                                                        <input type="number" name="Mobile_No"
                                                                            id="Mobile_No" class="form-control"
                                                                            value="{{ $chemist->Mobile_No }}"
                                                                            placeholder="Enter your 10 Digit No."
                                                                            aria-label="Username"
                                                                            aria-describedby="basic-addon1" readonly="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6 col-xs-12">
                                                                <label for=""><strong>GSTIN*</strong></label>
                                                                <div class="input-group mb-5">
                                                                    <div>
                                                                        <span class="basic-addon1"></span>
                                                                        <input type="text" name="GSTIN" id="GSTIN"
                                                                            class="form-control"
                                                                            pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$"
                                                                            onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9]/g, '')"
                                                                            maxlength="15" value="{{ $chemist->GSTIN }}"
                                                                            placeholder="Enter GSTIN"
                                                                            aria-label="Username"
                                                                            aria-describedby="basic-addon1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-xs-12">
                                                                <label for=""><strong>EMAIL*</strong></label>
                                                                <div class="input-group mb-5">
                                                                    <div>
                                                                        <span class="basic-addon1"></span>
                                                                        <input type="email" name="Email_ID"
                                                                            id="Email_ID" class="form-control"
                                                                            value="{{ $chemist->Email_ID }}"
                                                                            placeholder="Enter Valid Email Id"
                                                                            aria-label="Username"
                                                                            aria-describedby="basic-addon1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6 col-xs-12">
                                                                <label for=""><strong>DRUG LICENCE FORM NO.
                                                                        (20)</strong></label>
                                                                <div class="input-group mb-5">
                                                                    <div>
                                                                        <span class="basic-addon1"></span>
                                                                        <input type="text" name="DL_No" id="DL_No"
                                                                            class="form-control"
                                                                            value="{{ $chemist->DL_No }}"
                                                                            placeholder="Enter DL No"
                                                                            aria-label="Username"
                                                                            aria-describedby="basic-addon1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-xs-12">
                                                                <label for=""><strong>DRUG LICENCE FORM NO.
                                                                        (21)</strong></label>
                                                                <div class="input-group mb-5">
                                                                    <div>
                                                                        <span class="basic-addon1"></span>
                                                                        <input type="text" name="DL_No_21" id="DL_No_21"
                                                                            class="form-control" value=""
                                                                            placeholder="Enter DL No"
                                                                            aria-label="Username"
                                                                            aria-describedby="basic-addon1">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>


                                                        <div class="row">
                                                            <div class="col-md-6 col-xs-12">
                                                                <label for=""><strong>DRUG LICENCE FORM NO.
                                                                        FILE(20)
                                                                        <br>(ACCEPT ONLY
                                                                        IMAGE OR PDF FILE)</strong></label>

                                                                <div class="input-group mb-5">
                                                                    <div>
                                                                        <span class="basic-addon1"></span>
                                                                        <input type="file" name="DL_File" id="DL_File"
                                                                            class="form-control" value="DL_File"
                                                                            placeholder="Enter DRUG LICENCE FILE"
                                                                            aria-label="Username"
                                                                            aria-describedby="basic-addon1">
                                                                    </div>
                                                                    <a href="{{asset($chemist->DL_File)}}"
                                                                        target="_blank">{{$chemist->DL_File}}</a>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-6 col-xs-12">
                                                                <label for=""><strong>DRUG LICENCE FORM NO.
                                                                        FILE(21)<br>(ACCEPT ONLY
                                                                        IMAGE OR PDF FILE)</strong></label>

                                                                <div class="input-group mb-5">
                                                                    <div>
                                                                        <span class="basic-addon1"></span>
                                                                        <input type="file" name="DL_File_21"
                                                                            id="DL_File_21" class="form-control"
                                                                            value="DL_File"
                                                                            placeholder="Enter DRUG LICENCE FILE"
                                                                            aria-label="Username"
                                                                            aria-describedby="basic-addon1">
                                                                    </div>
                                                                    <a href="{{asset($chemist->DL_File)}}"
                                                                        target="_blank">{{$chemist->DL_File}}</a>
                                                                </div>

                                                            </div>
                                                        </div>



                                                        <div class="row">
                                                            <div class="col-md-6 col-xs-12">
                                                                <label for=""><strong>DRUG LICENCE FORM 20
                                                                        VALID FROM*</strong></label>

                                                                <div class="input-group mb-5">
                                                                    <div>
                                                                        <span class="basic-addon1"></span>
                                                                        <input type="date" name="DL_Valid_From"
                                                                            id="Contact_Person" class="form-control"
                                                                            value="{{ $chemist->DL_Valid_From }}"
                                                                            aria-label="Username"
                                                                            aria-describedby="basic-addon1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-xs-12">
                                                                <label for=""><strong>DRUG LICENCE FORM 21
                                                                        VALID FROM*</strong></label>

                                                                <div class="input-group mb-5">
                                                                    <div>
                                                                        <span class="basic-addon1"></span>
                                                                        <input type="date" name="DL_Valid_From_21"
                                                                            id="Contact_Person" class="form-control"
                                                                            value="{{ $chemist->DL_Valid_From_21 }}"
                                                                            aria-label="Username"
                                                                            aria-describedby="basic-addon1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-md-6 col-xs-12">
                                                                <label for=""><strong>CONTACT PERSON*</strong></label>
                                                                <div class="input-group mb-5">
                                                                    <div>
                                                                        <span class="basic-addon1"></span>
                                                                        <input type="text" name="Contact_Person"
                                                                            id="Contact_Person" class="form-control"
                                                                            value="{{ $chemist->Contact_Person }}"
                                                                            placeholder="Enter Party Name"
                                                                            aria-label="Username"
                                                                            aria-describedby="basic-addon1">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 col-xs-12">
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

                                        <table id="customers">

                                            <tr>
                                                <th>CHEMIST SHOP NAME</th>
                                                <th>MOBILE NUMBER</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $chemist->Party_Name }}</td>
                                                <td>{{ $chemist->Mobile_No }}</td>
                                            </tr>


                                            <tr>
                                                <th>GSTIN</th>
                                                <th>EMAIL</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $chemist->GSTIN }}</td>
                                                <td>{{ $chemist->Email_ID }}</td>
                                            </tr>
                                            <tr>
                                                <th>DRUG LICENCE FORM 20 NO.</th>
                                                <th>DRUG LICENCE FORM 20 FILE</th>
                                            </tr>
                                            <tr>
                                                <td>{{ $chemist->DL_No }}</td>
                                                <td>
                                                    @if($chemist->DL_File)
                                                    <a href="{{asset($chemist->DL_File)}}"
                                                        target="_blank">{{$chemist->DL_File}}</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>DRUG LICENCE FORM 21 NO.</th>
                                                <th>DRUG LICENCE FORM 21 FILE</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    {{ $chemist->DL_No_21 }}</td>
                                                <td>
                                                    @if($chemist->DL_File_21)
                                                    <a href="{{asset($chemist->DL_File_21)}}"
                                                        target="_blank">{{$chemist->DL_File_21}}</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>DRUG LICENCE FORM 20 VALID FROM</th>
                                                <th>DRUG LICENCE FORM 21 VALID FROM</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    @if($chemist->DL_Valid_From)
                                                    {{ $chemist->DL_Valid_From->format('d-M-Y') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($chemist->DL_Valid_From_21)
                                                    {{ $chemist->DL_Valid_From_21->format('d-M-Y') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">AUTHORIZED PERSON NAME</th>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{{ $chemist->Contact_Person }}</td>
                                            </tr>
                                        </table>

                                        <?php
$address = \App\Address::where('user_id', \Auth::user()->id)->where('Address1', '!=', '')->first();

?>



                                        @if($address)
                                        <h4>PARTY CURRENT ADDRESS</h4>
                                        <table id="customers">
                                            <tr>
                                                <th>ADDRESS LINE 1</th>
                                                <th>ADDRESS LINE 2</th>

                                            </tr>
                                            <tr>
                                                <td>{{ $address->Address1 }}</td>
                                                <td>{{ $address->Address2 }}</td>

                                            </tr>
                                            <tr>
                                                <th>ADDRESS LINE 3</th>
                                                <th>PINCODE</th>
                                            </tr>
                                            <tr>

                                                <td>{{ $address->Address3 }}</td>
                                                <td>{{ $address->PIN }}</td>
                                            </tr>


                                            <tr>
                                                <th>STATE</th>
                                                <th>CITY</th>

                                            </tr>
                                            <tr>
                                                <?php
$city = \App\City::find($address->City_Code);
?>
                                                <td>
                                                    @if($city)
                                                    {{$city->name}}
                                                    @endif
                                                </td>
                                                <?php
$state = \App\State::find($address->State_Code);
?>
                                                <td>
                                                    @if($state)
                                                    {{$state->name}}
                                                    @endif
                                                </td>
                                            </tr>

                                        </table>
                                        @endif
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