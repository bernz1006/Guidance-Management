@extends('layouts.app')
@section('content')

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
    }

    .certificate-header h2,
    .certificate-header h4 {
        margin: 5px 0;
        line-height: 1.2;
    }

    .certificate-header h2 {
        font-size: 24px;
    }

    .certificate-header h4 {
        font-size: 18px;
    }

    .certificate-body {
        margin-top: 20px;
        text-align: left;
        font-size: 16px;
        line-height: 1.5;
    }

    .certificate-body h1 {
        font-size: 28px;
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
</style>

<div class="gm-container">
    <form action="{{ route('admin.forms.download.customize.gm') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="certificate-header text-center">
            <div class="deped">
                <h4>Republic of the Philippines</h4>
                <h2>Department of Education</h2>
            </div>
            <div class="sub-title">
                <h4>Region III - Central Luzon</h4>
                <h4>Schools Division Office of Nueva Ecija</h4>
                <h4>Bongabon National High School</h4>
                <h4>Sinipit, Bongabon, Nueva Ecija</h4>
            </div>
        </div>
        <div class="certificate-body">
            <h1>CERTIFICATION</h1>
            <p>TO WHOM IT MAY CONCERN:</p>
            <p>
                This is to certify that as per records filed in this Office,
                <select required name="student" id="student" class="form-select">
                    <option value="Juan C. Dela Cruz" disabled selected>Select Student</option>
                    @php
                    foreach ($students as $student) {
                        $name = ucwords($student->firstname . ' ' . $student->middlename . ' ' . $student->lastname . ' ' . $student->suffix);
                        echo "<option value=\"{$student->id}\">$name ({$student->email})</option>";
                    }
                    @endphp
                </select>
                completed Junior High School in this school during SY
                <input readonly type="text" name="school_year" value="{{ $info['school_year'] }}">.
            </p>
            <p>
                This further certifies that he/she is of good moral character and
                has not committed any violation of school rules and regulations
                during his/her stay in this school.
            </p>
            <p>
                This certification is issued this
                <input readonly type="text" name="day" value="{{ $info['date_day'] . $info['date_day_superscript'] }}" size="2" /> day of
                <input readonly type="text" name="month" value="{{ $info['date_month'] }}" size="8" />,
                <input readonly type="text" name="year" value="{{ $info['date_year'] }}" size="4" /> for reference purposes.
            </p>
        </div>
        <div class="certificate-footer">
            <div class="signature">
                <strong>ADOR B. DELA CRUZ</strong>
                <span>School Principal IV</span>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Generate Good Moral Certificate</button>
    </form>
</div>

@endsection
