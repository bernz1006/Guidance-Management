<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Visitation Form</title>
</head>
<style>
    .home-container {
        font-family: 'Times New Roman', Times, serif;
        margin: auto;
        text-align: center;
    }
    .sub-title h4{
        font-size: 15px;
        margin-bottom: 0;
    }
    .deped{
        font-family: 'Old English Text MT', serif;
    }
    .date{
        /* text-align: right; */
        margin-left: 500px;
    }

    .details {
        display: grid;
        grid-template-columns: auto 1fr;
        /* gap: 10px; */
        padding-bottom: 20px;
    }
    .details label {
        padding-right: 10px;
    }

    .title{
        text-align: left;
    }

    .table-content {
        text-align: center;
    }

    .table-content table {
        margin: auto;
    }

    .table-content input {
        margin-right: 50px;
        border: none;
        border-bottom: 1px solid black;
    }
    .table-content label {
        margin-right: 50px;
    }

    img {
        width: 80px;
        height: auto;
    }

    .deped > *, .sub-title > *, .details > *{
        margin: 0;
        padding: 0;
    }

    .details > p{
        width: 100%;
        text-align: start;
    }

    .description > h5{
        margin: 0;
        padding: 0;
    }
    .description > p{
        text-align: left;
    }


</style>
<body>
    <div class="home-container">
        <div class="heading">
            <div class="deped">
                <img src="{{ asset('img/logo2.png') }}" alt="School Logo">
                <h4>Republic of the Philippines</h4>
                <h3>Department of Education</h3>
            </div>
            <div class="sub-title">
                <h4 >REGION III - CENTRAL LUZON</h4>
                <h4>SCHOOLS DIVISION OFFICE OF NUEVA ECIJA</h4>
                <h4>BONGABON NATIONAL HIGHSCHOOL</h4>
                <h4>SINIPIT, BONGABON, NUEVA ECIJA</h4>
            </div>
        </div>
        <br>
            <div>
                <h4 style="margin-top: 0; padding: 0;"><strong>HOME VISITATION</strong></h4>
            </div>
        <div class="content">
            <div class="date mb-3">
                <label for="date">Date: <span style="text-decoration: underline;">{{ $current_date }}</span></label>
            </div>
            <div class="details" style="text-align: left;">
                <p>Name: <span style="text-decoration: underline; width:100%;">{{ $name }}</span></p>
                <p>Grade & Section: <span style="text-decoration: underline; width:100%;">{{ $gradeSec }}</span></p>
                <p>Address: <span style="text-decoration: underline; width:100%;">{{ $address }}</span></p>
                <p>Parent/Guardian: <span style="text-decoration: underline; width:100%;">{{ $parGuar }}</span></p>
                <p>Contact Number: <span style="text-decoration: underline; width:100%;">{{ $number }}</span></p>
                <p>Date of Absences: <span style="text-decoration: underline; width:100%;">{{ $absence }}</span></p>
            </div>
            <div>
                <div class="description">
                    <h5 class="title">REASON:</h5>
                    <p style="text-decoration: underline">{{ $problem }}</p>
                </div>
                <div class="description">
                    <h5 class="title">ACTION TAKEN:</h5>
                    <p style="text-decoration: underline">{{ $actionTaken }}</p>
                </div>
                <div class="description">
                    <h5 class="title">RECOMMENDATION:</h5>
                    <p style="text-decoration: underline">{{ $recommendation }}</p>
                </div>
            </div>
            <h5 style="text-align:left; margin-top: 20px"><strong>Signature over Printed Name:</strong></h5>
            <div class="table-content">
                <table style="margin-top: 15px">
                    <tr>
                        <td><input class="form-control" type="text" name="adviser" id="adviser" value="{{ $adviser }}"></td>
                        <td><input class="form-control" type="text" name="parent" id="parent" value="{{ $parent }}"></td>
                        <td><input class="form-control" type="text" name="learner" id="learner" style="margin-right: 0;" value="{{ $learner }}"></td>
                    </tr>
                    <tr>
                        <td><label for="adviser">ADVISER</label></td>
                        <td><label for="parent">PARENT</label></td>
                        <td><label for="learner" style="margin-right: 0;">LEARNER</label></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td><input class="form-control" type="text" name="ht" id="ht" style="margin-top: 30px; margin-right: 0;" value="{{ $ht }}"></td>
                    </tr>
                    <tr>
                        <td><label for="ht" style="margin-right: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HT in-Charge</label></td>
                    </tr>
                    <tr>
                        <td><input class="form-control" type="text" name="coordinator" id="coordinator" style="margin-top: 30px; margin-right: 0; text-align: center; font-weight: bold;" value="ARLENE M. BALARIA"></td>
                    </tr>
                    <tr>
                        <td><label for="coordinator" style="margin-right: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guidance Coordinator</label></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

