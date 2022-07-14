<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Product Image</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="{{asset('backend/plugins/ekko-lightbox/ekko-lightbox.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('backend/dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  @include('backend.theme.header')
  <!-- /.navbar -->


@include('backend.theme.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Image</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Images</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content" style="height: 100%">
      <div class="container-fluid" style="height: 100%">
        <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <div class="card-title">
                 Product Image
                </div>
              </div>
              <div class="card-body">
                <div>
                  <div class="btn-group w-100 mb-2">
                    <a class="btn btn-info active" href="javascript:void(0)" data-filter="all"> All items </a>
                    @foreach($groups as $group)
                    <a class="btn btn-info" href="javascript:void(0)" data-filter="{{$group->id}}">{{$group->name}} </a>
                    @endforeach
                  </div>
                  <div class="mb-2">
                    <a class="btn btn-secondary" href="javascript:void(0)" data-shuffle> Shuffle items </a>
                    <div class="float-right">
                      <select class="custom-select" style="width: auto;" data-sortOrder>
                        <option value="index"> Sort by Position </option>
                        <option value="sortData"> Sort by Custom Data </option>
                      </select>
                      <div class="btn-group">
                        <a class="btn btn-default" href="javascript:void(0)" data-sortAsc> Ascending </a>
                        <a class="btn btn-default" href="javascript:void(0)" data-sortDesc> Descending </a>
                      </div>
                    </div>
                  </div>
                </div>
                <div>
                  @foreach($products as $key=>$product)
                  <?php
                 $reminder = fmod($key, 4);
                  ?>
                  @if($reminder > 0.5)
                  
                  @else
                    <div class="filter-container p-0 row">
                  @endif
                  <div class="filtr-item col-sm-3" data-category="{{$product->group_id}}" data-sort="red sample">
                  <?php
                                    $product_image = \App\Productimage::where('Product_Code','=',$product->product_code)->first();
                   ?>
                    @if($product_image)
                                    @if(!$product_image->PhotoFile_Name==NULL)
                                    <a href="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}" data-toggle="lightbox" data-title="{{$product->brand_name}}">
                        <img src="{{asset('/product_image/images/'.$product_image->provided_by.'/'.$product_image->PhotoFile_Name)}}" class="img-fluid mb-2 img-responsive" alt="red sample"/>
                      </a>
                                    @else
                                    <a href="{{asset('NoImage.webp')}}" data-toggle="lightbox" data-title="sample 3 - red">
                        <img src="{{asset('NoImage.webp')}}" class="img-fluid mb-2" alt="red sample"/>
                      </a>
                                    @endif
                                    @else
                                    <a href="{{asset('NoImage.webp')}}" data-toggle="lightbox" data-title="sample 3 - red">
                        <img src="{{asset('NoImage.webp')}}" class="img-fluid mb-2" alt="red sample"/>
                      </a>
                                    @endif
                                    <p  style="display: -webkit-box;
-webkit-line-clamp: 2;
-webkit-box-orient: vertical;
overflow: hidden;
text-overflow: ellipsis;">{{$product->brand_name}}</p>
                      <?php
                      $chemist_product_price = \App\Productprice::where('Product_Code','=',$product->product_code)->where('ProductPriceType_Code','=','7')->first();
                      $mrp_product_price = \App\Productprice::where('Product_Code','=',$product->product_code)->where('ProductPriceType_Code','=','8')->first(); 
                      $product_price = \App\Productprice::where('Product_Code','=',$product->product_code)->where('ProductPriceType_Code','=','9')->first(); 
                      ?>
                      <p>Product Code-{{$product->Product_ID}}
                      <br>
                          MRP.-
                      @if($mrp_product_price)
                      {{$mrp_product_price->Price}}
                      @endif
                      <br>
                          Chemist Rate.-
                      @if($chemist_product_price)
                      {{$chemist_product_price->Price}}
                      @endif
                      <br>
                          Customer Rate.-
                      @if($product_price)
                      {{$product_price->Price}}
                      @endif
                      </p>
                  </div>
                  
                    @if($reminder > 2.5)
                  </div>
                  @else
                  
                  @endif
                 
                
                  @endforeach
                    
                 
                </div>

              </div>
            </div>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('backend.theme.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- jQuery UI -->
<script src="{{asset('backend/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Ekko Lightbox -->
<script src="{{asset('backend/plugins/ekko-lightbox/ekko-lightbox.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('backend/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('backend/dist/js/demo.js')}}"></script>
<!-- Filterizr-->
<script src="{{asset('backend/plugins/filterizr/jquery.filterizr.min.js')}}"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>
</body>
</html>
