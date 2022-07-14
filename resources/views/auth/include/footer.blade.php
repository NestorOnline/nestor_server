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
                        <div class="footer-txt pt-3"> Nestor Pharmaceuticals Ltd is a rapidly growing global enterprise backed by more than four decades of expertise in manufacture and marketing of a wide array of ethical allopathic branded and generic formulations. </div>
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
                        <li><a href=" "><img src="{{asset('img/play.png')}}" alt="Download nestor App for Android from Play Store" title="Download nestor App for Android from Play Store"></a></li>
                        <li><a href=" "><img src="{{asset('img/app.png')}}" alt="Download nestor App for iOs from App Store" title="Download nestor App for iOs from App Store"></a></li>
                        <li><a href=""><img src="{{asset('img/fb.png')}}" alt=""></a></li>
                    </ul>
                </div>
            </div>
        </footer>
        <small class="copyright">
            <div class="copyblock container">
                <div class="copy-txt">CopyrightÂ© 2020 Nestor Pharmaceuticals Limited</div>
            </div>
        </small>




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
