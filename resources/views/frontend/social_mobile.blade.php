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
                            @include('flash')
                            <center>
                                <b style="font-size: 1.2em; color: red"> <div id="alert_message"></div></b>
                            </center>
                            <div class="mt-5">

                                <div>
                                    <label for=""><small><strong>Phone Number</strong></small></label>
                                    <form action="{{url('/loginpage_password')}}" method="post">
                                        <div class="input-group mb-5">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text basic-addon1" id="basic-addon1">+91</span>
                                                <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Enter your mobile no" aria-label="Username" aria-describedby="basic-addon1">
                                            <input type="hidden" id="google_user_id" class="form-control" value="{{$google_user_id}}">
                                            </div>
                                        </div>
                                    </form>
                                    <div style="display:none" id="otp-div">                                       
                                        <label for=""><small><strong>Enter OTP</strong></small></label>
                                        <section class="otp-section otp-section-login"> 
                                            <form action="{{route('socialite.socialite_mobile',$google_user_id)}}" method="post">
                                                 @csrf
                                                <input type="number" id="digit-1" name="digit-1" data-next="digit-2" />
                                                <input type="number" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" />
                                                <input type="number" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" />
                                                <input type="number" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" />
                                                <input type="number" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" />
                                                <input type="number" id="digit-6" name="digit-6" data-previous="digit-5" />  

                                                <button  type="submit" class="add-to-cart use-verify">Verify</button>                                      
                                            </form>
                                        </section>  
                                        <a href="#" id="resend_otp">Resend OTP</a>  
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                            <div> <span class="book-now"><a href="javascript:void(0)" class="w-100 text-center use-otp"  id="sendotp">Use OTP</a></span></div>
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
                                        <input type="text" class="form-control" placeholder="Enter your mobile no" aria-label="Mobile" aria-describedby="basic-addon1">
                                       
                                        
                                    </div>
                                </div>
                                <div>
                                    <label for=""><small><strong>Password</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div >
                                            <span class="basic-addon1"></span>
                                            <input type="password" class="form-control" placeholder="Enter password" aria-label="Password" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for=""><small><strong>Enter OTP</strong></small></label>
                                    <section class="otp-section otp-section-login">
                                        <form>
                                            <input type="number" id="digit-1" name="digit-1" data-next="digit-2" />
                                            <input type="number" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" />
                                            <input type="number" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" />
                                            <input type="number" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" />
                                            <input type="number" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" />
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
    $('.otp-section-login').find('input').each(function () {
        $(this).attr('maxlength', 1);
        $(this).on('keyup', function (e) {
            var parent = $($(this).parent());

            if (e.keyCode === 8 || e.keyCode === 37) {
                var prev = parent.find('input#' + $(this).data('previous'));

                if (prev.length) {
                    $(prev).select();
                }
            } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
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
    $('.use-otp').click(function () {
        $('#otp-div').css('display', 'block');
        $('#pass-div').css('display', 'none');
        $('.use-pass').css('display', 'none');
        $('.use-otp').css('display', 'none');
    })
    $('.use-pass').click(function () {
        $('#pass-div').css('display', 'block');
        $('#otp-div').css('display', 'none');
        $('.use-pass').css('display', 'none');
        $('.use-otp').css('display', 'none');
    });
    $('#forget-click').click(function () {
        $('#forget-pass').css('display', 'block');
        $('#login-box').css('display', 'none');
    });

</script>

<script>
    $(document).ready(function () {
        $("#sendotp").click(function () {

            var mobile = $("#mobile").val();
             var google_user_id = $("#google_user_id").val();
            

            $.ajax({
                url: "/socialite/send_otp",
                data: {mobile: mobile,google_user_id:google_user_id},
                type: "GET",
                success: function (data) {
                    if(data == 'Unauthorised User'){
                        $("#alert_message").html('Unauthorised User');
                    }else{
                        $("#alert_message").html('One Time OTP Send to Your Phone Successfully');
                    }
                }
            });
        });
    });

</script>

<script>
    $(document).ready(function () {
        $("#resend_otp").click(function () {
            var mobile = $("#mobile").val();
            var google_user_id = $("#google_user_id").val();
            $.ajax({
                url: "/socialite/resend_otp",
                data: {mobile: mobile,google_user_id:google_user_id},
                type: "GET",
                success: function (data){
                    if(data == 'Unauthorised User'){
                        $("#alert_message").html('Unauthorised User');
                    }else{
                        $("#alert_message").html('One Time OTP Send to Your Phone Successfully');
                    }
                }
            });
        });
    });

</script>

</body>
</html>