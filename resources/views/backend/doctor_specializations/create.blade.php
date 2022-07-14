@extends('backend.theme.formtheme')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Doctor Specialization</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Doctor Specialization</li>
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
                    <h3 class="card-title">Add New Doctor Specialization Detail</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                class="fas fa-times"></i></button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!!Form::open(['files'=>true,'class'=>'form-horizontal'])!!}
                            {{csrf_field()}}
                            <div class="form-group{{ $errors->has('Doctor_Type') ? ' has-error' : '' }}">
                                <label for="Doctor_Type" class="col-md-2 control-label">Doctor Type</label>
                                <div class="col-md-10">
                                    <select id="Doctor_Type" name="Doctor_Type" class="form-control" required autofocus>
                                        <option value="">---- Select -----</option>
                                        <option value="1">Allopathic</option>
                                        <option value="2">Ayurvedic</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('Specialization_Type') ? ' has-error' : '' }}">
                                <label for="Specialization_Type" class="col-md-2 control-label">Specialization
                                    Type</label>
                                <div class="col-md-10">
                                    <select id="Specialization_Type" name="Specialization_Type" class="form-control"
                                        required autofocus>
                                        <option value="">---- Select -----</option>
                                        <option value="1">General Physician</option>
                                        <option value="2">Specialities</option>
                                        <option value="3">Common Health Issue</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('Specialization Name') ? ' has-error' : '' }}">
                                <label for="Specialization_Name" class="col-md-2 control-label">Specialization
                                    Name</label>
                                <div class="col-md-10">
                                    <input id="name" type="text" class="form-control" name="Specialization_Name"
                                        value="{{ old('Specialization_Name') }}" required autofocus>

                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('icon_image') ? ' has-error' : '' }}">
                                <label for="icon_image" class="col-md-2 control-label">Product Image (Image Size: 200 ×
                                    200)</label>
                                <div class="col-md-10">
                                    <input id="icon_image" type="file" class="form-control" name="icon_image" required
                                        autofocus>
                                    @if ($errors->has('icon_image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('icon_image') }}</strong>
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