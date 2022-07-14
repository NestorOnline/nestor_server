

@extends('backend.theme.formtheme')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Product</li>
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
            <h3 class="card-title">Update Product Detail</h3>

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
                                  
                        <div class="form-group{{ $errors->has('generic_name') ? ' has-error' : '' }}">
                            <label for="generic_name" class="col-md-2 control-label">Generic Name</label>

                            <div class="col-md-10">
                                <input id="generic_name" type="text" class="form-control" name="generic_name" value="{{$Product->generic_name}}" required autofocus>

                                @if ($errors->has('generic_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('generic_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('brand_name') ? ' has-error' : '' }}">
                            <label for="brand_name" class="col-md-2 control-label"> Brand Name</label>

                            <div class="col-md-10">
                                <input id="name" type="text" class="form-control" name="brand_name" value="{{$Product->brand_name}}" required autofocus>

                                @if ($errors->has('brand_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('brand_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                       
                       <div class="form-group{{ $errors->has('group_id') ? ' has-error' : '' }}">
                            <label for="group_id" class="col-md-2 control-label">Group Name</label>
                            <div class="col-md-10">
                                <select id="group_id" name="group_id" class="form-control" required autofocus>
                                    <option value="">---- Select -----</option>
                                    @foreach($groups as $key=>$group)
                                    <option value="{{$group->id}}">{{$group->name}}</option>
                                     @endforeach
                                </select>                               
                                @if ($errors->has('group_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('group_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                  <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label for="category_id" class="col-md-2 control-label">Category Name</label>

                            <div class="col-md-10">
                               
                                <select id="category_id" class="form-control" name="category_id" value="{{ old('category_id') }}" required autofocus>
                                    <option value="">--- Selected ---</option>
                                    @foreach($categories as $category)
                                     <option value="{{$category->id}}">{{$category->name}}</option>
                                     @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                       <div class="form-group{{ $errors->has('subcategory_id') ? ' has-error' : '' }}">
                            <label for="subcategory_id" class="col-md-2 control-label">Sub-Category Name</label>
                            <div class="col-md-10">                               
                                <select id="subcategory_id" class="form-control" name="subcategory_id" value="{{ old('subcategory_id') }}" required autofocus>
                                    <option value="">--- Selected ---</option>
                                    @foreach($subcategories as $subcategory)
                                     <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                                     @endforeach
                                </select>
                                @if ($errors->has('subcategory_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('subcategory_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('manufacture') ? ' has-error' : '' }}">
                            <label for="manufacture" class="col-md-2 control-label">Manufacture</label>

                            <div class="col-md-10">
                                <input id="manufacture" type="text" class="form-control" name="manufacture"  value="{{$Product->brand_name}}" required autofocus>

                                @if ($errors->has('manufacture'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('manufacture') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('composition') ? ' has-error' : '' }}">
                            <label for="composition" class="col-md-2 control-label">Composition</label>

                            <div class="col-md-10">
                                <input id="composition" type="text" class="form-control" name="composition"  value="{{$Product->brand_name}}" required autofocus>

                                @if ($errors->has('composition'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('composition') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('storage') ? ' has-error' : '' }}">
                            <label for="storage" class="col-md-2 control-label">Storage</label>

                            <div class="col-md-10">
                                <input id="storage" type="text" class="form-control" name="storage"  value="{{$Product->brand_name}}" required autofocus>

                                @if ($errors->has('storage'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('storage') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('product_code') ? ' has-error' : '' }}">
                            <label for="product_code" class="col-md-2 control-label">Product Code</label>

                            <div class="col-md-10">
                                <input id="product_code" type="text" class="form-control" name="product_code" value="{{$Product->brand_name}}" required autofocus>

                                @if ($errors->has('product_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('product_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('OrderQtyMultipleOf') ? ' has-error' : '' }}">
                            <label for="OrderQtyMultipleOf" class="col-md-2 control-label">Order Qty Multiple Of</label>

                            <div class="col-md-10">
                                <input id="OrderQtyMultipleOf" type="text" class="form-control" name="OrderQtyMultipleOf"  value="{{$Product->brand_name}}" required autofocus>

                                @if ($errors->has('OrderQtyMultipleOf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('OrderQtyMultipleOf') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                   
                        <div class="form-group{{ $errors->has('package_id') ? ' has-error' : '' }}">
                            <label for="package_id" class="col-md-2 control-label">Package Name</label>
                            <div class="col-md-10">                               
                                <select id="package_id" class="form-control" name="package_id" required autofocus>
                                    <option value="">--- Selected ---</option>
                                    @foreach($packages as $package)
                                    @if($package->id==$Product->id)
                                    <option value="{{$package->id}}" selected="selected">{{$package->name}}</option>
                                    @else
                                    <option value="{{$package->id}}">{{$package->name}}</option>
                                    @endif
                                     
                                     
                                     @endforeach
                                </select>
                                @if ($errors->has('package_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('package_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                       
                        
                        <div class="form-group{{ $errors->has('mrp_amount') ? ' has-error' : '' }}">
                            <label for="mrp_amount" class="col-md-2 control-label">MRP Price (Rs.)</label>

                            <div class="col-md-10">
                                <input id="mrp_amount" type="text" class="form-control" name="mrp_amount"  value="{{$Product->mrp_amount}}" required autofocus>

                                @if ($errors->has('mrp_amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mrp_amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('offer') ? ' has-error' : '' }}">
                            <label for="offer" class="col-md-2 control-label">Offer %</label>

                            <div class="col-md-10">
                                <input id="offer" type="text" class="form-control" name="offer"  value="{{$Product->offer}}" required autofocus>

                                @if ($errors->has('offer'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('offer') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('actual_amount') ? ' has-error' : '' }}">
                            <label for="actual_amount" class="col-md-2 control-label">Actual Price (Rs.)</label>

                            <div class="col-md-10">
                                <input id="actual_amount" type="text" class="form-control" name="actual_amount"  value="{{$Product->actual_amount}}" required autofocus>

                                @if ($errors->has('actual_amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('actual_amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="image" class="col-md-2 control-label">Product Image</label>

                            <div class="col-md-10">
                                <input id="image" type="file" class="form-control" name="image"  required autofocus>

                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
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

