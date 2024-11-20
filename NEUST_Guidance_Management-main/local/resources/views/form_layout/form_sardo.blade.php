<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SARDO</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            /* padding: 5px; */
            text-align: left;
        }

        .profile-container {
            background-color: #FFFFFF;
            border-radius: 15px;
            padding: 40px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .sub-title h5,
        .deped h5 {
            margin: 5px 0;
        }

        /* .header img {
            width: 60px;
            height: auto;
        } */

        @media print {
            .profile-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
                border-radius: 0;
            }

            .profile-table td input {
                border: none;
                border-bottom: 1px solid #000;
            }
        }
        table {
            width: 100%;
            table-layout: fixed;
        }
        td,th {
            width: 50%;
            padding: 10px;
            text-align: center;
        }
        input[type="text"] {
            width: 80%;
            box-sizing: border-box;
        }
        .certificate-footer {
        margin-top: 40px;
        text-align: left;
    }
    .certificate-footer .signature {
        display: inline-block;
        margin-top: 20px;
        text-align: center;
    }
    .certificate-footer .signature strong {
        border-bottom: 2px solid black;
    }

    img {
        width: 100px;
        height: auto;
    }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="header">
            <div class="deped">
                <img src="{{ asset('img/logo.png') }}" style="float:left;">
                <img src="{{ asset('img/deped.png') }}" style="float:right;">
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

        <div style="text-align: center; margin-bottom: 20px;">
            <h2>SARDO-STUDENTS AT RISK OF DROPPING-OUT</h2>
        </div>

        <table class="profile-table">
            <tr>
                <th style="background-color: #f6bc50">Grade Level</th>
                <th style="background-color: #b9c873">No. of Under SARDO</th>
            </tr>
            <tr>
                <td>Grade 7</td>
                <td>{{ $grade_id_1 }}</td>
            </tr>
            <tr>
                <td>Grade 8</td>
                <td>{{ $grade_id_2 }}</td>
            </tr>
            <tr>
                <td>Grade 9</td>
                <td>{{ $grade_id_3 }}</td>
            </tr>
            <tr>
                <td>Grade 10</td>
                <td>{{ $grade_id_4 }}</td>
            </tr>
            <tr>
                <td>Total</td>
                <td></td>
            </tr>
        </table>

        <div class="certificate-footer">
            <p>Prepared by:</p>
            <div class="signature">
                <strong>ARLENE M. BALARIA</strong><br>
                <span>Guidance Councilor</span>
            </div>
        </div>
    </div>
</body>
</html>
