<!-- The Modal -->
<div class="modal" id="notify_model">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Notify Me</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                {!!Form::open(['route'=>['backend.stock_notifications.create'],'files'=>true,'class'=>'form-horizontal'])!!}
                {{csrf_field()}}
                <input type="hidden" class="product_code_value" name="Product_Code">
                <label for=""><small><strong>Email</strong></small></label>
                <div class="input-group mb-5">
                    <div class="input-group-prepend">
                        <span class="basic-addon1"></span>
                        <input name="email" type="email" id='Email' class="form-control"
                            placeholder="Enter Your Email To Get Notification" aria-label="Username"
                            aria-describedby="basic-addon1" required>
                    </div>
                </div>
                <div class="input-group mb-5">
                    <button class="btn btn-info" type="submit">Submit</button>
                </div>
            </div>
                 {!!Form::close()!!}

        </div>
    </div>
</div>
<footer class="mt-4">
    <!-- <div class="side-link">
                <ul class="list-unstyled">
                    <li>
                        <span><a href="">Medicine</a></span>
                        <img src="img/icons/medicine.png" alt="" class="img-color-1">
                    </li>
                    <li>
                        <span><a href="">Wellness</a></span>
                        <img src="img/icons/wellness.png" alt="" class="img-color-2">
                    </li>
                    <li>
                        <span><a href="">Diagnostic</a></span>
                        <img src="img/icons/diagnostic.png" alt="" class="img-color-3">
                    </li>
                    <li>
                        <span><a href="">Health Corner</a></span>
                        <img src="img/icons/health.png" alt="" class="img-color-4">
                    </li>
                </ul>
            </div> -->
    <div class="container">
        <div class="row footer-container">

            <!--
                  <div class=" footer-logo"> <img src="img/icons/nestor.png" class="w-50" > </div>
                  -->
            <!-- <div class="col-md-3">
                      <div class=" footer-logo"> <img src="{{asset('img/logo.png')}}" style="height: 100px; width: 75px" > </div>
                        <div class="footer-txt pt-3"> Nestor Pharmaceuticals Ltd is a rapidly growing global enterprise backed by more than four decades of expertise in manufacture and marketing of a wide array of ethical allopathic branded and generic formulations. </div>
                    </div> -->
            <ul class="col-md-3 list-unstyled">
                <li>
                    <h2>Company</h2>
                </li>
                <li><a href="{{route('about_us')}}">ABOUT US</a></li>
                <li><a href="{{route('competitive_strength')}}">COMPETITIVE STRENGTH</a></li>
                <li><a href="{{route('research_development')}}">RESEARCH AND DEVELOPMENT</a></li>
                <li><a href="{{route('business_operations')}}">BUSINESS OPERATIONS</a></li>
                <li><a href="{{route('terms_conditions')}}">TERMS AND CONDITIONS</a></li>
                <li><a href="javascript:void(0);">CANCELLATION, RETURN AND REFUND POLICY </a></li>

            </ul>
            <ul class="col-md-3 list-unstyled">
                <li>
                    <h2>SHOPPING</h2>
                </li>
                <li><a href="{{route('prescriptions')}}">BROWSE BY A-Z</a></li>
                <li><a href="javascript:void(0);">HEALTH ARTICLES</a></li>
                <li><a href="javascript:void(0);">OFFERS/COUPONS</a></li>
                <li><a href="javascript:void(0);">FAQS</a></li>
            </ul>
            <ul class="col-md-3 list-unstyled">
                <li>
                    <h2>Category</h2>
                </li>
                <?php
$main_groups = \App\Group::orderBy('id','DESC')->get();
?>
                @foreach($main_groups as $key=>$main_group)

                <li style="text-transform: uppercase;"><a
                        href="{{route('frontend.group_page',$main_group->url_name)}}">{{$main_group->name}}</a>
                </li>
                @endforeach
            </ul>
            <ul class="col-md-3 list-unstyled">
                <li>
                    <h2>Download App</h2>
                </li>
                <li><a href="https://play.google.com/store/apps/details?id=com.nestorpharma.b2b_app"><img
                            src="{{asset('img/play.png')}}" alt="Download nestor App for Android from Play Store"
                            title="Download nestor App for Android from Play Store"></a></li>
                <li><a href="javascript:void(0)"><img src="{{asset('img/app.png')}}"
                            alt="Download nestor App for iOs from App Store"
                            title="Download nestor App for iOs from App Store"></a></li>
                <li><a href="javascript:void(0)"><img src="{{asset('img/fb.png')}}" alt=""></a></li>
            </ul>
        </div>
    </div>
