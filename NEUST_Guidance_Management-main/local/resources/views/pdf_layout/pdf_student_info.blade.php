<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
            background-color: transparent;
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

        .header h3,
        .header h4 {
            margin: 5px 0;
        }

        img {
            width: 100px;
            height: auto;
        }

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
        td {
            width: 50%;
            padding: 10px;
            border-color: #6cbe1a;
        }
        th{
            border-color: #6cbe1a;
        }
        input[type="text"] {
            width: 80%;
            box-sizing: border-box;
        }

        span{
            font-weight: bold;
            text-transform: capitalize;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="header">
            <img src="{{ asset('img/logo.png') }}" alt="School Logo" style="float:left;">
            <img src="{{ asset('img/logo2.png') }}" alt="Second Logo" style="float:right;">
            <h4>Republic of the Philippines</h4>
            <h4>Region III</h4>
            <h4>Division of Nueva Ecija</h4>
            <h3 style="color: #6cbe1a">Bongabon National High School</h3>
            <h4>Bongabon, Nueva Ecija</h4>
        </div>

        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ $student_img }}" alt="Student Image" width="120" height="120" style="object-fit: cover;">
        </div>

        <table class="profile-table">
            <tr>
                <td>
                    <label for="name">Name: <span>{{ $name }}</span></label>
                </td>
                <td>
                    <label for="lrn">LRN: <span>{{ $lrn }}</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="address">Address: <span>{{ $house_no_street }}, {{ $baranggay }}, {{ $municipality }}, {{ $province }}</span></label>
                </td>
                <td>
                    <label for="contact">Contact No: <span>{{ $contact_no }}</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="birthday">Birthday: <span>{{ $birthday }}</span></label>
                </td>
                <td>
                    <label for="age">Age: <span>{{ $age }}</span></label>
                    <label for="sex">Sex: <span>{{ $sex }}</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="nationality">Nationality: <span>{{ $nationality }}</span></label>
                </td>
                <td>
                    <label for="religion">Religion: <span>{{ $religion }}</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="father">Father: <span>{{ $father }}</span></label>
                </td>
                <td>
                    <label for="father-occupation">Occupation: <span>{{ $father_occupation }}</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="mother">Mother: <span>{{ $mother }}</span></label>
                </td>
                <td>
                    <label for="mother-occupation">Occupation: <span>{{ $mother_occupation }}</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="living-with">Living with whom: <span>{{ $living_with }}</span></label>
                </td>
                <td>
                    <label for="siblings">No. of siblings: <span>{{ $no_of_siblings }}</span></label>
                    <label style="float: right" for="position">Position: <span>{{ $position }}</span></label>
                </td>
            </tr>
            <tr>
                <th colspan="2" style="text-align: center;">EDUCATIONAL BACKGROUND</th>
            </tr>
            <tr>
                <td colspan="2">
                    <label for="elementary">Elementary School Graduate: <span>{{ $elem_school }}</span></label>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label for="grade-level">Last Grade Level Completed: <span>{{ $last_grade }}</span></label>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label for="school-address">School Address: <span>{{ 'BNHS-SINIPIT,BONGABON,N.E' }}</span></label>
                    <label for="school-id" style="float: right">School ID: <span>{{ $school_id }}</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="school-year">School Year:</label>
                </td>
                <td>
                    <label for="gen-ave">Gen. Ave: <span>{{ $gen_average }}</span></label>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label for="grade-section">Grade Level & Section: <span>{{ $current_grade }} - {{ $current_section }}</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="next-school-year">School Year:</label>
                </td>
                <td>
                    <label for="adviser">Adviser: <span>{{ $adviser }}</span></label>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
