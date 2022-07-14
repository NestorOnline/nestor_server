@include('frontend.include.head')
@include('frontend.include.header')
<div class="container p-4">
    <div class="row">
        <div class="col-md-12">
            <div class="delivery-box-div">
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-center right-ab">
                            <img src="{{asset('img/login.png')}}" alt="" class="w-75">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="login-box">
                            <div>
                                <h3>Sign In </h3>
                                <p>Sign in to access your orders, special offers, <br> health tips and more!</p>
                            </div>

                            <center>
                                <b style="font-size: 1.2em; color: red">
                                    <div id="alert_message"> @include('flash')</div>
                                </b>
                                <b style="font-size: 1.2em; color: #0A8A0A">
                                    <div id="success_message"></div>
                                </b>

                            </center>
                            <div class="mt-5">

                                <div>
                                    <label for=""><small><strong>Mobile Number</strong></small></label>
                                    <form action="{{url('/loginpage_password')}}" method="post">
                                        <div class="input-group mb-5">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text basic-addon1" id="basic-addon1"></span>
                                                <input type="text" name="mobile" class="form-control" id="mobile"
                                                    pattern="^[0-9]{10}$"
                                                    onkeyup="this.value=this.value.replace(/[^0-9]/g, '')"
                                                    MaxLength="10" minlength="10" placeholder="Enter your mobile no"
                                                    aria-label="Username" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div style="display:none" id="pass-div">
                                            <label for=""><small><strong>Password</strong></small></label>
                                            <div class="input-group mb-5">
                                                <div>
                                                    <span class="basic-addon1"></span>
                                                    <input type="password" name="password" class="form-control"
                                                        placeholder="Enter password" aria-label="password"
                                                        aria-describedby="basic-addon1">
                                                    <div class="text-right pt-3"><a href="javascript:void(0)"
                                                            id="forget-click">Forget Password?</a></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 offset-md-1">
                                                    <div class="col-md-1"></div>
                                                    <div><button type="submit"
                                                            class="add-to-cart use-submit">Submit</button></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div id="opt-reg-sec" style="display: none">
                                        <label for=""><small><strong>Enter OTP</strong></small></label>
                                        <section class="otp-section otp-section-login">
                                            <form action="{{url('/loginpage')}}" method="post">
                                                <input type="number" id="digit-1" name="digit-1" data-next="digit-2" />
                                                <input type="number" id="digit-2" name="digit-2" data-next="digit-3"
                                                    data-previous="digit-1" />
                                                <input type="number" id="digit-3" name="digit-3" data-next="digit-4"
                                                    data-previous="digit-2" />
                                                <input type="number" id="digit-4" name="digit-4" data-next="digit-5"
                                                    data-previous="digit-3" />
                                                <input type="number" id="digit-5" name="digit-5" data-next="digit-6"
                                                    data-previous="digit-4" />
                                                <input type="number" id="digit-6" name="digit-6"
                                                    data-previous="digit-5" />

                                                <button type="submit" class="book-now-cart use-verify"
                                                    style="margin-top: -30px">Verify</button>
                                            </form>
                                        </section>
                                        <a href="javascript:void(0)" id="resend_otp">Resend OTP</a>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                            <div><a href="javascript:void(0)" class="add-to-cart use-pass">Use
                                                    password</a></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="or-sect"><span class="or-sect-or">OR</span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                            <div> <span class="book-now"><a href="javascript:void(0)"
                                                        class="w-100 text-center use-otp" id="sendotp">Use
                                                        OTP</a></span>
                                                    </div>
                                        </div>
                                        <div>
                                        <div class="or-sect"><span class="or-sect-or"></span></div>
                                    </div>
                                        <div class="col-md-8 offset-md-2">
                                       <div> <span class="book-now">
                                                <a class="w-100 text-center" href="{{route('registerpage')}}">Sign up <span></span></a>
                                                <!-- <a href="{{url('socialite/google')}}">Google <span></span></a> -->
                                            </div>
                                        </div>
                                        <div class="col-md-4 offset-md-2">
                                            <div class="g-login">
                                                <a href="">Google <span></span></a>
                                                <!-- <a href="{{url('socialite/google')}}">Google <span></span></a> -->
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="f-login">
                                                <a href="">Facebook <span></span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-5">
                                        <div>
                                            <center style="margin-top: 10px"> <a href="{{route('apply_for_chemist')}}"
                                                    title="Registered As a Chemist"> Registered As a Chemist
                                                </a></span></center>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div id="forget-pass" style="display:none">
                            <div>
                                <h3>Verify</h3>
                                <p>Sign in to access your orders, special offers, <br> health tips and more!</p>
                            </div>
                            <div class="mt-5">
                                <label for=""><small><strong>Phone Number</strong></small></label>
                                <div class="input-group mb-5">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text basic-addon1" id="basic-addon1">+91</span>
                                        <input type="text" class="form-control" placeholder="Enter your mobile no"
                                            aria-label="Mobile" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div>
                                    <label for=""><small><strong>Password</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="password" class="form-control" placeholder="Enter password"
                                                aria-label="Password" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for=""><small><strong>Enter OTP</strong></small></label>
                                    <section class="otp-section otp-section-login">
                                        <form>
                                            <input type="number" id="digit-1" name="digit-1" data-next="digit-2" />
                                            <input type="number" id="digit-2" name="digit-2" data-next="digit-3"
                                                data-previous="digit-1" />
                                            <input type="number" id="digit-3" name="digit-3" data-next="digit-4"
                                                data-previous="digit-2" />
                                            <input type="number" id="digit-4" name="digit-4" data-next="digit-5"
                                                data-previous="digit-3" />
                                            <input type="number" id="digit-5" name="digit-5" data-next="digit-6"
                                                data-previous="digit-4" />
                                            <input type="number" id="digit-6" name="digit-6" data-previous="digit-5" />
                                        </form>
                                    </section>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 offset-md-2">
                                        <div><a href="javascript:void(0)" class="add-to-cart ">Verify</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontend.include.footer')
