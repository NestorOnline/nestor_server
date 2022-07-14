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
                        <div>
                            <div>
                                <h3>Sign Up</h3>
                                <p>Sign up to access your orders, special offers, <br> health tips and more!</p>
                                @include('flash')
                            </div>
                            <center>
                                <b style="font-size: 1.2em; color: red">
                                    <div id="alert_message"></div>
                                </b>
                            </center>
                            <div class="mt-5">
                                <div id='register_form'>
                                    <label for=""><small><strong>Mobile Number</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text basic-addon1" id="basic-addon1"></span>
                                            <input type="text" id='mobile' class="form-control"
                                                placeholder="Enter your mobile no" pattern="^[0-9]{10}$"
                                                onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" MaxLength="10"
                                                minlength="10" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <label for=""><small><strong>Password</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="password" id='password' class="form-control"
                                                placeholder="Enter password" aria-label="Username"
                                                aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <label for=""><small><strong>Confirm Password</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input type="password" id='confirmation_password' class="form-control"
                                                placeholder="Enter password" aria-label="Username"
                                                aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="row" id="phone-reg-form">
                                        <div class="col-md-8 offset-md-2">
                                            <div><a href="javascript:void(0)" class="add-to-cart use-otp"
                                                    id="register_generate_otp">Submit</a></div>
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
                                <div id="opt-reg-sec" style="display:none">
                                    <label for=""><small><strong>Enter OTP</strong></small></label>
                                    <section class="otp-section otp-section-login">
                                        <form method="post" action="{{url('registerpage')}}">
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
                                            <div class="row">
                                                <button type="submit" class="book-now-cart use-verify"
                                                    style="margin-top: -30px">Verify</button>
                                            </div>
                                        </form>

                                    </section>
                                    <a href="#" id="register_generate_resend_otp">Resend OTP</a>
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
$('.otp-section').find('input').each(function() {
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

$('#veri-otp').click(function() {
    $('#opt-reg-sec').css('display', 'none');
    $('#full-reg-form').css('display', 'block');
    $('#register_form').css('display', 'none');
});
</script>

<script>
$(document).ready(function() {
    $("#register_generate_otp").click(function() {

        var mobile = $("#mobile").val();
        var password1 = $("#password").val();
        var password2 = $("#confirmation_password").val();
        // If password not entered
        if (password1 == '') {
            alert("Please enter Password");
            return false;
        }
        // If confirm password not entered
        else if (password2 == '') {
            alert("Please enter confirm password");
            return false;
        }
        // If Not same return False.
        else if (password1 != password2) {
            alert("\nPassword did not match: Please try again...")
            return false;
        }
        // If same return True.
        else {
            if (password1.length < 6) {
                alert("password will be minimum 6 character")
            }

        }
        $.ajax({
            url: "register_generate_otp",
            data: {
                mobile: mobile,
                password: password1
            },
            type: "GET",
            success: function(data) {
                if (data == 'This Mobile No Already Registered') {
                    $("#alert_message").html('This Mobile No Already Registered');
                } else {
                    $("#alert_message").html(
                        'One Time Password successfully sent to your mobile.');
                    $('#phone-reg-form').css('display', 'none');
                    $('#register_form').css('display', 'none');
                    $('#opt-reg-sec').css('display', 'block');
                }
            }
        });
    });
});
</script>

<script>
$(document).ready(function() {
    $("#register_generate_resend_otp").click(function() {
        var mobile = $("#mobile").val();
        $.ajax({
            url: "register_generate_resend_otp",
            data: {
                mobile: mobile
            },
            type: "GET",
            success: function(data) {
                if (data == 'This Mobile No Already Registered') {
                    $('#phone-reg-form').css('display', 'none');
                    $('#register_form').css('display', 'none');
                    $('#opt-reg-sec').css('display', 'block');
                    $('#register_form').css('display', 'none');
                    $('#register_generate_resend_otp').css('display', 'none');
                }
            }
        });
    });
});
</script>