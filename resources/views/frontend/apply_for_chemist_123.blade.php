<html lang="en">
    <head>
        <meta charset="utf-8">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.css">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{asset('css/image-zoom.css')}}">
        <link rel="stylesheet" href="{{asset('css/owl.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
      
    </head>
    <body>
@include('frontend.include.header')

<div class="container p-4">
    <div class="row">
        <div class="col-md-12">
            <div class="delivery-box-div">
                <div class="row">
                   
                    <div class="col-md-12">
                        <div>
                            <div>
                                <h3>Sign Up as a Chemist</h3>
                                <p>Sign up  to access your orders, special offers, <br> health tips and more!</p>
                            </div>
                            <div class="mt-5">
                           <center> <h5><u>Chemist Information</u></h5></center>

<div id='register_form'>
  <form action="{{ route('chemist_register_generate_otp') }}" enctype="multipart/form-data" method="POST">


  	<div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
    </div>

    <?php
                $statesOp = '';
                $citiesOp = '';
            
                foreach ($states as $state) {
                    $statesOp = $statesOp . '<option value="' . $state->id . '">' . $state->name . '</option>';
                    foreach ($state->cities as $city) {
                        $citiesOp = $citiesOp . '<option value="' . $city->id . '" class="' . $state->id . '">' . $city->name . '</option>';
                    }
                }
                ?>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">


   <div class="col-md-6">
                                    <label for=""><small><strong>Chemist Name</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div class="input-group-prepend">
                                             <span class="basic-addon1"></span>
                                             <input type="text" name="chemist_name" id='chemist_name' class="form-control" placeholder="Enter your Chemist Name" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
</div>

                                    <div class="col-md-6">
                                    <label for=""><small><strong>Mobile</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div class="input-group-prepend">
                                           <span class="basic-addon1"></span>
                                            <input name="mobile" type="text" id='mobile' class="form-control" placeholder="Enter your mobile no" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                    <label for=""><small><strong>Password</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div class="input-group-prepend">
                                             <span class="basic-addon1"></span>
                                             <input name="password" type="password" id='password' class="form-control" placeholder="Enter Your Password" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
</div>
<div class="col-md-6">
                                    <label for=""><small><strong>Confirmation Password</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div class="input-group-prepend">
                                             <span class="basic-addon1"></span>
                                             <input name="confirmation_password" type="password" id='confirmation_password' class="form-control" placeholder="confirm Your Password" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
</div>
                                    <div class="col-md-6">
                                    <label for=""><small><strong>Contact Person</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div class="input-group-prepend">
                                            <span class="basic-addon1"></span>
                                            <input name="contact_person"  type="text" id='contact_person' class="form-control" placeholder="Enter your Contact Person" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
</div>
                                    <div class="col-md-6">
                                    <label for=""><small><strong>Designation</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div class="input-group-prepend">
                                             <span class="basic-addon1"></span>
                                            <input name="designation" type="text" id='designation' class="form-control" placeholder="Enter your Contact Designation" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
</div>
<div class="col-md-6">
                                        <label for=""><small><strong>Drug License No</strong></small></label>
                                        <div class="input-group mb-5">
                                            <div class="input-group-prepend">
                                                <span class="basic-addon1"></span>
                                                <input name="drug_license_no" type="text" id='drug_license_no' class="form-control" placeholder="Enter your Drug License" aria-label="Username" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <label for=""><small><strong>Drug Licence</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div >
                                            <span class="basic-addon1"></span>
                                            <input name="drug_licence" type="file" id='drug_licence' class="form-control" placeholder="Enter Drug Licence" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                      </div>
                                      <div class="col-md-6">
                                        <label for=""><small><strong>gst</strong></small></label>
                                        <div class="input-group mb-5">
                                            <div class="input-group-prepend">
                                                <span class="basic-addon1"></span>
                                                <input name="gst" type="text" id='gst' class="form-control" placeholder="Enter Your GST" aria-label="Username" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                   
                                    <div class="col-md-12">  
                                      <center> <h5><u>Address Information</u></h5></center>
                                      <br>
                                    </div>
                                    <div class="col-md-6">
                                    <label for=""><small><strong>Pincode</strong></small></label>
                                      <div class="input-group mb-5">
                                        <div >
                                            <span class="basic-addon1"></span>
                                            <input name="pincode" type="text" id="pincode" onkeyup="calc()" class="form-control" placeholder="Enter Your Pincode" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                     </div>
                                    </div>
                                 
    <div class="col-md-6">
                                    <label for=""><small><strong>Address 1</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div class="input-group-prepend">
                                             <span class="basic-addon1"></span>
                                            <input name="address1" type="text" id='address1' class="form-control" placeholder="Enter your Address 1" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
</div>

    <div class="col-md-6">
                                    <label for=""><small><strong>Address 2</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div class="input-group-prepend">
                                             <span class="basic-addon1"></span>
                                            <input name="address2" type="text" id='address2' class="form-control" placeholder="Enter your address 2" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
