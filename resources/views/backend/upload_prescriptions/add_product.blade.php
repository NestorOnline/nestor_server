
@extends('backend.theme.formtheme')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Offer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Offer</li>
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
            <h3 class="card-title">Add Product Your Card Detail</h3>

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
                        <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                            <label for="mobile">Mobile</label>
                            <input type="hidden" class="form-control" name="user_id" value="{{$upload_prescription->user->id}}" required autofocus readonly="">
                            <input type="text" class="form-control"value="{{$upload_prescription->user->mobile}}" required autofocus readonly="">
                                                  
                        </div>
                        <div class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">
                            <label for="product_id">Product</label>
                            <select id="product_id" type="text" class="form-control" name="product_id" required autofocus>
                                <option>---Select---</option>
                                @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->brand_name}}</option>
                                @endforeach
                            </select>
                                @if ($errors->has('product_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('product_id') }}</strong>
                                    </span>
                                @endif                        
                        </div>
                        <div class="form-group{{ $errors->has('Qty') ? ' has-error' : '' }}">
                            <label for="Qty">Qty</label>                           
                            <input id="qty" type="text" class="form-control" name="Qty" value="{{ old('Qty') }}" required autofocus>
                                @if ($errors->has('Qty'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('Qty') }}</strong>
                                    </span>
                                @endif                        
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