</footer>
<small class="copyright">
    <div class="copyblock container">
        <div class="copy-txt">Copyright © 2021 www.nestoronline.in</div>
    </div>
</small>

<div class="modal fade" id="notify_me_alert" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Notification Alert</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group mb-5">
                            <div>
                                <span class="basic-addon1"></span>
                                <input type="text" class="form-control" id="email"
                                    placeholder="Enter Your Email Address" aria-label="Username"
                                    aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- <div class="modal fade" id="pop_offer" role="dialog">
    <div class="modal-dialog modal-lg">
    
     
      <div class="modal-content">
       
        <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" style="color: black">&times;</button>
          <div class="row">
            <div class="col-sm-4 col-md-4 col-xs-12" style="padding: 0em 0em;">
            <a href="{{route('frontend.book_an_appointment')}}">
             <img src="{{asset('pop_111.jpeg')}}" width="250" height="364" style="border: black 2px solid;">
            </a>
            </div>
            <div class="col-sm-4 col-md-4 col-xs-12" style="padding: 0em 0em;">
                 <a href="{{route('registerpage')}}">
                <img src="{{asset('pop_222.jpeg')}}" width="250" height="364" style="border: black 2px solid;">
                </a>
            </div>
            <div class="col-sm-4 col-md-4 col-xs-12" style="padding: 0em 0em;">
                 <a href="{{route('frontend.cart')}}">
                 <img src="{{asset('pop_333.jpeg')}}" width="250" height="364" style="border: black 2px solid;">
                 </a>
             </div>
          </div>
        </div>
        
      </div>
      
    </div>
  </div> -->



  <div class="modal fade" id="pop_prescription_submit" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">  
        <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" style="color: black">&times;</button>
          <div class="row">
            <div class="col-sm-12 col-md-12 col-xs-12" style="padding: 0em 0em;">
            <a href="{{route('home')}}">
             <img src="{{asset('pop_prescription_submit1.jpeg')}}" width="470" height="524" style="border: black 2px solid;">
            </a>
            </div>
            
          </div>
        </div>
        
      </div>
      
    </div>
  </div>

<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/proper.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/owl.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script src="{{asset('js/zoom.js')}}"></script>
<script>
function modal_function(identifier) {

    $('.product_code_value').val($(identifier).data('product_code'));

}
</script>

<!--  -->
<script>
var window_size = $('body').innerWidth();
if (window_size < 991) {
    $('.ui-menu').addClass('mob-res-ul');
    $(document).on('click', '.mob-res-ul li', function(e) {
        $(this).toggleClass('icnos-down').children('.dropdown-menu').slideToggle();
    });
    $('.mob-show-bar').click(function() {
        $('.navigation').css('left', '0');
        $('body').addClass('sidebar-open');
    });
    $('.hide-sidebar').click(function() {
        $('.navigation').css('left', '-100%');
        $('body').removeClass('sidebar-open');
    });
    $('.search_icon').click(function() {
        $('.search-bar').slideToggle();
    });
}
$('.pin-edit').click(function() {
    $('#pinInput').focus();
});
$('.sort-by-flter a').click(function() {
    $('.sort-by-flter a').removeClass('active');
    $(this).addClass('active');

    var data = $(this).attr('data-filter');
    $grid.isotope({
        filter: data
    })
});

$(window).scroll(function() {
    if ($(this).scrollTop() > 10) {
        $('.main-head').addClass('sticky')
    } else {
        $('.main-head').removeClass('sticky')
    }
});

