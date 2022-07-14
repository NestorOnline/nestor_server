@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container-fluid">
        <div>
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <ul class="items">
                        <li class="home"> <a href="" title="Go to Home"> Home </a> </li>
                        <li class="home">Browse by A-Z</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div>
            <div>
                <ul class="list-unstyled alph-filter">
                    <li><a href="javascript:void(0)" class="a">A</a></li>
                    <li><a href="javascript:void(0)" class="b">B</a></li>
                    <li><a href="javascript:void(0)" class="c">C</a></li>
                    <li><a href="javascript:void(0)" class="d">D</a></li>
                    <li><a href="javascript:void(0)" class="e">E</a></li>
                    <li><a href="javascript:void(0)" class="f">F</a></li>
                    <li><a href="javascript:void(0)" class="g">G</a></li>
                    <li><a href="javascript:void(0)" class="h">H</a></li>
                    <li><a href="javascript:void(0)" class="i">I</a></li>
                    <li><a href="javascript:void(0)" class="j">J</a></li>
                    <li><a href="javascript:void(0)" class="k">K</a></li>
                    <li><a href="javascript:void(0)" class="l">L</a></li>
                    <li><a href="javascript:void(0)" class="m">M</a></li>
                    <li><a href="javascript:void(0)" class="n">N</a></li>
                    <li><a href="javascript:void(0)" class="o">O</a></li>
                    <li><a href="javascript:void(0)" class="p">P</a></li>
                    <li><a href="javascript:void(0)" class="q">Q</a></li>
                    <li><a href="javascript:void(0)" class="r">R</a></li>
                    <li><a href="javascript:void(0)" class="s">S</a></li>
                    <li><a href="javascript:void(0)" class="t">T</a></li>
                    <li><a href="javascript:void(0)" class="u">U</a></li>
                    <li><a href="javascript:void(0)" class="v">V</a></li>
                    <li><a href="javascript:void(0)" class="w">W</a></li>
                    <li><a href="javascript:void(0)" class="x">X</a></li>
                    <li><a href="javascript:void(0)" class="y">Y</a></li>
                    <li><a href="javascript:void(0)" class="z">Z</a></li>
                    <li><a href="javascript:void(0)" class="all">ALL</a></li>
                </ul>
            </div>
            <div>
                <div>
                    <div class="prescriptions_products">
                    @foreach(range('A', 'Z') as $alphabet)
                    <?php
                            $products = \App\Product::where('brand_name','LIKE',$alphabet.'%')->get();
                            ?>
                             @if(count($products))
                        <div class="drug-list-col ln-{{strtolower($alphabet)}}">
                        
                            <h3>{{$alphabet}}</h3>
                            
                            <ul class="alpha-drug-list list-unstyled">
                               
                                    @foreach($products as $product)
                                        <li style="margin-top: 10px"> <a href="{{route('frontend.product_detail',[$product->group->url_name,$product->group_category->url_name,$product->url_name])}}"> {{$product->brand_name}} </a> </li>
                                        @endforeach
                                        
                            </ul>
                        </div>
                        @endif
                        @endforeach
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontend.include.footer')