@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chemist List Without Party Code</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Chemist List Without Party Code</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    {!!Form::open(['files'=>true,'method'=>'get','class'=>'form-horizontal'])!!}

    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-2">
                <label for="generic_name" class="control-label">User Type</label>
                <select name="is_verify" class="form-control">
                    <option value="">--Select User Type</option>
                    <option value="verify">Verify User</option>
                    <option value="not_verify">Not Verify User</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="generic_name" class="control-label">Date From</label>
                <input type="date" name="from_date" value="{{$search_from_date}}" class="form-control">
            </div>
            <div class="col-sm-2">
                <label for="generic_name" class="control-label">Date To</label>
                <input type="date" name="to_date" value="{{$search_to_date}}" class="form-control">
            </div>
            <div class="col-sm-2">
                <br>
                <button class="btn btn-sm btn-info" type="submit" style="margin-top: 10px">View</button>
            </div>
        </div>
    </div>
    {!!Form::close()!!}
    <div class="container-fluid">
        <div class="row">
            <a href="{{route('backend.chemists.create')}}" class="btn btn-sm btn-info">Add Chemist</a>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Chemist List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>Registration Date</th>
                                        <th>Mobile No</th>
                                        <th>Status</th>
                                        <th>Party Name</th>
                                        <th>Party Code</th>
                                        <th>Conatct Person</th>
                                        <th>DL No.</th>
                                        <th>DL File</th>
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
                                    @foreach($users as $key=>$user)
                                    <?php
$chemist = \App\Chemist::where('Party_Code',0)->where('PartyType_Code',13)->where('user_id', $user->id)->first();
?>
                                    @if($chemist)
                                    <?php
 $PartyDetails = ['Party_Code' => 0, 'PartyType_Code' => $chemist->PartyType_Code, 'Party_ID' => $chemist->Party_ID, 'OnlineParty_id' => $chemist->id, 'Registration_Date' => $chemist->created_at->format('d-M-Y H:i:s'), 'Party_Name' => $chemist->Party_Name, 'Address1' => $chemist->Address1, 'Address2' => $chemist->Address2, 'Address3' => $chemist->Address3, 'City_Code' => $chemist->City_Code, 'State_Code' => $chemist->State_Code, 'PIN' => $chemist->PIN, 'Phone' => $chemist->Phone, 'Email_ID' => $chemist->Email_ID, 'Contact_Person' => $chemist->Contact_Person, 'Mobile_No' => $chemist->Mobile_No, 'Email' => $chemist->Email, 'GSTIN' => $chemist->GSTIN, 'DLForm20' => $chemist->DL_No, 'DLForm21' => $chemist->DL_No_21, 'DLForm20_File' => $chemist->DL_File, 'DLForm21_File' => $chemist->DL_File_21, 'DLForm21ValidFrom' => $chemist->DL_Valid_From_21, 'DLForm20ValidFrom' => $chemist->DL_Valid_From];
 $data = [];
 $data['PartyDetails'] = json_encode($PartyDetails);
 $data['API_KEY'] = 'fdAu52PaUI1';
//   $data['PartyDetails']="{'Party_Code':1,'PartyType_Code':13,'Party_ID':101,'GPS':null,'Party_Name':'Test','Address1':'AddressLine1','Address2':'AddressLine2','Address3':'AddressLine3','City_Code':1,'City_Name':null,'State_Code':0,'State_Name':null,'PIN':null,'Phone':null,'DL_No':null,'PAN_No':null,'GSTIN':null,'Contact_Person':null,'Mobile_No':null,'Email':null,'Transporter_Code':0,'Transporter_Name':null,'Territory_Code':0,'Territory_Name':null,'TPArea_Code':0,'Area_Code':0,'Area_Name':null,'DistanceFromCity':0,'Photos':null,'LastVisit_Date':null,'LastInvoice_Date':null,'LastGoodsReceipt_Date':null,'LastInvoice_Value':0,'OutStanding_Value':null,'ApprovalStatus_Code':0,'Upload_Status':0,'CreatedBy':0,'Created_Date':null}";
 $post_data = json_encode($data, JSON_UNESCAPED_SLASHES);

 $url = "http://nestorpharmaceuticals.com/API/NestorOnline.asmx/PartyAdd";

 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
 $server_output = curl_exec($ch);
 curl_close($ch);
                                    ?>
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            @if($chemist->created_at)
                                            {{$chemist->created_at->format('d-M-Y')}}
                                            @endif
                                        </td>
                                        <td>{{$chemist->Mobile_No}}</td>
                                        <td>{{$user->status}}</td>
                                        <td>{{$chemist->Party_Name}}</td>
                                        <td>{{$chemist->Party_Code}}</td>
                                        <td>{{$chemist->Contact_Person}}</td>
                                        <td>{{$chemist->DL_No}}</td>
                                        <td><a href="{{asset($chemist->DL_File)}}"
                                                target="_blank">{{$chemist->DL_File}}</a></td>
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
                                            @if($chemist->Status==0)
                                            <b style="color: red">Deactivate</b>
                                            @else

                                            <b style="color: #00cc00">Activate</b>
                                            @endif
                                        </td>
                                        <td>
                                            @if($chemist->Status==1)
                                            <a href="{{route('backend.chemists.deactivate',$chemist->id)}}"
                                                class="btn btn-sm btn-danger">Deactivate</a>

                                            @else
                                            <a href="{{route('backend.chemists.activate',$chemist->id)}}"
                                                class="btn btn-sm btn-success">Activate</a>
                                            @endif


                                            <a href="{{route('backend.chemists.edit',$chemist->id)}}"
                                                class="btn btn-sm btn-info">Edit</a>
                                            <a href="{{route('backend.chemists.delete',$chemist->id)}}"
                                                class="btn btn-sm btn-dark">Delete</a>
                                        </td>
                                    </tr>
                                    @endif
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