</div>
<div class="col-md-6">
                                    <label for=""><small><strong>Address 3</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div class="input-group-prepend">
                                             <span class="basic-addon1"></span>
                                            <input name="address3" type="text" id='address3' class="form-control" placeholder="Enter your address 2" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
</div>
    
                                    
                                       <div class="col-md-6">
                                    <label for=""><small><strong>City</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div class="input-group-prepend">
                                             <span class="basic-addon1"></span>
                                             <select  name="city_id" id="city_id" tooltiptext="Select the reason" tabindex="13" class="form-control "> 
                                        {!!$citiesOp!!} 
                                        </select>
                                        </div>
                                    </div>
                                   </div>                                
                                    
                                     <div class="col-md-6">
                                    <label for=""><small><strong>Email</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div >
                                            <span class="basic-addon1"></span>
                                            <input name="email" type="text" id='email' class="form-control" placeholder="Enter Your Email" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                     </div>
    <div class="col-md-6">
                                     <label for=""><small><strong>State</strong></small></label>
                                    <div class="input-group mb-5">
                                        <div >
                                            <span class="basic-addon1"></span>
                                            <select  name="state_id" id="state_id"  tooltiptext="Select the reason" tabindex="13" class="form-control "> 
                                        {!!$statesOp!!}
                                        </select>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                     <label for=""><small><strong>Geolocation  <span class="fa fa-map-marker" id="get_latitude_longitude"></span></strong></small></label>
                                    <div class="input-group mb-5">
                                        <div>
                                            <span class="basic-addon1"></span>
                                            <input name="geolocation" id="geolocation" type="text"  class="form-control" >
                                        </div>
                                    </div>
                                    </div>

<div class="col-md-6">
    <div class="form-group">
      <button class="btn btn-success upload-image" type="submit">Submit</button>
    </div>
</div>

  </form>
</div>
<div id="opt-reg-sec" style="display:none">
                                    <label for=""><small><strong>Enter OTP</strong></small></label>
                                    <section class="otp-section">
                                        <form method="post" action="{{url('chemist_form')}}">
                                            <input type="number" id="digit-1" name="digit-1" data-next="digit-2" />
                                            <input type="number" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" />
                                            <input type="number" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" />
                                            <input type="number" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" />
                                            <input type="number" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" />
                                            <input type="number" id="digit-6" name="digit-6" data-previous="digit-5" />
                                        <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                            <div><button type="submit" class="add-to-cart">Sign UP</button></div>
                                        </div>
                                    </div>
                                        </form>
                                    </section>   
                                     <a href="#" id="chemist_register_generate_resend_otp">Resend OTP</a> 
                                </div>

       </div>
                        </div>
                    </div>
                </div>
            </div>
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
                    <div class="col-md-3">
                  <!--
                  <div class=" footer-logo"> <img src="img/icons/nestor.png" class="w-50" > </div>
                  -->
                      <div class=" footer-logo"> <img src="{{asset('img/nestor-logo.jpeg')}}"  style="height: 100px; width: 75px" > </div>   
                        <div class="footer-txt pt-3"> nestor.com, India Ki Pharmacy, is brought to you by the Dadha &amp; Company â€“ one of Indiaâ€™s most trusted pharmacies, with over 100 yearsâ€™ experience in dispensing quality medicines. </div>
                    </div>
                    <ul class="col-md-2 list-unstyled">
                        <li>
                            <h2>Company</h2>
                        </li>
                        <li><a href="">About nestor</a></li>
                        <li><a href="">Customers Speak</a></li>
                        <li><a href="">In the News</a></li>
                        <li><a href="">Career</a></li>
                        <li><a href="">Terms and Conditions</a></li>
                        <li><a href="">Privacy Policy</a></li>
                        <li><a href="">Contact</a></li>
                    </ul>
                    <ul class="col-md-2 list-unstyled">
                        <li>
                            <h2>Shopping</h2>
                        </li>
                        <li><a href="">Browse by A-Z</a></li>
                        <li><a href=" ">Browse by Manufacturers</a></li>
                        <li><a href=" ">Health Articles</a></li>
                        <li><a href=" ">Offers / Coupons</a></li>
                        <li><a href=" ">FAQs</a></li>
                    </ul>
                    <ul class="col-md-2 list-unstyled">
                        <li>
                            <h2>CATEGORIES</h2>
                        </li>
                        <li><a href=" ">Ayush</a></li>
                        <li><a href=" ">Devices</a></li>
                        <li><a href=" ">Family Care</a></li>
                        <li><a href=" ">Fitness</a></li>
                        <li><a href=" ">Lifestyle</a></li>
                        <li><a href=" ">Personal care</a></li>
                        <li><a href=" ">Treatments</a></li>
                    </ul>
                    <ul class="col-md-3 list-unstyled">
                        <li>
                            <h2>Download App</h2>
                        </li>
                        <li><a href=" "><img src="img/play.png" alt="Download nestor App for Android from Play Store" title="Download nestor App for Android from Play Store"></a></li>
                        <li><a href=" "><img src="img/app.png" alt="Download nestor App for iOs from App Store" title="Download nestor App for iOs from App Store"></a></li>
                        <li><a href=""><img src="img/fb.png" alt=""></a></li>
                    </ul>
                </div>
            </div>
        </footer>
        <small class="copyright">
            <div class="copyblock container">
                <div class="copy-txt">CopyrightÂ© 2020 Nestor Marketplace Ltd.</div>
            </div>
        </small>





                <script src="{{asset('js/proper.js')}}"></script>
        <script src="{{asset('js/bootstrap.js')}}"></script>
        <script src="{{asset('js/owl.js')}}"></script>
        <script src="{{asset('js/main.js')}}"></script>   
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
          <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="http://malsup.github.com/jquery.form.js"></script>
       
        <script src="{{asset('js/zoom.js')}}"></script>
        <script type="text/javascript">
                                jQuery(document).ready(function($) {                                   
                                //    $("#city_id").chained("#state_id");                                    
                                });
                                
        </script>
        </script>     
        
        <script>
    function calc()
    {
        var pincode = document.getElementById('pincode').value;
        if(pincode.length == 6){

         $.ajax({
    url: "/dashboard/pincode/check",
    data: {pincode:pincode},
    type: "GET",
    success:  function(data){
        console.log(data);
        $("#state_id").val(data.data.state_id).trigger("change");
        $("#city_id").val(data.data.city_id).trigger("change");
        // setTimeout(() => {
        //     console.log($('#city_id'));
        //     // $('select[name^="city_id"] option[value="127"]').attr("selected","selected");
        //     // $("#city_id").val("127").trigger("change");
        // }, 5000);
       

        // $('#state_id').value = data.data.state_id;
        // $('#city_id').value = data.data.city_id;
        // $('select[name^="state_id"] option[value="19"]').attr("selected","selected");
        // $('select[name^="city_id"] option[value="35"]').attr("selected","selected");
        // console.log($('#state_id'),$('#city_id'));
    }
});
        }else{

        }
    }
   </script>
                <script>
