@include('frontend.include.head')
@include('frontend.include.header')
<div class="main-div">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <ul class="items">
                        <li class="home"> <a href="{{route('home')}}" title="Go to Home"> Home </a> </li>
                        <li class="home"> <a href="{{route('frontend.upload_prescriptions.select_doctor_type')}}"
                                title="Select Doctor Type"> Select Doctor Type </a> </li>
                    </ul>
                    @include('flash')
                </div>
            </div>

            <div class="col-md-12">
                <div class="container">
                    <div class="row" style="background: white; border: 2px #BEBEBE
 solid; border-radius: 25px;">

                        <div class="col-sm-6">
                            <h1 style="font-size: 3.0em; margin-top: 50px">Get Free consultation and Prescription</b>
                        </div>
                        <div class="col-sm-2"></div>
                        <div class="col-sm-4">
                            <img src="{{asset('THUMBNAIL_consultation.jpg')}}" style="width: 100%">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <br><br>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <span class="book-now pull-right">
                                <a class="btn btn-sm btn-block" onclick="select_doctor_type(1);"
                                    style="width: 280px; height: 170px;background: #003579;color: white; font-size: 30px;text-align: center;">
                                    <br>
                                    Allopathic
                                </a>
                            </span>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <span class="book-now">
                                <a class="btn btn-sm btn-block" onclick="select_doctor_type(2);"
                                    style="width: 280px; height: 170px;background: #6DC982;color: white; font-size: 30px; text-align: center;">
                                    <br>
                                    Ayurvedic
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="get_illness"></div>
            <div class="explain_issue"></div>

        </div>
    </div>
</div>
<script>
function select_doctor_type(doctor_type) {
    $.ajax({
        type: "POST",
        url: "{{ route('frontend.upload_prescriptions.get_illness') }}",
        data: {
            "_token": "{{ csrf_token() }}",
            doctor_type: doctor_type
        },
        success: function(data) {
            $(".get_illness").html(data);
        }
    });
}
</script>
@include('frontend.include.footer')