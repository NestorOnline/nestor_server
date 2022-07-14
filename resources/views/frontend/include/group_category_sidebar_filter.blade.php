<div class="col-md-2 pr-0 hidden-xs">
    <div class="filter-div">
        <h4 class="border-b pb-3">Filter</h4>
        <input type="hidden" class="group_id" value="{{$single_group->id}}">
        <p>Product Form</p>
        <div class="border-b max-height-filter">

            <div class="filter-bo">
                @foreach($categories as $category)
                <?php
$product_group_categories = \App\ProductGroupCategories::where('groupcategory_id', $single_groupcategory->id)->get();
$product_count = \App\Product::where('go_live',1)->whereIn('products.product_code', $product_group_categories->map(function ($product_group_category) {
    return $product_group_category->Product_Code;
}))->where('category_id', $category->id)->count();
?>
                @if($product_count)
                <label class=" style__filter-label___3Jy6h">
                    <input type="checkbox" class="product_form" value="{{$category->id}}" /><span
                        class="style__filter-checkbox___vU8YA"></span>
                    <span class="style__filter-name___A2BgE">
                        <span>
                            {{$category->name}}
                        </span>
                    </span>
                    <span class="style__filter-count___1B7HQ">
                        {{$product_count}}
                    </span>
                </label>
                @endif
                @endforeach
            </div>

        </div>
        <p>Prescription Required</p>
        <?php
$prescription_required = \App\Product::where('go_live',1)->whereIn('products.product_code', $product_group_categories->map(function ($product_group_category) {
    return $product_group_category->Product_Code;
}))->where('Prescription_Required', 1)->count();
$prescription_not_required = \App\Product::where('go_live',1)->whereIn('products.product_code', $product_group_categories->map(function ($product_group_category) {
    return $product_group_category->Product_Code;
}))->where('Prescription_Required', 0)->count();

?>
        <div class="border-b max-height-filter">
            <div class="filter-bo">
                <label class=" style__filter-label___3Jy6h">
                    <input type="checkbox" class="prescription_required" value="1"><span
                        class="style__filter-checkbox___vU8YA"></span>
                    <span class="style__filter-name___A2BgE">
                        <span>
                            Required
                        </span>
                    </span>
                    <span class="style__filter-count___1B7HQ">{{$prescription_required}}</span>
                </label>

                <label class=" style__filter-label___3Jy6h">
                    <input type="checkbox" class="prescription_required" value="0"><span
                        class="style__filter-checkbox___vU8YA"></span>
                    <span class="style__filter-name___A2BgE">
                        <span>
                            Not Required
                        </span>
                    </span>
                    <span class="style__filter-count___1B7HQ">{{$prescription_not_required}}</span>
                </label>

            </div>

        </div>

        <p>Uses</p>
        <div class="border-b max-height-filter">
            <div class="filter-bo">
                @foreach($uses as $use)
                <?php
                $product_get = \App\Product::where('go_live',1)->whereIn('products.product_code', $product_group_categories->map(function ($product_group_category) {
                    return $product_group_category->Product_Code;
                }))->get();
$productuse_details =\App\ProductuseDetail::whereIn('Product_Code',$product_get->map(function($product_ge){
return $product_ge->product_code;
}))->where('ProductUse_Code',$use->ProductUse_Code)->get();
                ?>
                @if(count($productuse_details))
                <label class=" style__filter-label___3Jy6h">
                    <input type="checkbox" class="product_uses" value="{{$use->id}}"><span
                        class="style__filter-checkbox___vU8YA"></span>
                    <span class="style__filter-name___A2BgE">
                        <span style="text-transform:uppercase">
                            {{$use->ProductUse_Name}}
                        </span>
                    </span>
                    <span class="style__filter-count___1B7HQ">{{count($productuse_details)}}</span>
                </label>
                @endif
                @endforeach
            </div>

        </div>
        <div class="border-b">
            <p>Price</p>
            <div>
                <div class="slider"></div>
                <div class="row">
                    <div class="col-sm-6">
                        <input type="hidden" class="form-control minval" value="0">
                        
                    </div>
                    <div class="col-sm-6">
                        <input type="hidden" class="form-control maxval" value="2000">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>