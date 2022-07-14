<div class="col-md-2 pr-0">
    <div class="filter-div">
        <h4 class="border-b pb-3">Filter</h4>
        <input type="hidden" class="group_id" value="{{$single_group->id}}">
        <p>Product Form</p>
        <div class="border-b max-height-filter">

            <div class="filter-bo">
                @foreach($categories as $category)
                <?php
$product_count = \App\Product::where('go_live',1)->where('group_id', $single_group->id)->where('category_id', $category->id)->count();
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
                    <span class="style__filter-count___1B7HQ">9</span>
                </label>
                
                <label class=" style__filter-label___3Jy6h">
                    <input type="checkbox" class="prescription_required" value="0"><span
                        class="style__filter-checkbox___vU8YA"></span>
                    <span class="style__filter-name___A2BgE">
                        <span>
                            Not Required
                        </span>
                    </span>
                    <span class="style__filter-count___1B7HQ">172</span>
                </label>

            </div>
        </div>

        <p>Uses</p>
        <div class="border-b max-height-filter">
            <div class="filter-bo">
                @foreach($uses as $use)
                @if(count($use->products))
                <label class=" style__filter-label___3Jy6h">
                    <input type="checkbox" class="product_uses" value="{{$use->id}}"><span
                        class="style__filter-checkbox___vU8YA"></span>
                    <span class="style__filter-name___A2BgE">
                        <span style="text-transform:uppercase">
                            {{$use->ProductUse_Name}}
                        </span>
                    </span>
                    <span class="style__filter-count___1B7HQ"></span>
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