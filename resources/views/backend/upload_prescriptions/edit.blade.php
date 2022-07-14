
@extends('backend.theme.formtheme')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Offer Detail</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Offer Detail</li>
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
            <h3 class="card-title"> Update Offer Detail</h3>

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
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Name</label>
                           
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                        
                        </div>
                         <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" >Description</label>
                            
                                <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" required autofocus>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            
                        </div>
                         <div class="form-group{{ $errors->has('valid_till') ? ' has-error' : '' }}">
                            <label for="valid_till">Valid Date</label>
                            <div class="col-md-3">
                                <input id="valid_till" type="date" class="form-control" name="valid_till" value="{{ old('valid_till') }}" required autofocus>
                                @if ($errors->has('valid_till'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valid_till') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-9"></div>
                        </div>
                         <div class="form-group{{ $errors->has('eligibility') ? ' has-error' : '' }}">
                            <label for="eligibility">Eligibility</label>
                       
                                <input id="eligibility" class="form-control"  type="text" name="eligibility" value="{{ old('eligibility') }}" required autofocus>
                                @if ($errors->has('eligibility'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('eligibility') }}</strong>
                                    </span>
                                @endif
                           
                        </div>
                         <div class="form-group{{ $errors->has('how_you_get') ? ' has-error' : '' }}">
                            <label for="how_you_get">How To get It</label>
                      
                                <input id="how_you_get" type="text" class="form-control" name="how_you_get" value="{{ old('how_you_get') }}" required autofocus>
                                @if ($errors->has('how_you_get'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('how_you_get') }}</strong>
                                    </span>
                                @endif
                          
                        </div>
                         <div class="form-group{{ $errors->has('cancellation_condition') ? ' has-error' : '' }}">
                            <label for="cancellation_condition">Cancellation Condition</label>                         
                                <input id="cancellation_condition" type="text" class="form-control" name="cancellation_condition" value="{{ old('cancellation_condition') }}" required autofocus>
                                @if ($errors->has('cancellation_condition'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cancellation_condition') }}</strong>
                                    </span>
                                @endif                          
                        </div>
                        
                         <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="image">Image</label>
                        
                                <input id="image" type="file" class="form-control" name="image" value="{{ old('image') }}" required autofocus>
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                          
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