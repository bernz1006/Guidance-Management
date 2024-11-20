<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Good Moral Certificate</title>
</head>
<style>
    .gm-container {
        background-color: #FFFFFF;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        max-width: 800px;
        margin: auto;
    }

    .certificate-header {
        margin-bottom: 20px;
        text-align: center;
    }

    .certificate-header h5 {
        margin: 5px 0;
        line-height: 1.2;
    }

    .certificate-body {
        margin-top: 20px;
        text-align: left;
        font-size: 16px;
        line-height: 1.5;
    }

    .certificate-body h2 {
        margin-bottom: 20px;
        letter-spacing: 2px;
        text-align: center;
    }

    .certificate-body p {
        margin-bottom: 20px;
    }

    .certificate-body input {
        border: none;
        border-bottom: 1px solid black;
        background: none;
        font-family: inherit;
        font-size: inherit;
        width: auto;
        text-align: center;
    }

    .certificate-footer {
        margin-top: 40px;
        text-align: right;
        margin-right: 50px;
    }

    .certificate-footer .signature {
        display: inline-block;
        margin-top: 20px;
        text-align: center;
    }

    .certificate-footer .signature strong {
        display: block;
        margin-top: 50px;
        border-top: 1px solid black;
    }

    p{
        line-height: 1.8;
    }

    @media print {
        .gm-container {
            border: none;
            box-shadow: none;
            padding: 0;
        }

        .certificate-body input {
            border: none;
            border-bottom: 1px solid black;
        }
    }

    img {
            width: 100px;
            height: auto;
    }
</style>
<body>
    <div class="gm-container">
        <div class="certificate-header">
            <div class="deped">
                <img src="{{ asset('img/logo.png') }}" alt="School Logo" style="float:left;">
                <img src="{{ asset('img/deped.png') }}" alt="Second Logo" style="float:right;">
                <h5>Republic of the Philippines</h5>
                <h5>Department of Education</h5>
            </div>
            <div class="sub-title">
                <h5>Region III - Central Luzon</h5>
                <h5>Schools Division Office of Nueva Ecija</h5>
                <h3>Bongabon National High School</h3>
                <h5>Sinipit, Bongabon, Nueva Ecija</h5>
            </div>
        </div>
        <div class="certificate-body">
            <h2>CERTIFICATION</h2>
            <p>TO WHOM IT MAY CONCERN:</p>
            <p style="text-indent: 20px;">
                This is to certify that as per records filed in this Office, <span style="text-decoration: underline;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> completed Junior High School
                in this school during SY <span>{{ $school_year }}</span>.
            </p>
            <p style="text-indent: 20px;">
                This further certifies that he/she is of good moral character and
                has not committed any violation of school rules and regulations
                during his/her stay in this school.
            </p>
            <p style="text-indent: 20px;">
                This certification is issued this
                <span>{{ $date_day }}<sup>{{ $date_day_superscript }}</sup></span> day of
                <span>{{ $date_month }}</span>,
                <span>{{ $date_year }}</span> for reference purposes.
            </p>
        </div>
        <div class="certificate-footer">
            <div class="signature">
                <strong>ADOR B. DELA CRUZ</strong>
                <span>School Principal IV</span>
            </div>
        </div>
    </div>
</body>
</html>
