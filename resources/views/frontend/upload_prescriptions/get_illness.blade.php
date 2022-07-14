<div class="col-md-12">
    <br><br>
    <div class="container">
        <div class="row">
            @foreach($doctor_specialization_types as $doctor_specialization_type)

            <div class="col-md-4">

                <center>
                    <h2>{{$doctor_specialization_type->Specialization_Type_Name	}}</h2>
                </center>
                <div class="row">
                    <div class="container"
                        style="background-color: white;border: 2px #e1e1d0 solid; border-radius: 10px;">

                        @foreach($doctor_specialization_type->doctor_specializations as $doctor_specialization)
                        <div class="col-md-4 col-sm-3 col-xs-3">
                            <a href="javascript:void(0);
" onclick="select_illness({{$doctor_specialization->id}});">
                                <div class="cat-img-div-top">
                                    <img src="{{asset($doctor_specialization->icon_image)}}" alt="">
                                </div>
                                <div class="health-detail">
                                    <p class="text-center">
                                        <center>
                                            {{$doctor_specialization->Specialization_Name}}
                                        </center>
                                    </p>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


<script>
function select_illness(doctor_specialization_id) {
    $.ajax({
        type: "POST",
        url: "{{ route('frontend.upload_prescriptions.explain_issue') }}",
        data: {
            "_token": "{{ csrf_token() }}",
            doctor_specialization_id: doctor_specialization_id
        },
        success: function(data) {
            $(".explain_issue").html(data);
        }
    });
}
</script>