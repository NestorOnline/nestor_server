@extends('backend.theme.formtheme')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Category</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Add New Category Detail</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                     {!!Form::open(['files'=>true,'class'=>'form-horizontal'])!!} 
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('group_id') ? ' has-error' : '' }}">
                            <label for="group_id" class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <select id="group_id" name="group_id" class="form-control" required autofocus>
                                    <option value="">---- Select -----</option>
                                    @foreach($groups as $key=>$group)
                                    @if($group->id==$groupcategory->group_id)
                                    <option value="{{$group->id}}" selected="selected">{{$group->name}}</option>
                                    @else
                                     <option value="{{$group->id}}">{{$group->name}}</option>
                                    @endif                                   
                                    @endforeach
                                </select>                               
                                @if ($errors->has('group_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('group_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                      
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 control-label">Name</label>
                            <div class="col-md-10">
                                <input id="name" type="text" class="form-control" name="name" value="{{$groupcategory->name}}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('url_name') ? ' has-error' : '' }}">
                            <label for="url_name" class="col-md-2 control-label">URL Name</label>
                            <div class="col-md-10">
                                <input id="url_name" type="text" class="form-control" name="url_name" value="{{$groupcategory->url_name}}" required autofocus>
                                @if ($errors->has('url_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('url_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                       
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="image" class="col-md-2 control-label">Medicine Image</label>

                            <div class="col-md-10">
                                <input id="image" type="file" class="form-control" name="image"  required autofocus>

                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
 

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>                               
                            </div>
                        </div>
                  {!!Form::close()!!} 
              </div>
              <!-- /.col -->
             
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- /.row -->
          </div>
         
        </div>
      
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection

