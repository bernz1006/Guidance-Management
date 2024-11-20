@extends('layouts.app')
@section('content')
<style>
    .travel-container {
        font-family: "Times New Roman", Times, serif;
        margin: auto;
        text-align: center;
    }

    .sub-title h4 {
        font-size: 18px;
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
</style>


<div class="travel-container">
    <div class="heading">
        <div class="deped">
            <h4>Republic of the Philippines</h4>
            <h2>Department of Education</h2>
        </div>
        <div class="sub-title">
            <h4>REGION III - CENTRAL LUZON</h4>
            <h4>SCHOOLS DIVISION OFFICE OF NUEVA ECIJA</h4>
            <h4>BONGABON NATIONAL HIGHSCHOOL</h4>
            <h4>SINIPIT, BONGABON, NUEVA ECIJA</h4>
        </div>
    </div>
    <br />
    <form action="{{ route('admin.forms.download.customize.tf') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="content">
            <div>
                <h4><strong>TRAVEL FORM</strong></h4>
            </div>
            <div style="width: 100%; text-align: left;">
                <p style="margin: 0; padding: 0;"><strong>ELADIO R. SANTIAGO, PhD</strong></p>
                <p style="margin: 0; padding: 0;">School Principal IV</p>
                <p style="margin: 0; padding: 0;">Bongabon National High School</p>
                <p style="margin: 0; padding: 0;">Bongabon, Nueva Ecija</p>
                <br />
                <p>Sir</p>
            </div>
            <div class="letter">
                <p>
                    I have the honor to request permission to travel to
                    <input required type="text" class="" name="where" id="where" />
                </p>
                <p>
                    to conduct Home Visitation on
                    <input required type="date" class="" name="when" id="when" /> at
                    <input required type="time" class="" name="hours" id="hours" />
                </p>
            </div>
            <div class="right-align yours" style="margin-right: -220px;">Very truly yours,</div>
            <div class="adviser">
                <table>
                    <tr>
                        <td><input required type="text" class="form-control" name="adviser" id="adviser" /></td>
                    </tr>
                    <tr>
                        <td><label required for="adviser">Adviser</label></td>
                    </tr>
                </table>
            </div>
            <div class="recom" style="margin-right: 450px;">Recommending Approval:</div>
            <div class="guidance" style="margin-right: 315px;">
                <table>
                    <tr>
                        <td><strong>ARLENE M BALARIA</strong></td>
                    </tr>
                    <tr>
                        <td><label for="guidance">Guidance Coordination</label></td>
                    </tr>
                </table>
            </div>
            <div class="right-align note">Noted:</div>
            <div class="headT">
                <table>
                    <tr>
                        <td><input required type="text" class="form-control" name="headT" id="headT" /></td>
                    </tr>
                    <tr>
                        <td><label for="headT">Head Teacher</label></td>
                    </tr>
                </table>
            </div>
            <div class="center-align approve">Approved:</div>
            <div class="center-align principal">
                <table>
                    <tr>
                        <td><strong>ELADIO R. SANTIAGO, PhD</strong></td>
                    </tr>
                    <tr>
                        <td><label for="principal">School Principal IV</label></td>
                    </tr>
                </table>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Generate Travel Form</button>
    </form>
</div>

@endsection
