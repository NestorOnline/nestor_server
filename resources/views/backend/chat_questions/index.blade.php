@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chat Question List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Chat Question List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <a href="{{route('backend.chat_questions.create')}}" class="btn btn-sm btn-info">Add Chat Question</a>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Chat Question List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>question_type</th>
                                        <th>question</th>
                                        <th>dependent_question_id</th>
                                        <th>dependent_option_id</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($chat_questions as $key=>$chat_question)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$chat_question->question_type}}</td>
                                        <td>{{$chat_question->question}}</td>
                                        <td>{{$chat_question->dependent_question_id}}</td>
                                        <td>{{$chat_question->dependent_option_id}}</td>
                                        <td>
                                            <a href="{{route('backend.chat_questions.edit',$chat_question->id)}}"
                                                class="btn btn-sm btn-success">Edit</a>
                                            <a href="{{route('backend.chat_questions.delete',$chat_question->id)}}"
                                                class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>S. No. </th>
                                        <th>question_type</th>
                                        <th>question</th>
                                        <th>dependent_question_id</th>
                                        <th>dependent_option_id</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
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