<script>
$('.otp-section-login').find('input').each(function() {
    $(this).attr('maxlength', 1);
    $(this).on('keyup', function(e) {
        var parent = $($(this).parent());

        if (e.keyCode === 8 || e.keyCode === 37) {
            var prev = parent.find('input#' + $(this).data('previous'));

            if (prev.length) {
                $(prev).select();
            }
        } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e
                .keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
            var next = parent.find('input#' + $(this).data('next'));

            if (next.length) {
                $(next).select();
            } else {
                if (parent.data('autosubmit')) {
                    parent.submit();
                }
            }
        }
    });
});
$('.use-otp').click(function() {
    // $('#otp-div').css('display','block');
    // $('#pass-div').css('display','none');
    // $('.use-pass').css('display','none');
    // $('.use-otp').css('display','none');
})
$('.use-pass').click(function() {
    $('#pass-div').css('display', 'block');
    $('#otp-div').css('display', 'none');
    $('.use-pass').css('display', 'none');
    $('.use-otp').css('display', 'none');
});
$('#forget-click').click(function() {
    $('#forget-pass').css('display', 'block');
    $('#login-box').css('display', 'none');
});
</script>

<script>
$(document).ready(function() {
    $("#sendotp").click(function() {

        var mobile = $("#mobile").val();

        $.ajax({
            url: "send_otp",
            data: {
                mobile: mobile
            },
            type: "GET",
            success: function(data) {
                if (data == 'Unauthorized User') {
                    $("#alert_message").html('Unauthorized User');
                    $("#success_message").hide();
                } else {
                    $('#opt-reg-sec').css('display', 'block');
                    $('#pass-div').css('display', 'none');
                    $('.use-pass').css('display', 'none');
                    $('.use-otp').css('display', 'none');
                    $("#success_message").html(
                        'One Time Password successfully sent to your mobile.');
                    $("#alert_message").hide();
                }
            }
        });
    });
});
</script>

<script>
$(document).ready(function() {
    $("#resend_otp").click(function() {
        var mobile = $("#mobile").val();

        $.ajax({
            url: "resend_otp",
            data: {
                mobile: mobile
            },
            type: "GET",
            success: function(data) {
                if (data == 'Unauthorized User') {
                    $("#alert_message").html('Unauthorized User');
                    $("#success_message").hide();
                } else {
                    $('#opt-reg-sec').show();
                    $('#pass-div').hide();
                    $('.use-pass').hide();
                    $('.use-otp').hide();
                    $("#success_message").html(
                        'One Time Password successfully resent to your mobile.');
                    $("#alert_message").hide();
                }
            }
        });
    });
});
</script>

</body>

</html>