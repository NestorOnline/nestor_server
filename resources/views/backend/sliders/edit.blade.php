@extends('backend.theme.formtheme')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Slider</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Update Slider</li>
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
                    <h3 class="card-title">Update Slider Detail</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-minus"></i></button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                class="fas fa-times"></i></button>
                    </div>
                </div>
                <?php
$groupsOp = '';
$groupcategoriesOp = '';

foreach ($groups as $group) {

    if ($group->id == $slider->group_id) {
        $groupsOp = $groupsOp . '<option value="' . $group->id . '" selected="selected">' . $group->name . '</option>';

    } else {
        $groupsOp = $groupsOp . '<option value="' . $group->id . '">' . $group->name . '</option>';
    }
    foreach ($group->groupcategories as $groupcategory) {
        if ($groupcategory->id == $slider->groupcategory_id) {
            $groupcategoriesOp = $groupcategoriesOp . '<option value="' . $groupcategory->id . '" class="' . $group->id . '" selected="selected">' . $groupcategory->name . '</option>';

        } else {
            $groupcategoriesOp = $groupcategoriesOp . '<option value="' . $groupcategory->id . '" class="' . $group->id . '">' . $groupcategory->name . '</option>';

        }

    }
}
?>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!!Form::open(['files'=>true,'class'=>'form-horizontal'])!!}
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('slider_type') ? ' has-error' : '' }}">
                                <label for="slider_type" class="col-md-2 control-label">Name</label>
                                <div class="col-md-10">
                                    <select id="slider_type" name="slider_type" class="form-control"
                                        onchange="ShowDiv(this.value)" required autofocus>
                                        <option value="">---- Select -----</option>
                                        <option value="home_page_main"
                                            {{"home_page_main"==$slider->slider_type?'selected':''}}>Home Page Main
                                        </option>
                                        <option value="home_page_second_top"
                                            {{"home_page_second_top"==$slider->slider_type?'selected':''}}>Home Page
                                            Second Top</option>
                                        <option value="home_page_similar"
                                            {{"home_page_similar"==$slider->slider_type?'selected':''}}>Home Page
                                            Similar</option>
                                        <option value="home_page_trending"
                                            {{"home_page_trending"==$slider->slider_type?'selected':''}}>Home Page
                                            Trending</option>
                                        <option value="group_page" {{"group_page"==$slider->slider_type?'selected':''}}>
                                            Group Page</option>
                                        <option value="group_category_page"
                                            {{"group_category_page"==$slider->slider_type?'selected':''}}>Group Category
                                            Page</option>
                                    </select>
                                    @if ($errors->has('slider_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('slider_type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" id="show_group_id" style="display: none">
                                <label class="col-md-2 control-label">Group Name</label>
                                <div class="col-md-10">
                                    <select id="group_id" name="group_id" class="form-control" required autofocus>
                                        {!!$groupsOp!!}
                                    </select>

                                </div>
                            </div>

                            <div class="form-group" id="show_groupcategory_id" style="display: none">
                                <label class="col-md-2 control-label">Group Category Name</label>
                                <div class="col-md-10">
                                    <select id="groupcategory_id" class="form-control" name="groupcategory_id" required
                                        autofocus>
                                        {!!$groupcategoriesOp!!}
                                    </select>

                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="image" class="col-md-2 control-label">Medicine Image</label>

                                <div class="col-md-10">
                                    <input id="image" type="file" class="form-control" name="image" autofocus>

                                    @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="col-md-2 control-label">Title</label>
                                <div class="col-md-10">
                                    <input id="title" type="text" class="form-control" name="title"
                                        value="{{$slider->title}}" required autofocus>
                                    @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('url_link') ? ' has-error' : '' }}">
                                <label for="url_link" class="col-md-2 control-label">URL</label>
                                <div class="col-md-10">
                                    <input id="url_link" type="text" class="form-control" name="url_link"
                                        value="{{$slider->url_link}}" required autofocus>
                                    @if ($errors->has('url_link'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('url_link') }}</strong>
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
<script>
function ShowDiv(val) {
    switch (val) {
        case 'group_page': {
            document.getElementById('show_group_id').style.display = "block";
            document.getElementById('show_groupcategory_id').style.display = "none";
            break;
        }
        case 'group_category_page': {
            document.getElementById('show_group_id').style.display = "block";
            document.getElementById('show_groupcategory_id').style.display = "block";
            break;
        }
    }
}
</script>