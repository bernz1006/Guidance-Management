<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .travel-container {
        font-family: "Times New Roman", Times, serif;
        margin: auto;
        /* text-align: center; */
    }

    .heading{
        text-align: center;
    }

    .sub-title h4 {
        font-size: 15px;
        margin-bottom: 0;
    }

    .deped {
        font-family: "Old English Text MT", serif;
    }

    .content {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .letter {
        margin-bottom: 20px;
    }

    .yours,
    .adviser,
    .recom,
    .guidance,
    .note,
    .headT,
    .approve,
    .principal {
        width: 50%;
        margin-bottom: 20px;
    }

    .right-align {
        text-align: right;
    }

    .left-align {
        text-align: left;
    }

    .center-align {
        text-align: center;
    }

    .adviser,
    .headT {
        width: auto;
        margin-left: auto;
        margin-right: 0;
    }

    .principal {
        width: auto;
        margin: 0 auto;
    }

    input[type="text"],
    input[type="number"] {
        border: none;
        border-bottom: 1px solid black;
        width: 200px;
    }

    /* .travel-container {
        background-color: #FFFFFF;
        border-radius: 15px;
        padding: 40px;
        margin: 0;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    } */
    .custom-container {
        padding: 40px;
        margin: 0 auto;
        max-width: 800px;
        box-sizing: border-box;
    }
    img {
        width: 80px;
        height: auto;
    }
    .deped > *, .sub-title > *, .hh > *{
        margin: 0;
        padding: 0;
    }

    .hh > *, .letter > * {
        text-align: left;
    }

    table{
        width: 100%;
    }

    .gg tr{
        width: 100%;
    }

    .gg td{
        width: 50%;
    }

</style>
<body>
    <div class="travel-container">
        <div class="heading">
            <div class="deped">
                <img src="{{ asset('img/logo2.png') }}" alt="School Logo">
                <h4>Republic of the Philippines</h4>
                <h3>Department of Education</h3>
            </div>
            <div class="sub-title">
                <h4>REGION III - CENTRAL LUZON</h4>
                <h4>SCHOOLS DIVISION OFFICE OF NUEVA ECIJA</h4>
                <h4>BONGABON NATIONAL HIGHSCHOOL</h4>
                <h4>SINIPIT, BONGABON, NUEVA ECIJA</h4>
            </div>
        </div>
        <br />
        <div class="content">
            <div>
                <h4 style="margin-top: 0; padding: 0; text-align: center;"><strong>TRAVEL ORDER</strong></h4>
            </div>
            <div class="hh" style="margin-bottom: 30px;">
                <p><strong>ELADIO R. SANTIAGO, PhD</strong></p>
                <p>School Principal IV</p>
                <p>Bongabon National High School</p>
                <p>Bongabon, Nueva Ecija</p>
            </div>
            <div class="letter" style="margin-bottom: 50px;">
                <p style="margin-bottom: 50px;">Sir :</p>
                <p style="text-indent: 50px;">
                    I have the honor to request permission to travel to
                    <input type="text" name="where" id="where" value="{{ $where }}" />
                </p>
                <p>
                    to conduct Home Visitation on
                    <input type="text" name="when" id="when"  value="{{ $when }}"/> at
                    <input type="text" name="hours" id="hours" value="{{ $hours }}"/> am/pm.
                </p>
            </div>
            <table class="gg">
                <tr>
                    <td></td>
                    <td>
                        <div class="adviser" style="text-align: center;">
                            <p>Very truly yours,</p>
                            <p style="text-decoration: underline; padding:0; margin:0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $adviser }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                            <p style="padding:0; margin:0;">Adviser</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="recom">Recommending Approval:</div>
                        <div class="guidance">
                            <table>
                                <tr>
                                    <td><strong>ARLENE M BALARIA</strong></td>
                                </tr>
                                <tr>
                                    <td><label for="guidance">Guidance Coordination</label></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <div class="adviser" style="text-align: center;">
                            <p style="text-align: left">Noted:</p>
                            <p style="text-decoration: underline; padding:0; margin:0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $headT }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                            <p style="padding:0; margin:0;">Head Teacher</p>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="principal">
                <table style="text-align: center;">
                    <tr>
                        <td style="padding: 20px;">Approved:</td>
                    </tr>
                    <tr>
                        <td><strong>ELADIO R. SANTIAGO, PhD</strong></td>
                    </tr>
                    <tr>
                        <td><label for="principal">School Principal IV</label></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
