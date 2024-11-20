@extends('layouts.app')
@section('content')
<style>
    .home-container {
        font-family: 'Times New Roman', Times, serif;
        margin: auto;
        text-align: center;
    }
    .sub-title h4{
        font-size: 18px;
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
        text-align: left;
        padding-right: 10px;
    }
    .details input {
        width: 100%;
        border: none;
        border-bottom: 1px solid black;
    }

    .details input{
        width: 400px;
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

</style>
<div class="home-container">
    <div class="heading">
        <div class="deped">
            <h4>Republic of the Philippines</h4>
            <h2>Department of Education</h2>
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
            <h4><strong>HOME VISITATION</strong></h4>
        </div>
    <form action="{{ route('admin.forms.download.customize.hv') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="content">
            <div class="date mb-3">
                <label for="date">Date:</label>
                <input class="form-control" type="date" name="date" id="date" style="border: none; border-bottom: 1px solid black;">
            </div>
            <div class="details">
                <label for="name">Name:</label>
                <select required name="student" id="student" class="form-select">
                    <option value="Juan C. Dela Cruz" selected disabled>Select Student</option>
                    @php
                    foreach ($students as $student) {
                        $name = ucwords($student->firstname . ' ' . $student->middlename . ' ' . $student->lastname . ' ' . $student->suffix);
                        echo "<option value=\"{$student->id}\">$name ({$student->email})</option>";
                    }
                    @endphp
                </select>
                <label for="name">Grade & Section:</label>
                <input readonly class="form-control" type="text" name="gradeSec" id="gradeSec">
                <label for="name">Address:</label>
                <input readonly class="form-control" type="text" name="address" id="address">
                <label for="name">Parent/Guardian:</label>
                <input readonly class="form-control" type="text" name="parGuar" id="parGuar">
                <label for="name">Contact Number:</label>
                <input readonly class="form-control" type="number" name="number" id="number">
                <label for="name">Date of Absences:</label>
                <input class="form-control" type="date" name="absence" id="absence" style="border: none; border-bottom: 1px solid black;">
            </div>
            <div>
                <h5 class="title">REASON:</h5>
                <div class="description">
                    <textarea name="problem" id="problem" style="width: 750px"></textarea>
                </div>
                <h5 class="title">ACTION TAKEN:</h5>
                <div class="description">
                    <textarea name="actionTaken" id="actionTaken" style="width: 750px"></textarea>
                </div>
                <h5 class="title">RECOMMENDATION:</h5>
                <div class="description">
                    <textarea name="recommendation" id="recommendation" style="width: 750px"></textarea>
                </div>
            </div>
            <h6 style="text-align:left; margin-top: 20px"><strong>Signature over Printed Name:</strong></h6>
            <div class="table-content">
                <table style="margin-top: 50px">
                    <tr>
                        <td><input readonly class="form-control" type="text" name="adviser" id="adviser"></td>
                        <td><input readonly class="form-control" type="text" name="parent" id="parent"></td>
                        <td><input readonly class="form-control text-capitalize" type="text" name="learner" id="learner" style="margin-right: 0;"></td>
                    </tr>
                    <tr>
                        <td><label for="adviser">ADVISER</label></td>
                        <td><label for="parent">PARENT</label></td>
                        <td><label for="learner" style="margin-right: 0;">LEARNER</label></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td><input class="form-control" type="text" name="ht" id="ht" style="margin-top: 50px; margin-right: 0;"></td>
                    </tr>
                    <tr>
                        <td><label for="ht" style="margin-right: 0;">HT in-Charge</label></td>
                    </tr>
                    <tr>
                        <td><input readonly class="form-control" type="text" name="coordinator" id="coordinator" style="margin-top: 50px; margin-right: 0;" value="ARLENE M. BALARIA"></td>
                    </tr>
                    <tr>
                        <td><label for="coordinator" style="margin-right: 0;">Guidance Coordinator</label></td>
                    </tr>
                </table>
            </div>
        </div>
        <button class="btn btn-primary mt-3" type="submit">Generate Home Visitation Form</button>
    </form>
</div>
<script>
    $(document).ready(function(){
        $('#student').on('change', function(){
            var id = $('#student').val();
            $.ajax({
                url: '{{ route("student.information", ["id" => ":id"]) }}'.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    if (response) {
                        $('#gradeSec').val(response.current_grade + ' - ' + response.current_section);
                        $('#address').val(response.house_no_street + ', ' + response.baranggay + ', ' + response.municipality + ', ' + response.province);
                        $('#parGuar').val(response.living_with);
                        $('#number').val(response.contact_no);
                        $('#adviser').val(response.adviser);
                        $('#parent').val(response.father + ' & ' + response.mother);
                        $('#learner').val(response.firstname + ' ' + response.middlename + ' ' + response.lastname)
                    } else {
                        console.log('No data found');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
@endsection

