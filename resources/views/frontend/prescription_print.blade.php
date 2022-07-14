<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nestor Invoice</title>
</head>

<body style="
    width: 600px;
    margin: 30px auto;
    border: 1px solid #e5e5e5;
    padding: 10px;
    font-size: 14px;font-family: sans-serif;
">
    <div>

        <table width="100%" style="font-family: sans-serif;" cellpadding="10">
            <tbody>
                <tr>
                    <td> <strong>NESTOR PHARMACEUTICALS LIMITED</strong>
                        <br>S-22/14, DLF PHASE-3
                        <br>GURUGRAM-122010
                        <br>PHONE NO. 0124-4045132,4045162
                        <br>EMAIL:info@nestorpharmaceuticals.com
                        <br>www.nestorpharma.com
                    </td>
                    <td colspan="2"><strong> <a href="#" target="_blank"><img src="{{asset('img/nestor_logo.png')}}"
                                    width="70" height="" alt="Logo" align="right" border="0"></a></strong></td>

                </tr>
            </tbody>
        </table>
        <hr>
        <table width="100%" style="font-family: sans-serif;" cellpadding="10">
            <tbody>
                <tr>
                    <td align="left"><strong>Dr. Anurag Sharma</strong></td>
                    <td align="right">
                        <strong>Prescription No.:</strong>
                    </td>
                    <td>
                        <strong> {{$doctor_appointment->id}}</strong>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td align="right">
                        <strong>Date:</strong>
                    </td>
                    <td>
                        <strong> {{$doctor_appointment->created_at->format('d-M-Y')}}</strong>
                    </td>

                </tr>
            </tbody>
        </table>
        <hr>
        <table width="100%" style="font-family: sans-serif; font-size: 14px;">
            <tbody>
                <tr>
                    <td>

                        <table width="100%" align="right"
                            style="font-family: sans-serif;font-size: 14px;border-collapse: collapse;">
                            <tbody>
                                <tr>
                                    <td style="border: 1px #eee solid;padding: 8px 10px;line-height: 20px;">
                                        <strong>Patient Name</strong>
                                    </td>
                                    <?php
$patient_detail = \App\PatientDetail::find($doctor_appointment->patient_detail_id);
?>
                                    <td style="border: 1px #eee solid;padding: 8px 10px;line-height: 20px;">
                                        {{$patient_detail->Patient_Name}}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px #eee solid;padding: 8px 10px;line-height: 20px;"><strong>
                                            Age</strong></td>
                                    <td style="border: 1px #eee solid;padding: 8px 10px;line-height: 20px;">
                                        {{$patient_detail->Patient_Age}} year</td>
                                </tr>
                                <tr>
                                    <td style="border: 1px #eee solid;padding: 8px 10px;line-height: 20px;">
                                        <strong>Address</strong>
                                    </td>
                                    <td style="border: 1px #eee solid;padding: 8px 10px;line-height: 20px;">

                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 1px #eee solid;padding: 8px 10px;line-height: 20px;">
                                        <strong>Symptoms</strong>
                                    </td>
                                    <td style="border: 1px #eee solid;padding: 8px 10px;line-height: 20px;">
                                        {{$doctor_appointment->symptoms}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="items" width="100%" style="font-size: 14px;border-collapse: collapse;" cellpadding="8">
            <thead>
                <tr>
                    <td width="15%" style="text-align: left;border:1px solid #e5e5e5"><strong>S. No.</strong></td>
                    <td width="45%" style="text-align: left;border:1px solid #e5e5e5"><strong>Medicine Name</strong>
                    </td>
                    <td width="20%" style="text-align: left;border:1px solid #e5e5e5"><strong>Dosage</strong></td>
                    <td width="20%" style="text-align: left;border:1px solid #e5e5e5"><strong>Duration</strong></td>
                    <td width="20%" style="text-align: left;border:1px solid #e5e5e5"><strong>No. Of Days</strong></td>
                </tr>
            </thead>
            <tbody>
                @foreach($doctor_appointment->doctor_prescription_products as
                $key=>$doctor_prescription_product)
                <tr>
                    <td style="padding: 5px 10px; line-height: 20px; border:1px solid #e5e5e5">{{$key+1}}</td>
                    <td style="padding: 5px 10px; line-height: 20px; border:1px solid #e5e5e5">
                        {{$doctor_prescription_product->product->generic_name}}

                        ({{$doctor_prescription_product->product->brand_name}})
                    </td>
                    <td style="padding: 5px 10px; line-height: 20px; border:1px solid #e5e5e5">
                        @if($doctor_prescription_product->doctor_prescription_abbreviation_doses)
                        {{$doctor_prescription_product->doctor_prescription_abbreviation_doses->abbreviation_code}}
                        <br>({{$doctor_prescription_product->doctor_prescription_abbreviation_doses->description}})
                        @endif
                    </td>
                    <td style="padding: 5px 10px; line-height: 20px; border:1px solid #e5e5e5">
                        @if($doctor_prescription_product->doctor_prescription_abbreviation_takes)
                        {{$doctor_prescription_product->doctor_prescription_abbreviation_takes->abbreviation_code}}
                        <br> ( {{$doctor_prescription_product->doctor_prescription_abbreviation_takes->description}})
                        @endif
                    </td>
                    <td style="padding: 5px 10px; line-height: 20px; border:1px solid #e5e5e5">
                        {{$doctor_prescription_product->no_of_day}}
                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>
        <br>
        <table width="100%" style="font-family: sans-serif; font-size: 14px;">
            <tbody>
                <tr>
                    <td>
                        <table width="60%" align="left" style="font-family: sans-serif; font-size: 14px;">
                            <tbody>
                                <tr>
                                    <td style="padding: 0px; line-height: 20px;">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <br><br>
        <table width="100%" style="font-family: sans-serif; font-size: 14px;">
            <tbody>
                <tr>
                    <td>
                        <table width="100%" align="left"
                            style="font-family: sans-serif; font-size: 13px; text-align: center;">
                            <tbody>
                                <tr>
                                    <td style="padding: 0px; line-height: 20px; width:50%">
                                        <strong>Tel: 0124-4045132 | 0124-4045162</strong>
                                    </td>
                                    <td style="padding: 0px; line-height: 20px; width:50%">
                                        <strong> Email: info@nestorpharmaceuticals.com</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

</body>

</html>