$('.otp-section').find('input').each(function() {
	$(this).attr('maxlength', 1);
	$(this).on('keyup', function(e) {
		var parent = $($(this).parent());
		
		if(e.keyCode === 8 || e.keyCode === 37) {
			var prev = parent.find('input#' + $(this).data('previous'));
			
			if(prev.length) {
				$(prev).select();
			}
		} else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
			var next = parent.find('input#' + $(this).data('next'));
			
			if(next.length) {
				$(next).select();
			} else {
				if(parent.data('autosubmit')) {
					parent.submit();
				}
			}
		}
	});
});

</script>

        <script>
    function search_function()
    {
        var search_names = document.getElementById('search_names').value;
        if(search_names.length > 0){         
         $.ajax({
    url: "/search/product",
    data: {search_names:search_names},
    type: "GET",
    success:  function(data){
        $("#add_search_product").html(data);
        console.log(data);
    }
});
        }else{
         $("#add_search_product").html(" ");   
        }
    }
        </script>

<script type="text/javascript">
  $("body").on("click",".upload-image",function(e){
    $(this).parents("form").ajaxForm(options);
  });


  var options = { 
    complete: function(response) 
    {
    	if($.isEmptyObject(response.responseJSON.error)){
    $("input[name='chemist_name']").val('');
    $('#phone-reg-form').css('display', 'none');
    $('#register_form').css('display', 'none');
    $('#opt-reg-sec').css('display', 'block');
    		alert('Please Check Your One Time OTP');
    	}else{
    		printErrorMsg(response.responseJSON.error);
    	}
    }
  };


  function printErrorMsg (msg) {
	$(".print-error-msg").find("ul").html('');
	$(".print-error-msg").css('display','block');
	$.each( msg, function( key, value ) {
		$(".print-error-msg").find("ul").append('<li>'+value+'</li>');
	});
  }
</script>

<script>
      $(document).ready(function(){
               $("#chemist_register_generate_resend_otp").click(function(){ 
            var mobile = $("#mobile").val();
            
                   $.ajax({
    url: "/chemist_register_generate_resend_otp",
    data: {mobile:mobile},
    type: "GET",
    success:  function(data){  
        alert(data.success);
        if(data.success=='Unauthorised User'){
            $("#alert_message").html('Unauthorised User');           
        }else{
      $("#alert_message").html('One Time OTP Send to Your Phone Successfully');
      $("input[name='chemist_name']").val('');
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
      $(document).ready(function(){
               $("#get_latitude_longitude").click(function(){ 
                var mobile = '1234567890';
                   $.ajax({
    url: "/get_latitude_longitude",
    data: {mobile:mobile},
    type: "GET",
    success:  function(data){  
        //document.getElementById("geolocation").innerHTML = data; 
        // document.getElementById("geolocation").innerHTML = data;  
        $("#geolocation").val(data);    

    }
});
        });                     
        });
        
        </script>
       

</body>
</html>
