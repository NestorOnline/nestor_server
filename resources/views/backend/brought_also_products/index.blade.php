@extends('backend.theme.indextheme')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Link Group</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Product Link Group List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('flash')
    <a href="{{route('backend.brought_also_products.create')}}" class="btn btn-sm btn-info">Add Product Link Group</a>    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">          
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product Link Group List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Group Name</th>
                                        <th>Product Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($brought_also_group_links as $key=>$brought_also_group_link)

                                    <?php
$broughtalsoproducts = \App\Broughtalsoproduct::where('link_group',$brought_also_group_link->link_group)->get();
                                    ?>

                                    @if(count($broughtalsoproducts))
                                    @foreach($broughtalsoproducts as $broughtalsoproduct)
                                    <tr>                               
                                        <td>{{$brought_also_group_link->link_group}}</td>
                                        <td>
                                            @if($broughtalsoproduct->product)
                                            {{$broughtalsoproduct->product->generic_name}}
                                            ({{$broughtalsoproduct->product->brand_name}})
                                            @endif
                                        </td>                             
                                        <td>
                                            <a href="{{route('backend.brought_also_products.delete',$broughtalsoproduct->id)}}" class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
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

