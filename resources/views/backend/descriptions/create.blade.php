

@extends('backend.theme.formtheme')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Description</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Description</li>
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
            <h3 class="card-title">Add New Description Detail</h3>

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
                         <div class="form-group{{ $errors->has('product_code') ? ' has-error' : '' }}">
                            <label for="product_code" class="col-md-2 control-label">Medicine</label>
                            <div class="col-md-10">
                                <select id="product_code" name="product_code" class="form-control" required autofocus>
                                    <option value="">---- Select -----</option>
                                    @foreach($medicines as $key=>$medicine)
                                    <option value="{{$medicine->product_code}}">{{$medicine->generic_name}}</option>
                                     @endforeach
                                </select>                               
                                @if ($errors->has('product_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('product_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                         <div class="form-group{{ $errors->has('description_type_code') ? ' has-error' : '' }}">
                            <label for="description_type_code" class="col-md-2 control-label">Product Description Type</label>
                            <div class="col-md-10">
                                <select id="description_type_code" name="description_type_code" class="form-control" required autofocus>
                                    <option value="">---- Select -----</option>
                                    @foreach($description_types as $key=>$description_type)
                                    <option value="{{$description_type->id}}">{{$description_type->name}}</option>
                                     @endforeach
                                </select>                               
                                @if ($errors->has('description_type_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description_type_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                         
                         <div class="form-group{{ $errors->has('sr_no') ? ' has-error' : '' }}">
                            <label for="sr_no" class="col-md-2 control-label">SR No</label>
                            <div class="col-md-10">
                                <input id="sr_no" type="text" class="form-control" name="sr_no" value="{{ old('sr_no') }}" required autofocus>
                                @if ($errors->has('sr_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sr_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                       
                         <div class="form-group{{ $errors->has('heading') ? ' has-error' : '' }}">
                            <label for="heading" class="col-md-2 control-label">heading</label>
                            <div class="col-md-10">
                                <input id="heading" type="text" class="form-control" name="heading" value="{{ old('heading') }}">
                                @if ($errors->has('heading'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('heading') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-2 control-label">Description</label>
                            <div class="col-md-10">
                                <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" required autofocus>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
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

