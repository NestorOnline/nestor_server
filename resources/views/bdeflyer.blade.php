@include('frontend.include.head')

<div class="main" style="background-color: #023878">
    <div class="container-fluid">
        <div class="card-sec">
            <div class="h-pettern text-center">
                <center>
                    <img class="img-responsive" style="width: 50px" src="{{asset('img/nestor_logo.png')}}" />
                    <h6>
                        WELCOME TO NESTOR PHARMACEUTICALS
                    </h6>
                </center>
            </div>



            <div>
                <img src="{{asset('image31.png')}}" style="width: 100%">
                <img src="{{asset('image4.png')}}" style="width: 100%">
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card-sec" style="background-color: #023878">
            <div>
                <div class="owl-carousel owl-theme owl-three hidden-xs">
                    <center>
                        <div class="item" style="background-color: white; width: 300px;border-radius: 25px;">
                            <div>
                                <img src="{{asset('mobile.png')}}" style="width: 100px" alt="">
                                <div class="diag-txt">
                                    <span class="clsgetname ellipsis"><b style="font-size: 1.5em">Click to Download for
                                            Iphone</b></span>
                                    <a href="javascript:void(0);" style="color:White;border-bottom-color:White"><img
                                            src="{{asset('AppleAppStore.png')}}" alt="App Store"
                                            style="width: 200px" /></a>

                                </div>
                            </div>
                        </div>
                    </center>
                    <center>
                        <div class="item" style="background-color: white; width: 300px;border-radius: 25px;">

                            <div>
                                <img src="{{asset('mobile.png')}}" style="width: 100px" alt="">
                                <div class="diag-txt">
                                    <span class="clsgetname ellipsis"><b style="font-size: 1.5em">Click to Download for
                                            Android</b></span>

                                    <a href="https://play.google.com/store/apps/details?id=com.nestorpharma.b2b_app"
                                        style="color:White;border-bottom-color:White"><img
                                            src="{{asset('GooglePlayStore.png')}}" alt="Google Play Store"
                                            style="width: 200px" /></a>

                                </div>
                            </div>
                        </div>
                    </center>

                </div>

                <div class="owl-carousel owl-theme owl-three hidden-sm hidden-md hidden-lg">
                    <center>
                        <div class="item" style="background-color: white; width: 300px;border-radius: 25px;">

                            <div>
                                <img src="{{asset('mobile.png')}}" style="width: 100px" alt="">
                                <div class="diag-txt">
                                    <span class="clsgetname ellipsis"><b style="font-size: 1.5em">Click to Download for
                                            Android</b></span>

                                    <a href="https://play.google.com/store/apps/details?id=com.nestorpharma.b2b_app"
                                        style="color:White;border-bottom-color:White"><img
                                            src="{{asset('GooglePlayStore.png')}}" alt="Google Play Store"
                                            style="width: 200px" /></a>

                                </div>
                            </div>
                        </div>
                    </center>
                    <center>
                        <div class="item" style="background-color: white; width: 300px;border-radius: 25px;">
                            <div>
                                <img src="{{asset('mobile.png')}}" style="width: 100px" alt="">
                                <div class="diag-txt">
                                    <span class="clsgetname ellipsis"><b style="font-size: 1.5em">Click to Download for
                                            Iphone</b></span>
                                    <a href="javascript:void(0);" style="color:White;border-bottom-color:White"><img
                                            src="{{asset('AppleAppStore.png')}}" alt="App Store"
                                            style="width: 200px" /></a>

                                </div>
                            </div>
                        </div>
                    </center>


                </div>
                <br>
                <style type="text/css">
                h1 {
                    color: green;
                }

                .xyz {
                    background-size: auto;
                    text-align: center;
                    padding-top: 100px;
                }

                .btn-circle.btn-sm {
                    width: 30px;
                    height: 30px;
                    padding: 6px 0px;
                    border-radius: 15px;
                    font-size: 8px;
                    text-align: center;
                }

                .btn-circle.btn-md {
                    width: 50px;
                    height: 50px;
                    padding: 7px 10px;
                    border-radius: 25px;
                    font-size: 10px;
                    text-align: center;
                }

                .btn-circle.btn-xl {
                    width: 120px;
                    height: 120px;
                    padding: 10px 16px;
                    border-radius: 60px;
                    font-size: 18px;
                    text-align: center;
                }
                </style>
                <div class="row">

                    <div class="col-sm-12 hidden-xs">
                        <center>
                            <img src="{{asset('Introductory_Presentation.png')}}"
                                style="width: 250px; margin-top: 22px; width: 100px">
                            <span class="book-now" style="padding:10px">
                                <a href="{{route('apply_for_chemist')}}" class="btn btn-light btn-circle btn-xl"
                                    style="text-align: center;background: #023878;color: #fff;border: 2px white solid;">
                                    <br>
                                    <b> REGISTER <br>
                                        ONLINE
                                    </b>
                                </a>
                            </span>
                            <span class="book-now" style="padding:10px">
                                <a class="btn btn-light" href="{{route('home')}}"
                                    style="font-size: 20px;background: #023878;color: #fff;border: 2px white solid;">SHOP
                                    NOW</a>
                            </span>
                        </center>
                    </div>
                    <div class="col-sm-6 hidden-sm hidden-md hidden-lg">
                        <center>
                            <span class="book-now" style="padding:10px">
                                <a href="{{route('apply_for_chemist')}}" class="btn btn-light btn-circle btn-xl"
                                    style="text-align: center;background: #023878;color: #fff;border: 2px white solid;">
                                    <br>
                                    <b> REGISTER <br>
                                        ONLINE
                                    </b>
                                </a>
                            </span>
                        </center>
                    </div>
                    <div class="col-sm-6 hidden-sm hidden-md hidden-lg">
                        <center>
                            <span class="book-now" style="padding:10px">
                                <a class="btn btn-light" href="{{route('home')}}"
                                    style="font-size: 20px;background: #023878;color: #fff;border: 2px white solid;">SHOP
                                    NOW</a>
                            </span>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card-sec">

            <div>
                <div class="row">
                    <div class="container">
                        <div class="col-sm-3">
                            <img class="img-responsive" src="mobile.png" />
                        </div>
                        <div class="col-sm-6">
                            <br />
                            <br />
                            <center>
                                <p style="font-size: 2.8em"><b>Sign up now and get 1000 reward points credited to your
                                        Account immediately</b></p>
                            </center>
                        </div>
                        <div class="col-sm-3">
                            <br />
                            <br />
                            <br />
                            <img class="img-responsive" src="QR.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

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
                            aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-info" type="submit">Submit</button>
                </div>
            </div>
            {!!Form::close()!!}

        </div>
    </div>
</div>

<small class="copyright" style="background-color: #023878">
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
                <p>Notification alert has been activated.</p>
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
    max: 1000,
    step: 1,
    values: [getQueryString('minval') ? getQueryString('minval') : 0, getQueryString('maxval') ?
        getQueryString('maxval') : 750
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
    $("#notify_me_alert").modal();
}
</script>