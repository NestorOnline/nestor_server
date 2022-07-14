@extends('backend.theme.formtheme')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Slider</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add App Slider</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <?php
$groupsOp = '';
$groupcategoriesOp = '';

foreach ($groups as $group) {
    $groupsOp = $groupsOp . '<option value="' . $group->id . '">' . $group->name . '</option>';
    foreach ($group->groupcategories as $groupcategory) {
        $groupcategoriesOp = $groupcategoriesOp . '<option value="' . $groupcategory->id . '" class="' . $group->id . '">' . $groupcategory->name . '</option>';
    }
}
?>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Add App Slider </h3>

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
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('slider_type') ? ' has-error' : '' }}">
                                <label for="slider_type" class="col-md-10 control-label">Slider Type</label>
                                <div class="col-md-10">
                                    <select id="slider_type" name="slider_type" class="form-control"
                                        onchange="ShowDiv(this.value)" required autofocus>
                                        <option value="">---- Select -----</option>
                                        <option value="brand_page">Brand Page</option>
                                        <option value="group_page">Group Page</option>
                                        <option value="group_category_page">Group Category Page</option>
                                        <option value="product_page">Product Page</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="show_group_id" style="display: none">
                                <label class="col-md-10 control-label">Group Name</label>
                                <div class="col-md-10">
                                    <select id="group_id" name="group_id" class="form-control" autofocus>
                                        <option value="">---- Select -----</option>
                                        {!!$groupsOp!!}
                                    </select>

                                </div>
                            </div>
                            <div class="form-group" id="show_groupcategory_id" style="display: none">
                                <label class="col-md-10 control-label">Group Category Name</label>
                                <div class="col-md-10">
                                    <select id="groupcategory_id" class="form-control" name="groupcategory_id"
                                        autofocus>
                                        <option value="">---- Select -----</option>
                                        {!!$groupcategoriesOp!!}
                                    </select>

                                </div>
                            </div>


                            <div class="form-group" id="show_product_page_id" style="display: none">
                                <label class="col-md-10 control-label">Group Category Name</label>
                                <div class="col-md-10">
                                    <select id="product_id" class="form-control" name="product_id" autofocus>
                                        <option value="">---- Select -----</option>
                                        <?php
$products = \App\Product::all();
?>
                                        @foreach($products as $product)
                                        <option value="{{$product->id}}">
                                            {{$product->generic_name}} ({{$product->brand_name}})</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>


                            <div class="form-group" id="show_brand_page_id" style="display: none">
                                <label class="col-md-10 control-label">Band Name</label>
                                <div class="col-md-10">
                                    <select id="brand_id" class="form-control" name="brand_id" autofocus>
                                        <option value="">Select</option>
                                        <option value="1">Nestor</option>
                                        <option value="2">Steriheal</option>
                                        <option value="3">NECTARINE</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('mobile_image') ? ' has-error' : '' }}">
                                <label for="mobile_image" class="col-md-10 control-label"> Image For Mobile
                                    Slider</label>
                                <div class="col-md-10">
                                    <input id="mobile_image" type="file" class="form-control" name="mobile_image"
                                        required autofocus>
                                    @if ($errors->has('mobile_image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile_image') }}</strong>
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
            document.getElementById('show_brand_page_id').style.display = "none";
            document.getElementById('show_product_page_id').style.display = "none";
            break;
        }
        case 'group_category_page': {
            document.getElementById('show_group_id').style.display = "block";
            document.getElementById('show_groupcategory_id').style.display = "block";
            document.getElementById('show_brand_page_id').style.display = "none";
            document.getElementById('show_product_page_id').style.display = "none";
            break;
        }
        case 'brand_page': {
            document.getElementById('show_group_id').style.display = "none";
            document.getElementById('show_groupcategory_id').style.display = "none";
            document.getElementById('show_product_page_id').style.display = "none";
            document.getElementById('show_brand_page_id').style.display = "block";
            break;
        }
        case 'product_page': {
            document.getElementById('show_group_id').style.display = "none";
            document.getElementById('show_groupcategory_id').style.display = "none";
            document.getElementById('show_brand_page_id').style.display = "none";
            document.getElementById('show_product_page_id').style.display = "block";
            break;
        }
    }
}
</script>