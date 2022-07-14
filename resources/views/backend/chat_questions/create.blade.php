@extends('backend.theme.formtheme')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Chat Question</h1>
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
                    <h3 class="card-title">Add Chat Question Detail</h3>

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
                            <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                                <label for="question" class="col-md-2 control-label">Question</label>
                                <div class="col-md-10">
                                    <input id="name" type="text" class="form-control" name="question"
                                        value="{{ old('question') }}" required autofocus>
                                    @if ($errors->has('question'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('question') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('dependent_question_id') ? ' has-error' : '' }}">
                                <label for="dependent_question_id" class="col-md-2 control-label">Depend on</label>
                                <div class="col-md-10">
                                    <select id="dependent_question_id" name="dependent_question_id"
                                        class="form-control">
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
                            <div class="form-group{{ $errors->has('dependent_option_id') ? ' has-error' : '' }}">
                                <label for="dependent_option_id" class="col-md-2 control-label">Depand on option</label>
                                <div class="col-md-10">
                                    <select id="dependent_option_id" name="dependent_option_id" class="form-control">
                                        <option value="">---- Select -----</option>
                                        @foreach($question_options as $key=>$question_option)
                                        <option value="{{$question_option->id}}">{{$question_option->option}}</option>
                                        @endforeach
                                    </select>
                                    <!-- @if ($errors->has('dependent_option_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dependent_option_id') }}</strong>
                                    </span>
                                    @endif -->
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('question_type') ? ' has-error' : '' }}">
                                <label for="question_type" class="col-md-2 control-label">Name</label>
                                <div class="col-md-10">
                                    <select id="question_type" name="question_type" class="form-control" required
                                        autofocus>
                                        <option value="">---- Select -----</option>
                                        <option value="single">single</option>
                                        <option value="dependent">dependent</option>
                                    </select>
                                    @if ($errors->has('question_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('question_type') }}</strong>
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