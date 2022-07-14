
@extends('backend.theme.formtheme')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"> Description List</div>
                <a href="{{route('backend.descriptions.create')}}" class="btn btn-sm btn-info">Add Description</a>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S. No. </th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Valid Date</th>
                                <th>Eligibility</th>
                                <th>How To Get</th>
                                <th>Cancellation Condition</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($descriptions as $key=>$description)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><img src="{{asset($description->image)}}" style="width: 150px; height: 75px"></td>
                                <td>{{$description->name}}</td>
                                <td>{{$description->description}}</td>
                                <td>
                                    @if($description->valid_till)
                                    {{$description->valid_till->format('d-M-Y')}}
                                    @endif
                                </td>
                                <td>{{$description->eligibility}}</td>
                                <td>{{$description->how_you_get}}</td>
                                <td>{{$description->cancellation_condition}}</td>                               
                                <td>
                                 <a href="{{route('backend.descriptions.edit',$description->id)}}" class="btn btn-sm btn-success">Edit</a>
                                 <a href="{{route('backend.descriptions.delete',$description->id)}}" class="btn btn-sm btn-danger">Delete</a>
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
@endsection
