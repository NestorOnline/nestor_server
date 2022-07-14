<table class="table table-bordered table-striped">
    <thead>
        <tr>
            @if($patient_detail->Patient_Name)
            <th>Patient Name</th>
            @endif
            @if($patient_detail->Patient_Age)
            <th>Patient Age</th>
            @endif
            @if($patient_detail->Sex)
            <th>Sex</th>
            @endif
            @if($patient_detail->Mobile_No)
            <th>Mobile No</th>
            @endif
        </tr>
        <tr>
            @if($patient_detail->Patient_Name)
            <td>{{$patient_detail->Patient_Name}}</td>
            @endif
            @if($patient_detail->Patient_Age)
            <td>{{$patient_detail->Patient_Age}}</td>
            @endif
            @if($patient_detail->Sex)
            <td>{{$patient_detail->Sex}}</td>
            @endif
            @if($patient_detail->Mobile_No)
            <td>{{$patient_detail->Mobile_No}}</td>
            @endif
        </tr>

        <tr>
            @if($patient_detail->Food_Allergies)
            <th>Food Allergies</th>
            @endif
            @if($patient_detail->Tendency_Bleed)
            <th>Tendency Bleed</th>
            @endif
            @if($patient_detail->Heart_Disease)
            <th>Heart Disease</th>
            @endif
            @if($patient_detail->High_Blood_Pressure)
            <th>High Blood Pressure</th>
            @endif
        </tr>
        <tr>
            @if($patient_detail->Food_Allergies)
            <td>{{$patient_detail->Food_Allergies}}</td>
            @endif
            @if($patient_detail->Tendency_Bleed)
            <td>{{$patient_detail->Tendency_Bleed}}</td>
            @endif
            @if($patient_detail->Heart_Disease)
            <td>{{$patient_detail->Heart_Disease}}</td>
            @endif
            @if($patient_detail->High_Blood_Pressure)
            <td>{{$patient_detail->High_Blood_Pressure}}</td>
            @endif
        </tr>

        <tr>
            @if($patient_detail->Diabetic)
            <th>Diabetic</th>
            @endif
            @if($patient_detail->Surgery)
            <th>Surgery</th>
            @endif
            @if($patient_detail->Accident)
            <th>Accident</th>
            @endif
            @if($patient_detail->Otders)
            <th>Others</th>
            @endif
        </tr>
        <tr>
            @if($patient_detail->Diabetic)
            <td>{{$patient_detail->Diabetic}}</td>
            @endif
            @if($patient_detail->Surgery)
            <td>{{$patient_detail->Surgery}}</td>
            @endif
            @if($patient_detail->Accident)
            <td>{{$patient_detail->Accident}}</td>
            @endif
            @if($patient_detail->Otders)
            <td>{{$patient_detail->Otders}}</td>
            @endif
        </tr>
        <tr>
            @if($patient_detail->Family_Medical_History)
            <th>Family Medical History</th>
            @endif
            @if($patient_detail->Current_Medication)
            <th>Current Medication</th>
            @endif
            @if($patient_detail->Female_Pregnancy)
            <th>Female Pregnancy</th>
            @endif
            @if($patient_detail->Breast_Feeding)
            <th>Breast Feeding</th>
            @endif
        </tr>
        <tr>
            @if($patient_detail->Family_Medical_History)
            <td>{{$patient_detail->Family_Medical_History}}</td>
            @endif
            @if($patient_detail->Current_Medication)
            <td>{{$patient_detail->Current_Medication}}</td>
            @endif
            @if($patient_detail->Female_Pregnancy)
            <td>{{$patient_detail->Female_Pregnancy}}</td>
            @endif
            @if($patient_detail->Breast_Feeding)
            <td>{{$patient_detail->Breast_Feeding}}</td>
            @endif
        </tr>
    </thead>
</table>