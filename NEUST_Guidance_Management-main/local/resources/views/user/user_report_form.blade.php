@extends('layouts.app')
@section('content')
<style>

.content{
    margin-top: 30px;
}
.report-content {
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

.table-title {
    margin-left: -30px;
    text-align: left;
}

.title {
    margin-left: -30px;
    text-align: left;
}

.table-container {
    margin: 0 auto; /* Center the table-container */
    text-align: left;
    max-width: 100%; /* Set a maximum width for the table-container */
}

td{
    padding-right: 5px;
}
input[type="text"],
input[type="number"]{
    border: none;
    border-bottom: 1px solid black;
    width: 200px;
}
.signatures {
    margin-top: 30px;
    display: flex;
    justify-content: space-between;
    padding-left: 30px;
    padding-right: 30px;
    text-align: left;
}

.signature-block {
    width: 45%;
    text-align: left;
}

.signature-block.noted {
    /* margin-left: auto; */
    /* text-align: right; */
    margin-left: 500px;
}

.signature-block p {
    margin: 0;
    font-weight: bold;
}

.signature-name {
    margin-top: 10px;
    text-align: center;
}

.signature-title {
    text-align: center;
}

.signature-name.noted,
.signature-title.noted {
    text-align: center;
}
.footer {
    margin-top: 30px;
    padding-left: 30px;
    padding-right: 30px;
    display: flex;
    align-items: center;
    justify-content: left;
}

.footer .logo {
    margin-right: 20px;
}

.footer .logo img {
    width: 100px;
    height: 100px;
}

.footer .contact-details {
    font-size: 14px;
    text-align: left;
}

.footer .contact-details p {
    margin: 2px 0;
}

.footer .contact-details span {
    display: inline-block;
    min-width: 100px;
    font-weight: bold;
}

.line{
    width: 100%;
    height: 2px;
    background-color: black;
    margin-top: 20px;
}
</style>
<div class="report-form-container">
    {{-- <h3>Report your concern</h3> --}}
    {{-- @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif --}}
    <div class="report-content container">
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
        <div class="line"></div>
        <div class="content">
            <form action="{{ route('user.request.report') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="title">
                    <h5>I. IDENTIFYING INFORMATION</h5>
                </div>
                <div class="table-title">
                    <h5>A. VICTIM</h5>
                </div>
                    <div class="table-container">
                        <table>
                            <tr>
                                <td>Name: <input required type="text" name="victim_name" id="victim_name" style="width: 273px;"></td>
                                {{-- <td>Signature: <input type="text" name="victim_signature" id="victim_signature"></td> --}}
                            </tr>
                            <tr>
                                <td>Age: <input required type="number" min="0" max="99" name="victim_age" id="victim_age" style="width: 285px;"></td>
                                <td>Gender:
                                    <select name="victim_gender" id="victim_gender" style="width: 215px;">
                                        <option value="None" disabled selected>Select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Grade & Section
                                    <select required name="victim_grade" id="victim_grade" style="width: 215px;">
                                        <option value="1" disabled selected>Select Grade Level</option>
                                        @php
                                            foreach ($grades as $grade) {
                                                echo "<option value=\"$grade->id\">$grade->grade_level</option>";
                                            }
                                        @endphp
                                    </select>
                                    <select required name="victim_section" id="victim_section" style="width: 215px;">
                                        <option value="1" disabled selected>Select Section</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Parents/Guardian: <input type="text" name="victim_parent_guardian" id="victim_parent_guardian"></td>
                                {{-- <td>Signature: <input type="text" name="parent_guardian_signature" id="parent_guardian_signature"></td> --}}
                            </tr>
                            <tr>
                                <td>Contact no: <input type="number" min="0" name="victim_parent_contact" id="victim_parent_contact" style="width: 242px;"></td>
                            </tr>
                            <tr>
                                <td>Class Adviser:
                                    <select name="victim_class_adviser" id="victim_class_adviser" style="width: 215px;">
                                        <option value="1" disabled selected>Select Adviser</option>
                                        @php
                                        foreach ($advisers as $adviser) {
                                            echo "<option value=\"$adviser->id\">$adviser->adviser_name</option>";
                                        }
                                        @endphp
                                    </select>
                                </td>
                                {{-- <td>Signature: <input type="text" name="adviser_signature" id="adviser_signature"></td> --}}
                            </tr>
                        </table>
                    </div>
                <div class="table-title">
                    <h5>B. COMPLAINANT</h5>
                </div>
                <div class="table-container">
                    <table>
                        <tr>
                            <td><input hidden readonly value="{{ $student->id }}" type="text" name="complainant_id" id="complainant_id" style="width: 273px;"></td>
                        </tr>
                        <tr>
                            <td>Name: <input readonly value="{{ $student->firstname.' '.$student->lastname }}" type="text" style="width: 273px;"></td>
                        </tr>
                        <tr>
                            <td>Relation to the Victim: <input required type="text" name="relation_to_victim" id="relation_to_victim" style="width: 173px;"></td>
                        </tr>
                    </table>
                </div>
                <div class="table-title">
                    <h5>C. OFFENDER/S</h5>
                </div>
                <div class="table-container">
                    <table>
                        <tr>
                            <td>Name: <input required type="text" name="offender_name" id="offender_name" style="width: 273px;"></td>
                            {{-- <td>Signature: <input type="text" name="offender_signature" id="offender_signature"></td> --}}
                        </tr>
                        <tr>
                            <td>Age: <input required type="number" min="0" max="99" name="offender_age" id="offender_age" style="width: 285px;"></td>
                            <td>Gender:
                                <select name="offender_gender" id="offender_gender" style="width: 215px;">
                                    <option value="None" disabled selected>Select gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Grade & Section
                                <select required name="offender_grade" id="offender_grade" style="width: 215px;">
                                    <option value="1" disabled selected>Select Grade Level</option>
                                    @php
                                    foreach ($grades as $grade) {
                                        echo "<option value=\"$grade->id\">$grade->grade_level</option>";
                                    }
                                    @endphp
                                </select>
                                <select required name="offender_section" id="offender_section" style="width: 215px;">
                                    <option value="1" disabled selected>Select Section</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Parents/Guardian: <input type="text" name="offender_parent_guardian" id="offender_parent_guardian"></td>
                            {{-- <td>Signature: <input type="text" name="offender_parent_guardian_signature" id="offender_parent_guardian_signature"></td> --}}
                        </tr>
                        <tr>
                            <td>Contact no: <input type="number" min="0" name="offender_parent_contact" id="offender_parent_contact" style="width: 242px;"></td>
                        </tr>
                        <tr>
                            <td>Class Adviser:
                                <select name="victim_class_adviser" id="victim_class_adviser" style="width: 215px;">
                                    <option value="1" disabled selected>Select Adviser</option>
                                    @php
                                    foreach ($advisers as $adviser) {
                                        echo "<option value=\"$adviser->id\">$adviser->adviser_name</option>";
                                    }
                                    @endphp
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div>
                    <h5 class="title">II. PROBLEM PRESENTED</h5>
                    <div class="description">
                        <textarea name="main_concern" id="main_concern" cols="80" class="w-100"></textarea>
                    </div>
                </div>
                <div class="signatures">
                    <div class="signature-block">
                        <p>Prepared by:</p>
                        <div class="signature-name">ARLENE M. BALARIA</div>
                        <div class="signature-title">Guidance Coordinator</div>
                    </div>
                    <div class="signature-block noted">
                        <p>Noted by:</p>
                        <div class="signature-name noted">ELADIO R. SANTIAGO, PhD</div>
                        <div class="signature-title noted">School Principal IV</div>
                    </div>
                </div>
                <div class="line"></div>
                <div class="footer">
                    <div class="logo">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" width="100px" height="100px">
                    </div>
                    <div class="contact-details">
                        <p><span>Address:</span> Sinipit, Bongabon, Nueva Ecija</p>
                        <p><span>Telephone:</span> (044) 958-3143</p>
                        <p><span>Email:</span> bongabonnhs@gmail.com</p>
                        <p><span>Facebook:</span> Bongabon National High School</p>
                        <p><span>Webpage:</span> <a href="https://www.bongabonnhs.com">www.bongabonnhs.com</a></p>
                    </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-secondary">Report Concern</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        var status = @json($status);

        checkUserValidity(status);

        $('#victim_grade').on('change', function(){
            var grade = $('#victim_grade').val();
            fetchSections(grade, $('#victim_section'));
        });

        $('#offender_grade').on('change', function(){
            var grade = $('#offender_grade').val();
            fetchSections(grade, $('#offender_section'));
        });

    });

    function checkUserValidity(status){
        if(status == 'Incomplete'){
            Swal.fire({
                title: "Please complete your profile!",
                text: "Please complete your profile to be able to request.",
                icon: "error",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Go to Profile",
                allowOutsideClick: false
                }).then((result) => {
                if (result.isConfirmed) {
                    //go to route = {{ route('user.viewProfile') }}
                    window.location.href = '{{ route("user.viewProfile") }}';
                }
            });
        }
    }

    function fetchSections(grade_id, select_section){
        $.ajax({
            type: 'GET',
            url: '{{ route("fetch.user.sections", ["grade_id" => ":grade_id"]) }}'.replace(':grade_id', grade_id),
            success: function(sections) {
                var current_section_options = select_section;
                current_section_options.empty();

                $.each(sections, function(index, section) {
                    current_section_options.append('<option value="' + section.id + '">' + section.section_name + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>
<script>
    $(document).ready(function(){
    @if(session('error_request'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error_request') }}'
        });
    @elseif(session('success_request'))
        Swal.fire({
            icon: 'success',
            title: 'Request sent!',
            text: '{{ session('success_request') }}'
        });
    @endif
    })
</script>
@endsection

