@extends('backend.theme.formtheme')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Order Setting</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Order Setting</li>
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
            <h3 class="card-title">Add New Order Setting Detail</h3>

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
                        {{csrf_field()}}
                        '','MinimumOrderValueForCustomer' 
                        <div class="form-group{{ $errors->has('MinimumOrderValueForChemist') ? ' has-error' : '' }}">
                            <label for="MinimumOrderValueForChemist" class="col-md-2 control-label">Minimum Order Value</label>
                            <div class="col-md-10">
                                <input id="MinimumOrderValueForChemist" type="text" class="form-control" name="MinimumOrderValueForChemist" value="{{ old('MinimumOrderValueForChemist') }}" required autofocus>
                                @if ($errors->has('MinimumOrderValueForChemist'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('MinimumOrderValueForChemist') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('MinimumOrderValueForCustomer') ? ' has-error' : '' }}">
                            <label for="MinimumOrderValueForCustomer" class="col-md-2 control-label">Minimum Order Value</label>
                            <div class="col-md-10">
                                <input id="MinimumOrderValueForCustomer" type="text" class="form-control" name="MinimumOrderValueForCustomer" value="{{ old('MinimumOrderValueForCustomer') }}" required autofocus>
                                @if ($errors->has('MinimumOrderValueForCustomer'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('MinimumOrderValueForCustomer') }}</strong>
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
