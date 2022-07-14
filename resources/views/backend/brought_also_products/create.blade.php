@extends('backend.theme.formtheme')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Product Brought Also Link</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Brought Also Link</li>
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
                    <h3 class="card-title">Add New Brought Also Link</h3>

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
                            <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Group Link Name</label>
                                <input id="name" type="text" class="form-control" name="link_group"
                                        value="{{ old('link_group') }}" required autofocus>
                                    @if ($errors->has('link_group'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('link_group') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Link Product Name</label>
                                <select name="Link_Prodoct_Code[]" class="select2" multiple="multiple"
                                    data-placeholder="Select a Product" style="width: 100%;" required>
                                    <?php
$products = \App\Product::where('go_live', 1)->get();
?>
                                    @foreach($products as $product)
                                    <option value="{{$product->product_code}}">
                                        {{$product->generic_name}}
                                        ({{$product->brand_name}})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Link
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