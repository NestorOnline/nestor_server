@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <ul class="items">
                        <li class="home"> <a href="{{route('home')}}" title="Go to Home"> Home </a> </li>
                        <li class="home"> <a href="{{route('dashboard.my_profile')}}" title="Go to Home"> Dashboard </a>
                        </li>
                        <li class="home">Subscription</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            @include('frontend.include.dashboard_sidebar')
            <div class="col-md-9">
                <div class="cart-product mt-3">
                    <h4 style="color: white; background-color: #003579">Chat And Support</h4>
                    <div class="product-details" style="border: 3px #003579 solid; height: 700px">
                        <div class="product-itemdetails row chat_action" valign="middle" id="itemid-922086">
                            
                               
                               

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('frontend.include.footer')

 <script type="text/javascript">
    function chat_introduction() {
        $.ajax({
            url: "/introduction",
            type: "GET",
            success: function(data) {
                $('.chat_action').append("<div class='rightside-details col pr-0'><div class='row m-0 pull-left'><div class='catag-name col pl-0'><button type='button' class='btn btn-sm btn-default'>"+data.data.question+"</button></div></div></div><br>");
                myPlay();
                function chat_introduction_option() {
                 $('.chat_action').append(data.options);
                 myPlay();
                 }
             setTimeout(chat_introduction_option, 2000);
            }
        });
    }
    setTimeout(chat_introduction, 2000);
       </script>
<script type="text/javascript">
    function question_second(option_id) {

        $.ajax({
            url: "/question_second_api",
            data: {option_id:option_id},
            type: "GET",
            success: function(data1) {
                $('.chat_action').append("<div class='rightside-details col pr-0'><div class='row m-0 pull-left'><div class='catag-name col pl-0'><button type='button' class='btn btn-sm btn-default'>"+data1.data.question+"</button></div></div></div>");
                myPlay();
                function chat_introduction_second() {
                 $('.chat_action').append(data1.options);
                 myPlay();
                 }
             setTimeout(chat_introduction_second, 3000);
            }
        });
      
    }
</script>

<script type="text/javascript">
    function question_fourth(option_id) {
      
        $.ajax({
            url: "/question_fourth_api",
            data: {option_id:option_id},
            type: "GET",
            success: function(data4) {
                
                $('.chat_action').append("<div class='rightside-details col pr-0'><div class='row m-0 pull-left'><div class='catag-name col pl-0'><button type='button' class='btn btn-sm btn-default'>"+data4.data+"</button></div></div></div>");
                myPlay();
                function chat_introduction_fourth() {
                 $('.chat_action').append(data4.options);
                 myPlay();
                 }
             setTimeout(chat_introduction_fourth, 3000);
            }
        });
      
    }
</script>


<script type="text/javascript">

    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
            function chat_introduction_conclusion() {
                 $('.chat_action').append("<div class='rightside-details col pr-0'><div class='row m-0 pull-left'><div class='catag-name col pl-0'><button type='button' class='btn btn-sm btn-default'>Thanks For Sharing Information With Us. Our Team Veryfy It And We Will Update You Soon.</button></div></div></div>");
                 myPlay();
                 }
            setTimeout(chat_introduction_conclusion, 3000);
        };
    };

</script>

<script type="text/javascript">
function myPlay(){
    var audio = new Audio("http://nestoronline.in/Notification.mp3");
    audio.play();
}
</script>