var $grid = $(".grid").isotope({
    itemSelector: ".all",
    percentPosition: true,
    masonry: {
        columnWidth: ".all"
    }
})
</script>
<script>
// Get the modal
var modal = document.getElementById('add_search_product').innerHTML;

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {

    if (event.target) {
        $("#add_search_product").hide();
    }
}
</script>
<script>
function search_function() {
    var search_names = document.getElementById('search_names').value;
    $("#add_search_product").show();
    if (search_names.length > 0) {
        $.ajax({
            url: "/search/product",
            data: {
                search_names: search_names
            },
            type: "GET",
            success: function(data) {
                $("#add_search_product").html(data.data);
            }
        });
    } else {
        $("#add_search_product").html(" ");
    }
}
</script>
@guest
<script>
function add_cart_from_search(a, b, c, d) {
    var Qty = 1;
    if (d > 1 || d == 0 || d == c) {
        $.ajax({
            url: "/add_to_carts/add_cart/",
            data: {
                product_id: a,
                Qty: c,
                amount: b
            },
            type: "GET",
            success: function(data) {
                var plus_minus_button = "<div class='qty-div'>" +
                    "<span class='qty_minus' data-id='1' onclick='add_cart_from_search(" + a + "," + b +
                    ",-1," + data.qty_data + ")'>-</span>" +
                    "<input type='number' required='' id='Qty' name='Qty' class='qty_1 qty_for" +
                    a +
                    "' min='1' value='" + data.qty_data +
                    "'>" +
                    "<span class='qty_plus' data-id='1' onclick='add_cart_from_search(" + a + "," + b +
                    ",1," + data.qty_data + ")' >+</span>" +
                    "</div>";
                $(".plus_minus_button" + a).html(plus_minus_button);
                $("#add_card_view").html(data.data);
                $(".cart-dropdown").show();
                $('.cart-dropdown').delay(3000).hide(0);
            }
        });
    } else {

    }
}
</script>
@else
@if(\Auth::user()->role=='Chemist')
<script>
function add_cart_from_search(a, b, c, d) {

    if (d > 1 || d == 0 || d == c) {
        $.ajax({
            url: "/add_to_carts/add_cart_chemist/",
            data: {
                product_id: a,
                Qty: c,
                amount: b
            },
            type: "GET",
            success: function(data) {
                var plus_minus_button = "<div class='qty-div'>" +
                    "<span class='qty_minus' data-id='1' onclick='add_cart_from_search(" + a + "," + b +
                    ",-1," + data.qty_data + ")'>-</span>" +
                    "<input type='number' required='' id='Qty' name='Qty' class='qty_1 qty_for" +
                    a +
                    "' min='1' value='" + data.qty_data +
                    "'>" +
                    "<span class='qty_plus' data-id='1' onclick='add_cart_from_search(" + a + "," + b +
                    ",1," + data.qty_data + ")' >+</span>" +
                    "</div>";
                $(".plus_minus_button" + a).html(plus_minus_button);
                $("#add_card_view").html(data.data);
                $(".cart-dropdown").show();
                $('.cart-dropdown').delay(3000).hide(0);
            }
        });
    } else {

    }
}
</script>
@elseif(\Auth::user()->role=='User')
<script>
function add_cart_from_search(a, b, c, d) {
    var Qty = 1;
    if (d > 1 || d == 0 || d == c) {
        $.ajax({
            url: "/add_to_carts/add_cart_user/",
            data: {
                product_id: a,
                Qty: c,
                amount: b
            },
            type: "GET",
            success: function(data) {
                var plus_minus_button = "<div class='qty-div'>" +
                    "<span class='qty_minus' data-id='1' onclick='add_cart_from_search(" + a + "," + b +
                    ",-1," + data.qty_data + ")'>-</span>" +
                    "<input type='number' required='' id='Qty' name='Qty' class='qty_1 qty_for" +
                    a +
                    "' min='1' value='" + data.qty_data +
                    "'>" +
                    "<span class='qty_plus' data-id='1' onclick='add_cart_from_search(" + a + "," + b +
                    ",1," + data.qty_data + ")' >+</span>" +
                    "</div>";
                $(".plus_minus_button" + a).html(plus_minus_button);
                $("#add_card_view").html(data.data);
                $(".cart-dropdown").show();
                $('.cart-dropdown').delay(3000).hide(0);
            }
        });
    } else {

    }
}
</script>

