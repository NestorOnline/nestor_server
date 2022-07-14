@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Office List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Office List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>   <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">          
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Office List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>OFFICE</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($offices as $key=>$office)
                                    <tr>
                                    <?php
                                        $office_states= \App\OfficeState::where('Office_Code','=',$office->Office_Code)->get();
                                        ?>
                                        <td>{{$key+1}}</td>                                
                                        <td ><a href="{{route('backend.pincodes.office',$office->id)}}">{{$office->Location}}</a></td>
                                         <td>
                                        <table>
                                        <tr>
                                        <th>STATE</th>
                                        <th>SERVICABLE PINCODE</th>
                                        <th>NON SERVICABLE PINCODE</th>
                                        <th>Action</th>
                                        </tr>
                                        @if(count($office_states))
                                        @foreach($office_states as $office_state)
                                        <?php
                                        $state = \App\State::with('serviceable_pincode')->with('nonserviceable_pincode')->where('id','=',$office_state->State_Code)->first();
                                        ?>
                                        
                                        @if($state)
                                        <tr>
                                        <td>{{$state->name}}</td>
                                       <td>{{count($state->serviceable_pincode)}}</td> 
                                        <td>{{count($state->nonserviceable_pincode)}}</td> 
                                        <td><a href="{{route('backend.pincodes.state',$office_state->State_Code)}}">View Detail</a></td> 
                                        </tr>
                                         @endif
                                        @endforeach 
                                      @endif
                                        </table>                   
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

