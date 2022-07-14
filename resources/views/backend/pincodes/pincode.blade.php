@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Group List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pincode List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <a href="{{route('backend.groups.create')}}" class="btn btn-sm btn-info">Add Pincode</a>    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">          
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pincode List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>OFFICE</th>
                                        <th>STATE</th>
                                        <th>SERVICABLE PINCODE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($offices as $key=>$office)
                                    <?php
                                     $pincodes = DB::table('pincodes')
                ->join('office_states', function ($join) use($office) {
                    $join->on('pincodes.state_id', '=', 'office_states.State_Code')
                    ->where('office_states.Office_Code', '=', $office->Office_Code);
                })->get();
                                    ?>
                                    <tr>
                                        <td>{{$key+1}}</td>                                
                                        <td>
                                        <button class="btn btn-xs btn-info" data-toggle="modal" data-target="#myModal{{$key}}">{{$office->Location}}</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal{{$key}}" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">{{$office->Location}}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
           <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>City</th>
                                        <th>PINCODE</th>
                                        <th>SERVICABLE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pincodes as $abc=>$pincode)
                                    <tr>
                                        <td>{{$abc+1}}</td>
                                        <td>
                                        <?php
                                        $city=\App\City::find($pincode->city_id);
                                        ?>
                                        @if($city)
                                        {{$city->name}}
                                        @endif
                                        </td>  
                                        <td>{{$pincode->pincode}}</td> 
                                        <td>Yes</td>                              
                                    </tr>
                                    @endforeach
                                </tbody>
                               
                            </table>
        </div>
        
      </div>
    </div>
  </div>
                                        </td>
                                        <td>{{$office->State_Name}}</td>                             
                                        <td></td>
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