@endif
@endguest
<script>
$(document).mouseup(function(e) {
    var container = $("YOUR CONTAINER SELECTOR");

    // if the target of the click isn't the container nor a descendant of the container
    if (!$(".cart-dropdown").is(e.target) && $(".cart-dropdown").has(e.target).length === 0) {
        $(".cart-dropdown").hide();
    }
});
</script>
<script>
function collision($div1, $div2) {
    var x1 = $div1.offset().left;
    var w1 = 40;
    var r1 = x1 + w1;
    var x2 = $div2.offset().left;
    var w2 = 40;
    var r2 = x2 + w2;

    if (r1 < x2 || x1 > r2)
        return false;
    return true;
}
// Fetch Url value
var getQueryString = function(parameter) {
    var href = window.location.href;
    var reg = new RegExp('[?&]' + parameter + '=([^&#]*)', 'i');
    var string = reg.exec(href);
    return string ? string[1] : null;
};
// End url
// // slider call
var request = null;
$('.slider').slider({
    range: true,
    min: 1,
    max: 2000,
    step: 1,
    values: [getQueryString('minval') ? getQueryString('minval') : 0, getQueryString('maxval') ?
        getQueryString('maxval') : 2000
    ],

    slide: function(event, ui) {

        $('.ui-slider-handle:eq(0) .price-range-min').html('' + ui.values[0]);
        $('.ui-slider-handle:eq(1) .price-range-max').html('' + ui.values[1]);
        $('.price-range-both').html('<i>' + ui.values[0] + ' - </i>' + ui.values[1]);

        // get values of min and max
        $(".minval").val(ui.values[0]);
        $(".maxval").val(ui.values[1]);

        if (ui.values[0] == ui.values[1]) {
            $('.price-range-both i').css('display', 'none');
        } else {
            $('.price-range-both i').css('display', 'inline');
        }

        if (collision($('.price-range-min'), $('.price-range-max')) == true) {
            $('.price-range-min, .price-range-max').css('opacity', '0');
            $('.price-range-both').css('display', 'block');
        } else {
            $('.price-range-min, .price-range-max').css('opacity', '1');
            $('.price-range-both').css('display', 'none');
        }

        var maxval = $(".maxval").val();
        var minval = $(".minval").val();
        var product_form = [];
        var product_uses = [];
        var prescription_required = [];

        $('.product_form:checked').each(function() {
            product_form.push($(this).val());
        });

        $('.product_uses:checked').each(function() {
            product_uses.push($(this).val());
        });

        $('.prescription_required:checked').each(function() {
            prescription_required.push($(this).val());
        });

        var group_id = $(".group_id").val();
        var groupcategory_id = $(".groupcategory_id").val();
        if (request && request.readyState != 4) {
            request.abort();
        }

        request = $.ajax({
            type: "POST",
            url: "{{ route('frontend.sidebar_filter_data') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                category: product_form,
                uses: product_uses,
                prescription_required: prescription_required,
                maxval: maxval,
                minval: minval,
                group_id: group_id,
                groupcategory_id: groupcategory_id
            },
            success: function(data) {
                $("#product_list_view").html(data);
            }
        });


    }
});

$('.ui-slider-range').append('<span class="price-range-both value"><i>' + $('.slider').slider('values', 0) +
    ' - </i>' +
    $('.slider').slider('values', 1) + '</span>');

$('.ui-slider-handle:eq(0)').append('<span class="price-range-min value">' + $('.slider').slider('values', 0) +
    '</span>');

$('.ui-slider-handle:eq(1)').append('<span class="price-range-max value">' + $('.slider').slider('values', 1) +
    '</span>');
</script>




<script>
$(".product_form, .product_uses, .prescription_required").click(function() {

    var product_form = [];
    var product_uses = [];
    var prescription_required = [];

    $('.product_form:checked').each(function() {
        product_form.push($(this).val());
    });

    $('.product_uses:checked').each(function() {
        product_uses.push($(this).val());
    });

    $('.prescription_required:checked').each(function() {
        prescription_required.push($(this).val());
    });
    var maxval = $(".maxval").val();
    var minval = $(".minval").val();
    var group_id = $(".group_id").val();
    var groupcategory_id = $(".groupcategory_id").val();

    $.ajax({
        type: "POST",
        url: "{{ route('frontend.sidebar_filter_data') }}",
        data: {
            "_token": "{{ csrf_token() }}",
            category: product_form,
            uses: product_uses,
            prescription_required: prescription_required,
            maxval: maxval,
            minval: minval,
            group_id: group_id,
            groupcategory_id: groupcategory_id
        },
        success: function(data) {
            $("#product_list_view").html(data);
        }
    });

});
</script>

<script>
function notify_me_function(Product_Code) {
    $(".product_code_value").val(Product_Code);
    $("#notify_model").modal();
}
</script>

<script>
function numOnly(id) {
    // Get the element by id
    var element = document.getElementById(id);
    // Use numbers only pattern, from 0 to 9 with \-
    var regex = /[^0-9\-]/gi;
    // Replace other characters that are not in regex pattern
    element.value = element.value.replace(regex, "");
}
</script>