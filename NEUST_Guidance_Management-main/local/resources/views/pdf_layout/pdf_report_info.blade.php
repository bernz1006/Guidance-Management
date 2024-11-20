<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .report-content {
        font-family: 'Times New Roman', Times, serif;
        margin: auto;
        /* text-align: center; */
    }
    .sub-title h4{
        font-size: 18px;
        margin-bottom: 0;
    }
    .deped{
        font-family: 'Old English Text MT', serif;
    }

    .table-title {
        margin: 0;
        margin-left: -30px;
        text-align: left;
    }

    .title {
        margin: 0;
        margin-left: -30px;
        text-align: left;
    }

    .table-container {
        margin: 1rem auto; /* Center the table-container */
        text-align: left;
        max-width: 100%; /* Set a maximum width for the table-container */
    }

    .table-container td{
        padding: 2px;
        width: 50%;
    }

    h5{
        padding: 2px;
        margin: 0;
    }

    .table-container td > span{
        border-bottom: 1px solid black;
        font-weight: bold;
        text-transform: capitalize;
    }

    .description p {
        border-bottom: 1px solid black;
        text-transform: capitalize;
        text-align: start;
        font-size: 14px;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .header h3,
    .header h4 {
        margin: 5px 0;
    }

    img {
        width: 100px;
        height: auto;
    }

    table{
        width: 100%;
        font-size: 14px;
    }

    tr{
        width: 100%;
    }

    td{
        width: 50%;
    }

</style>
<body>
    <div class="report-form-container">
        <div class="report-content container">
            <div class="header">
                <img src="{{ asset('img/logo.png') }}" alt="School Logo" style="float:left;">
                <img src="{{ asset('img/logo2.png') }}" alt="Second Logo" style="float:right;">
                <h4>Republic of the Philippines</h4>
                <h4>Region III</h4>
                <h4>Division of Nueva Ecija</h4>
                <h3>Bongabon National High School</h3>
                <h4>Bongabon, Nueva Ecija</h4>
            </div>
            <br>
            <div class="content">
                <div class="title">
                    <h5><b>I. IDENTIFYING INFORMATION</b></h5>
                </div>
                <div class="table-title">
                    <h5><b>A. VICTIM</b></h5>
                </div>
                    <div class="table-container">
                        <table>
                            <tr>
                                <td>Name: <span id="victim_name" style="width: 273px;">{{ $victim_name }}</span></td>
                                <td>Signature: <span style="text-decoration: underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                            </tr>
                            <tr>
                                <td>Age: <span id="victim_age" style="width: 285px;">{{ $victim_age }}</span></td>
                                <td>Gender: <span id="victim_gender" style="width: 215px;">{{ $victim_gender }}</span></td>
                            </tr>
                            <tr>
                                <td>Grade & Section:
                                    <span id="victim_grade" style="width: 215px;">{{ $victim_grade }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Parents/Guardian: <span id="victim_parent_guardian">{{ $victim_parent_guardian }}</span></td>
                                <td>Signature: <span style="text-decoration: underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                            </tr>
                            <tr>
                                <td>Contact no: <span id="victim_parent_contact" style="width: 242px;">{{ $victim_parent_contact }}</span></td>
                            </tr>
                            <tr>
                                <td>Class Adviser: <span id="victim_class_adviser" style="width: 225px;">{{ $victim_class_adviser }}</span></td>
                                <td>Signature: <span style="text-decoration: underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                            </tr>
                        </table>
                    </div>
                <div class="table-title">
                    <h5><b>B. COMPLAINANT</b></h5>
                </div>
                <div class="table-container">
                    <table class="w-100">
                        <tr>
                            <td>Name: <span id="complainant_name" style="width: 273px;">{{ $complainant_name }}</span></td>
                            <td>Signature: <span style="text-decoration: underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                        </tr>
                        <tr>
                            <td>Address: <span id="complainant_address" style="width: 260px;">{{ $complainant_address }}</span></td>
                        </tr>
                        <tr>
                            <td>Contact no: <span id="complainant_contact" style="width: 242px;">{{ $complainant_contact }}</span></td>
                        </tr>
                        <tr>
                            <td>Relation to the Victim: <span id="relation_to_victim" style="width: 173px;">{{ $relation_to_victim }}</span></td>
                        </tr>
                    </table>
                </div>
                <div class="table-title">
                    <h5><b>C. OFFENDER/S</b></h5>
                </div>
                <div class="table-container">
                    <table class="w-100">
                        <tr>
                            <td>Name: <span id="offender_name" style="width: 273px;">{{ $offender_name }}</span></td>
                            <td>Signature: <span style="text-decoration: underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                        </tr>
                        <tr>
                            <td>Age: <span id="offender_age" style="width: 285px;">{{ $offender_age }}</span></td>
                            <td>Gender: <span id="offender_gender" style="width: 215px;">{{ $offender_gender }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Grade & Section:
                                <span id="offender_grade" style="width: 215px;">{{ $offender_grade }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Parents/Guardian: <span id="offender_parent_guardian">{{ $offender_parent_guardian }}</span></td>
                            <td>Signature: <span style="text-decoration: underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                        </tr>
                        <tr>
                            <td>Contact no: <span id="offender_parent_contact" style="width: 242px;">{{ $offender_parent_contact }}</span></td>
                        </tr>
                        <tr>
                            <td>Class Adviser: <span id="offender_class_adviser" style="width: 225px;">{{ $offender_class_adviser }}</span></td>
                            <td>Signature: <span style="text-decoration: underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <h5 class="title"><b>II. PROBLEM PRESENTED</b></h5>
                    <div class="description">
                        <p id="main_concern">{{ $main_concern }}</p>
                    </div>
                    <h5 class="title"><b>Action Taken:</b></h5>
                    <div class="description">
                        <p id="action_taken">{{ $action_taken }}</p>
                    </div>
                    <h5 class="title"><b>Recommendation:</b></h5>
                    <div class="description">
                        <p id="recommendation">{{ $recommendation }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
