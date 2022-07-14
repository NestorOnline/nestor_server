@extends('backend.theme.formtheme')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Chat Question Option</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Chat Question</li>
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
                    <h3 class="card-title">Add Chat Question Option Detail</h3>

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
                            <div class="form-group{{ $errors->has('question_id') ? ' has-error' : '' }}">
                                <label for="question_id" class="col-md-2 control-label">Question</label>
                                <div class="col-md-10">
                                    <select id="question_id" name="question_id" class="form-control">
                                        <option value="">---- Select -----</option>
                                        @foreach($chat_questions as $key=>$chat_question)
                                        <option value="{{$chat_question->id}}">{{$chat_question->question}}</option>
                                        @endforeach
                                    </select>
                                    <!-- @if ($errors->has('dependent_question_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dependent_question_id') }}</strong>
                                    </span>
                                    @endif -->
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('option') ? ' has-error' : '' }}">
                                <label for="option" class="col-md-2 control-label">option</label>
                                <div class="col-md-10">
                                    <input id="name" type="text" class="form-control" name="option"
                                        value="{{ old('option') }}" required autofocus>
                                    @if ($errors->has('option'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('option') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('option_sn') ? ' has-error' : '' }}">
                                <label for="option" class="col-md-2 control-label">option_sn</label>
                                <div class="col-md-10">
                                    <input id="option_sn" type="number" class="form-control" name="option_sn"
                                        value="{{ old('option') }}" required autofocus>
                                    @if ($errors->has('option_sn'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('option_sn') }}</strong>
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