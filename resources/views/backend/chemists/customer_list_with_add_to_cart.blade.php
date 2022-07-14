@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customer List With Add To Card</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Customer List Without Party Code</li>
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
                            <h3 class="card-title">Chemist List
                                <a href="{{route('backend.chemists.ChemistWithAddToCardsExport')}}"
                                    class="btn btn-sm btn-info pull-right">Export</a>
                            </h3>

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
                                    @foreach($user_add_to_cards as $key=>$user_add_to_card)

                                    <?php
$user = \App\User::find($user_add_to_card->user_id);
$chemist = null;
if ($user) {
    $chemist = \App\Chemist::where('user_id', $user->id)->where('PartyType_Code',17)->first();
}
?>
                                    @if($user&&$chemist)
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
                                        <td>
                                            <a href="{{asset($chemist->DL_File)}}"
                                                target="_blank">{{$chemist->DL_File}}</a>
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
                                            @if($chemist->Status==0)
                                            <b style="color: red">Deactivate</b>
                                            @else

                                            <b style="color: #00cc00">Activate</b>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('backend.chemists.chemist_with_add_to_cart_data',$chemist->user_id)}}"
                                                class="btn btn-sm btn-info">View Cart Item</a>
                                                <a href="{{route('backend.chemists.payment_reminder_msg',$chemist->user_id)}}"
                                                class="btn btn-sm btn-info">Payment Remider SMS</a>
                                                
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