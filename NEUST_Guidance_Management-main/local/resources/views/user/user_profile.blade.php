@extends('layouts.app')
@section('content')

<style>
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid transparent;
    border-radius: .25rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%);
}
.me-2 {
    margin-right: .5rem!important;
}
/* Chrome, Safari, and Opera */
::-webkit-input-placeholder {
    color: red !important;
}
/* Firefox */
:-moz-placeholder {
    color: red !important;
}
/* Internet Explorer 10-11 */
:-ms-input-placeholder {
    color: red !important;
}
/* Microsoft Edge */
::-ms-input-placeholder {
    color: red !important;
}
/* Standard syntax */
::placeholder {
    color: red !important;
}
</style>
<div class="container">
    <div class="main-body">
        @if (session('status_update'))
        <div class="alert alert-success">
            {{ session('status_update') }}
        </div>
        @endif
        @if (session('error_update'))
        <div class="alert alert-danger">
            {{ session('error_update') }}
        </div>
        @endif
        @if (session('status_no_update'))
        <div class="alert alert-secondary">
            {{ session('status_no_update') }}
        </div>
        @endif
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="@if(is_null($student->student_img)) {{ asset('img/default.jpg') }} @else {{ $profile_img }}  @endif" alt="Student Image" class="" width="110" height="110" style="object-fit: cover;">
                            <div class="mt-3">
                                <h4 class="text-capitalize">{{ $student->firstname }} {{ $student->lastname }} <small class="text-secondary">{{ $student->school_id }}</small></h4>
                                <p class="text-secondary mb-1"><span>{{ $current_grade }}</span> - <span>{{ $current_section }}</span></p>
                                <p class="text-secondary mb-1">@if($student->lrn) {{ $student->lrn }} @else {{ '(LRN to be updated)' }} @endif</p>
                                <p class="text-muted font-size-sm">@if($student->house_no_street) {{ $student->house_no_street }} @else {{ '(UPDATE)' }} @endif, {{ $student_address['barangay'] }}, {{ $student_address['city'] }}, {{ $student_address['province'] }}</p>
                                {{-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#edit_profile">
                                    Edit Profile
                                </button> --}}
                                {{-- <br> --}}
                                {{-- <a id="email_counselor" data-id="{{ $student->id }}" href="#" title="Email Guidance Counselor for Account Completion" class="btn btn-secondary mt-3">Email Counselor <i class="bi bi-envelope-check-fill"></i></a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="">Personal Information</h5>
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#edit_profile">
                                <i class="bi bi-gear"></i>
                            </button>
                        </div>
                        <div class="d-flex">
                            <section class="w-50">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-secondary">Full Name</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-capitalize">{{ $student->firstname }} {{ $student->middlename }} {{ $student->lastname }} {{ $student->suffix }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-secondary">Contact</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p>@if($student->contact_no) +63{{ $student->contact_no }} @else <span class="text-danger">Need to update</span> @endif</p>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-secondary">Birth Date</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p>{{ $formatted_date }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-secondary">Nationality</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p>@if($student->nationality) {{ $student->nationality }} @else <span class="text-danger">Need to update</span> @endif</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-secondary">Father</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p>@if($student->father) {{ $student->father }} @else <span class="text-danger">Need to update</span> @endif</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-secondary">Mother</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p>@if($student->mother) {{ $student->mother }} @else <span class="text-danger">Need to update</span> @endif</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-secondary">Curently living with</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p>@if($student->living_with) {{ $student->living_with }} @else <span class="text-danger">Need to update</span> @endif</p>
                                    </div>
                                </div>
                            </section>
                            <section class="w-50">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-secondary">Email</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        @if($student->email) {{ $student->email }} @else <span class="text-danger">Need to update</span> @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-secondary">Gender</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p>@if($student->sex) {{ $student->sex }} @else <span class="text-danger">Need to update</span> @endif</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-secondary">Age</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p>{{ $student_age }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-secondary">Religion</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p>@if($student->religion) {{ $student->religion }} @else <span class="text-danger">Need to update</span> @endif</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-secondary">Father Occupation</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p>@if($student->father_occupation) {{ $student->father_occupation }} @else <span class="text-danger">Need to update</span> @endif</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-secondary">Mother Occupation</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p>@if($student->mother_occupation) {{ $student->mother_occupation }} @else <span class="text-danger">Need to update</span> @endif</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-secondary">No. of Siblings(position)</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        <p>@if($student->no_of_siblings && $student->position) {{ $student->no_of_siblings }} ({{ $student->position }}) @else <span class="text-danger">Need to update</span> @endif</p>                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h5 class="">Educational Background</h5>
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#edit_profile2">
                                        <i class="bi bi-gear"></i>
                                    </button>
                                </div>
                                <div class="d-flex">
                                    <section class="w-50">
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 text-secondary">Elementary School Graduate</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <p>@if($student->elem_school) {{ $student->elem_school }} @else <span class="text-danger">Need to update</span> @endif</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 text-secondary">School Address</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <p>BNHS-SINIPIT, BONGABON, N.E</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 text-secondary">General Average</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <p>@if($student->gen_average) {{ $student->gen_average }} @else <span class="text-danger">Need to update</span> @endif</p>
                                            </div>
                                        </div>
                                    </section>
                                    <section class="w-50">
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 text-secondary">Last Grade Level Completed</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                @if($current_grade === 'Grade 7')
                                                <p>Grade 6</p>
                                                @endif
                                                @if($current_grade === 'Grade 8')
                                                <p>Grade 7</p>
                                                @endif
                                                @if($current_grade === 'Grade 9')
                                                <p>Grade 8</p>
                                                @endif
                                                @if($current_grade === 'Grade 10')
                                                <p>Grade 9</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 text-secondary">School ID</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <p>@if($student->school_id) {{ $student->school_id }} @else {{ $current_year }}-xxxx @endif</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0 text-secondary">Adviser</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <p>@if($adviser) {{ $adviser }} @else <span class="text-danger">Need to update</span> @endif</p>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal 1 -->
<div class="modal fade" id="edit_profile" tabindex="-1" aria-labelledby="edit_profileLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title fs-5" id="edit_profileLabel">Update Personal Information</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <div class="modal-body">
            <form id="edit_profile_form" class="row g-3" action="{{ route('student.profile.editor') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-md-4 mb-2 text-center d-flex align-items-center">
                    <img src="{{ $profile_img }}" alt="Student Image" class="" width="110" height="110" style="object-fit: cover;">
                    <input type="file" class="form-control" name="profile_img" id="profile_img">
                    <div id="file-error" class="text-danger mt-2" style="display:none;">Please select a valid image file (jpg, jpeg, png, gif).</div>
                </div>

                {{-- Name --}}
                <div class="d-flex">
                    <div class="col-md-3 me-2">
                        <label for="profile_first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="profile_first_name" name="profile_first_name" value="{{ $student->firstname }}" >
                    </div>
                    <div class="col-md-3 me-2">
                        <label for="profile_middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="profile_middle_name" name="profile_middle_name" value="{{ $student->middlename }}" placeholder="(UPDATE)">
                    </div>
                    <div class="col-md-3 me-2">
                        <label for="profile_last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="profile_last_name" name="profile_last_name" value="{{ $student->lastname }}">
                    </div>
                    <div class="col-md-2 me-2">
                        <label for="profile_suffix" class="form-label">Suffix</label>
                        <input type="text" class="form-control" id="profile_suffix" name="profile_suffix" value="{{ $student->suffix }}" placeholder="(UPDATE)">
                    </div>
                </div>

                <div class="d-flex">
                    <div class="col-md-5 me-3">
                        <label for="profile_birthdate" class="form-label">Birth Date</label>
                        <input type="date" class="form-control" id="profile_birthdate" name="profile_birthdate" value="{{ $student->birthday }}">
                    </div>
                    <div class="col-md-5 me-3">
                        <label for="profile_gender" class="form-label">Gender</label>
                        <select id="profile_gender" name="profile_gender" class="form-control">
                            <option disabled selected>(Update Gender)</option>
                            @php
                            $genders = [
                                "Male", "Female", "Other(s)"
                            ];
                            foreach ($genders as $gender) {
                                $selected = ($student->sex == $gender) ? 'selected' : '';
                                echo "<option value=\"$gender\" $selected>$gender</option>";
                            }
                            @endphp
                        </select>
                    </div>
                </div>

                {{-- Contacts --}}
                <div class="d-flex">
                    <div class="col-md-6 me-3">
                        <label for="profile_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="profile_email" name="profile_email" value="{{ $student->email }}">
                        <small id="email-error" style="display:none; color:red;">Invalid email address.<span class="text-secondary">(try your email with @gmail, @yahoo, or @hotmail only.)</span></small>
                    </div>
                    <div class="col-md-6 me-3">
                        <div class="row">
                            <div class="col-md-2" style="padding: 0">
                                <label for="country_code" class="form-label">Contact</label>
                                <input type="text" class="form-control bg-light" id="country_code" name="country_code" value="+63" readonly maxlength="3" placeholder="(UPDATE)">
                            </div>
                            <div class="col-md-9" style="padding: 0">
                                <label for="country_code" class="form-label text-light">#</label>
                                <input type="text" class="form-control" id="profile_contact" name="profile_contact" value="{{ $student->contact_no }}" placeholder="(UPDATE)">
                                <small>Example: <span class="text-secondary">(+639220890999)</span></small>
                                <p id="contactError" class="text-danger" style="display: none;"><small>Invalid contact.</small></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Address --}}
                <div class="col-12 mb-3">
                    <label for="profile_street" class="form-label">Street</label>
                    <input type="text" class="form-control" id="profile_street" name="profile_street" placeholder="(UPDATE)" value="{{ $student->house_no_street }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="profile_province" class="form-label">Province</label>
                    <select id="profile_province" name="profile_province" class="form-control">
                    <option selected value="{{ $student->province }}">{{ $student_address['province'] }}</option>
                    <option disabled>Select</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="profile_municipality" class="form-label">Municipality</label>
                    <select id="profile_municipality" name="profile_municipality" class="form-control">
                    {{-- <option selected>{{ $student->municipality }}</option> --}}
                    <option selected value="{{ $student->municipality }}">{{ $student_address['city'] }}</option>
                    <option disabled>Select</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="profile_baranggay" class="form-label">Barangay</label>
                    <select id="profile_baranggay" name="profile_baranggay" class="form-control">
                    {{-- <option selected>{{ $student->baranggay }}</option> --}}
                    <option selected value="{{ $student->baranggay }}">{{ $student_address['barangay'] }}</option>
                    <option disabled>Select</option>
                    </select>
                </div>

                {{-- Others --}}
                <div class="col-md-4 mb-3">
                    <label for="profile_nationality" class="form-label">Nationality</label>
                    <select id="profile_nationality" name="profile_nationality" class="form-control">
                        <option selected value="Filipino">Filipino</option>
                        <option disabled>Select</option>
                        @php
                        $nationalities = [
                            "Afghan", "Albanian", "Algerian", "American", "Andorran", "Angolan", "Antiguans", "Argentinean",
                            "Armenian", "Australian", "Austrian", "Azerbaijani", "Bahamian", "Bahraini", "Bangladeshi",
                            "Barbadian", "Barbudans", "Batswana", "Belarusian", "Belgian", "Belizean", "Beninese",
                            "Bhutanese", "Bolivian", "Bosnian", "Brazilian", "British", "Bruneian", "Bulgarian", "Burkinabe",
                            "Burmese", "Burundian", "Cambodian", "Cameroonian", "Canadian", "Cape Verdean", "Central African",
                            "Chadian", "Chilean", "Chinese", "Colombian", "Comoran", "Congolese", "Costa Rican", "Croatian",
                            "Cuban", "Cypriot", "Czech", "Danish", "Djibouti", "Dominican", "Dutch", "East Timorese",
                            "Ecuadorean", "Egyptian", "Emirian", "Equatorial Guinean", "Eritrean", "Estonian", "Ethiopian",
                            "Fijian", "Filipino", "Finnish", "French", "Gabonese", "Gambian", "Georgian", "German", "Ghanaian",
                            "Greek", "Grenadian", "Guatemalan", "Guinea-Bissauan", "Guinean", "Guyanese", "Haitian",
                            "Herzegovinian", "Honduran", "Hungarian", "Icelander", "Indian", "Indonesian", "Iranian", "Iraqi",
                            "Irish", "Israeli", "Italian", "Ivorian", "Jamaican", "Japanese", "Jordanian", "Kazakhstani",
                            "Kenyan", "Kittian and Nevisian", "Kuwaiti", "Kyrgyz", "Laotian", "Latvian", "Lebanese",
                            "Liberian", "Libyan", "Liechtensteiner", "Lithuanian", "Luxembourger", "Macedonian", "Malagasy",
                            "Malawian", "Malaysian", "Maldivan", "Malian", "Maltese", "Marshallese", "Mauritanian",
                            "Mauritian", "Mexican", "Micronesian", "Moldovan", "Monacan", "Mongolian", "Moroccan", "Mosotho",
                            "Motswana", "Mozambican", "Namibian", "Nauruan", "Nepalese", "New Zealander", "Nicaraguan",
                            "Nigerian", "Nigerien", "North Korean", "Northern Irish", "Norwegian", "Omani", "Pakistani",
                            "Palauan", "Panamanian", "Papua New Guinean", "Paraguayan", "Peruvian", "Polish", "Portuguese",
                            "Qatari", "Romanian", "Russian", "Rwandan", "Saint Lucian", "Salvadoran", "Samoan", "San Marinese",
                            "Sao Tomean", "Saudi", "Scottish", "Senegalese", "Serbian", "Seychellois", "Sierra Leonean",
                            "Singaporean", "Slovakian", "Slovenian", "Solomon Islander", "Somali", "South African",
                            "South Korean", "Spanish", "Sri Lankan", "Sudanese", "Surinamer", "Swazi", "Swedish", "Swiss",
                            "Syrian", "Taiwanese", "Tajik", "Tanzanian", "Thai", "Togolese", "Tongan", "Trinidadian or Tobagonian",
                            "Tunisian", "Turkish", "Tuvaluan", "Ugandan", "Ukrainian", "Uruguayan", "Uzbekistani", "Venezuelan",
                            "Vietnamese", "Welsh", "Yemenite", "Zambian", "Zimbabwean"
                        ];
                        foreach ($nationalities as $nationality) {
                            $selected = ($student->nationality == $nationality) ? 'selected' : '';
                            echo "<option value=\"$nationality\" $selected>$nationality</option>";
                        }
                        @endphp
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="profile_religion" class="form-label">Religion</label>
                    <select id="profile_religion" name="profile_religion" class="form-control">
                        <option disabled selected>(UPDATE)</option>
                        @php
                        $religions = [
                            "Buddhism", "Christian", "Hinduism", "Islam", "Judaism", "Sikhism", "Atheism", "Agnosticism",
                            "Bahá'í", "Confucianism", "Jainism", "Shinto", "Taoism", "Zoroastrianism", "Rastafarianism",
                            "Scientology", "Unitarian Universalism", "Paganism", "Animism", "Other"
                        ];
                        foreach ($religions as $religion) {
                            $selected = ($student->religion == $religion) ? 'selected' : '';
                            echo "<option value=\"$religion\" $selected>$religion</option>";
                        }
                        @endphp
                    </select>
                </div>

                {{-- Family --}}
                <div class="col-md-6 mb-3">
                    <label for="profile_father" class="form-label">Father Name</label>
                    <input type="text" class="form-control" id="profile_father" name="profile_father" placeholder="(UPDATE)" value="{{ $student->father }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="profile_father_occupation" class="form-label">Father Occupation</label>
                    <input type="text" class="form-control" id="profile_father_occupation" name="profile_father_occupation" placeholder="(UPDATE)" value="{{ $student->father_occupation }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="profile_mother" class="form-label">Mother Name</label>
                    <input type="text" class="form-control" id="profile_mother" name="profile_mother" placeholder="(UPDATE)" value="{{ $student->mother }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="profile_mother_occupation" class="form-label">Mother Occupation</label>
                    <input type="text" class="form-control" id="profile_mother_occupation" name="profile_mother_occupation" placeholder="(UPDATE)" value="{{ $student->mother_occupation }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="profile_living_with" class="form-label">Currently living with whom</label>
                    <select id="profile_living_with" name="living_with" class="form-control">
                        <option selected disabled>(UPDATE)</option>
                        <option value="Father" {{ $student->living_with == 'Father' ? 'selected' : '' }}>Father</option>
                        <option value="Mother" {{ $student->living_with == 'Mother' ? 'selected' : '' }}>Mother</option>
                        <option value="Other" {{ $student->living_with == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="profile_no_sibling" class="form-label">No. of Siblings</label>
                    <input type="number" class="form-control" id="profile_no_sibling" name="profile_no_sibling" value="{{ $student->no_of_siblings }}" min="1">
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="profile_sibling_position" class="form-label">Sibling Position</label>
                    <input type="number" class="form-control" id="profile_sibling_position" name="profile_sibling_position" value="{{ $student->position }}" min="1" max="{{ $student->no_of_siblings }}">
                    </select>
                </div>

                <div class="col-12 modal-footer mt-3">
                    <button type="submit" id="submit_edit_btn" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>

<!-- Edit Profile Modal 2-->
<div class="modal fade" id="edit_profile2" tabindex="-1" aria-labelledby="edit_profile2Label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title fs-5" id="edit_profile2Label">Update Educational Backgound</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <div class="modal-body">
            <form id="edit_profile2_form" class="row g-3" action="{{ route('student.profile.editor.educational') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="col-md-12">
                    <label for="lrn" class="form-label">Learner Reference Number <small class="text-danger">(12-digit number)</small></label>
                    <input type="text" id="lrn" class="form-control" name="lrn" value="{{ $student->lrn }}" pattern="\d{12}" title="Please enter a 12-digit number" maxlength="12" oninput="validateLRN(this)" placeholder="(Need to update)" required>
                </div>
                <div class="col-md-6">
                    <label for="elem_school" class="form-label">Elementary School Graduate</label>
                    <input type="text" id="elem_school" class="form-control" name="elem_school" value="{{ $student->elem_school }}" placeholder="(Need to update)">
                </div>
                <div class="col-md-6">
                    <label for="gen_average" class="form-label">Student General Average</label>
                    <input type="number" min="50" max="100" id="gen_average" name="gen_average" value="{{ $student->gen_average }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="current_grade_options" class="form-label">Student Current Grade</label>
                    <select id="current_grade_options" class="form-select" name="current_grade_options">
                        <option disabled selected>(UPDATE)</option>
                        @php
                            foreach ($grade_levels as $level) {
                                $selected = ($student->current_grade == $level->id) ? 'selected' : '';
                                echo "<option value=\"$level->id\" $selected>$level->grade_level</option>";
                            }
                        @endphp
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="current_section_options" class="form-label">Student Current Section</label>
                    <select id="current_section_options" class="form-select" name="current_section_options">
                        <option disabled selected>(UPDATE)</option>
                        @php
                        foreach ($sections as $section) {
                            $selected = ($student->current_section == $section->id) ? 'selected' : '';
                            if($section->grade_id == $student->current_grade){
                                echo "<option value=\"$section->id\" $selected>$section->section_name</option>";
                            }
                        }
                    @endphp
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="adviser" class="form-label">Adviser</label>
                    <select id="adviser" class="form-select" name="adviser">
                        <option disabled selected>(UPDATE)</option>
                        @php
                        foreach ($advisers as $adviser) {
                            $selected = ($student->adviser == $adviser->id) ? 'selected' : '';
                            echo "<option value=\"$adviser->id\" $selected>$adviser->adviser_name</option>";
                        }
                        @endphp
                    </select>
                </div>
                <div class="col-12 modal-footer mt-3">
                    <button type="submit" id="submit_edit_btn2" class="btn btn-success">Save Changes</button>
                </div>

            </form>
        </div>
      </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $('#profile_img').on('change', function() {
            const file = this.files[0];
            const fileError = $('#file-error');
            const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];

            if (file && !validImageTypes.includes(file.type)) {
                fileError.show();
                $(this).val(''); // Clear the input
            } else {
                fileError.hide();
            }
        });

        $('#profile_no_sibling').on('change', function(){
            $('#profile_sibling_position').attr('max', $(this).val());
        });

        // Function to validate email domain
        function validateEmailDomain(email) {
            const allowedDomains = ['gmail.com', 'yahoo.com', 'hotmail.com'];
            const emailDomain = email.split('@')[1];
            return allowedDomains.includes(emailDomain);
        }

        // Email validation on change
        $('#profile_email').on('change', function() {
            const email = $(this).val();
            const emailError = $('#email-error');

            if (!validateEmailDomain(email)) {
                $('#submit_edit_btn').prop('disabled', true);
                emailError.show();
            } else {
                $('#submit_edit_btn').prop('disabled', false);
                emailError.hide();
            }
        });

        $('#profile_contact').on('input', function() {
            var contactInput = $(this).val().replace(/\D/g, ''); // Remove non-numeric characters
            if (contactInput.length === 10) {
                $('#contactError').hide();
                $('#submit_edit_btn').prop('disabled', false);
            } else {
                $('#contactError').show();
                $('#submit_edit_btn').prop('disabled', true);
            }
        });

        // Prevent entering non-numeric characters using keypress event
        $('#profile_contact').on('keypress', function(event) {
            var keyCode = event.keyCode || event.which;
            var keyValue = String.fromCharCode(keyCode);
            if (!/^\d+$/.test(keyValue)) {
                event.preventDefault();
            }
        });

        // Populate Provinces Dropdown
        var student_province = @json($student->province);

        $.ajax({
            type: 'GET',
            url: '{{ route("fetch.user.location.provinces") }}',
            success: function(provinces) {
                var provinceDropdown = $('#profile_province');
                $.each(provinces, function(index, province) {
                    var selected = (province.province_code == student_province) ? 'selected' : '';
                    provinceDropdown.append('<option value="' + province.province_code + '" ' + selected + '>' + province.province_description + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        $('#profile_province').on('change', function(){
            // Populate Cities Dropdown
            getCities();
            getBarangays();
        })

        var user_city = @json($student->municipality);

        if(user_city){
            // Populate Cities Dropdown
            getCities();
        }


        $('#profile_municipality').on('change', function(){
            // Populate Cities Dropdown
            getBarangays();
        })

        var user_barangay = @json($student->baranggay);

        if(user_barangay){
            // Populate Barangays Dropdown
            getBarangays();
        }

    });

    $(document).ready(function(){
        $('#lrn').on('input', function() {
            var lrn = $(this).val().replace(/\D/g, ''); // Remove non-numeric characters
        });

        // Prevent entering non-numeric characters using keypress event
        $('#lrn').on('keypress', function(event) {
            var keyCode = event.keyCode || event.which;
            var keyValue = String.fromCharCode(keyCode);
            if (!/^\d+$/.test(keyValue)) {
                event.preventDefault();
            }
        });

        $('#current_grade_options').on('change', function(){
            var grade_id = $(this).val();
            $.ajax({
                type: 'GET',
                url: '{{ route("fetch.user.sections", ["grade_id" => ":grade_id"]) }}'.replace(':grade_id', grade_id),
                success: function(sections) {
                    var current_section_options = $('#current_section_options');
                    current_section_options.empty();

                    $.each(sections, function(index, section) {
                        current_section_options.append('<option value="' + section.id + '">' + section.section_name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    })

    function validateLRN(input) {
        if (input.value.length > 12) {
            input.value = input.value.slice(0, 12);
        }
    }

    function getCities(){
        // Populate Cities Dropdown
        $.ajax({
            type: 'GET',
            url: '{{ route("fetch.user.location.cities", ":province_code") }}'.replace(':province_code', $('#profile_province').val()),
            success: function(cities) {
                var cityDropdown = $('#profile_municipality');
                cityDropdown.empty();

                $.each(cities, function(index, city) {
                    var selected = (city.city_municipality_code == '{{ $student->municipality }}') ? 'selected' : '';
                    cityDropdown.append('<option value="' + city.city_municipality_code + '" ' + selected + '>' + city.city_municipality_description + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function getBarangays(){
        // Populate Barangays Dropdown
        $.ajax({
            type: 'GET',
            url: '{{ route("fetch.user.location.barangays", [":province_code", ":city_code"]) }}'
                .replace(':province_code', $('#profile_province').val())
                .replace(':city_code', $('#profile_municipality').val()),
            success: function(barangays) {
                var barangayDropdown = $('#profile_baranggay');
                barangayDropdown.empty();
                $.each(barangays, function(index, barangay) {
                    var selected = (barangay.barangay_code == '{{ $student->baranggay }}') ? 'selected' : '';
                    barangayDropdown.append('<option value="' + barangay.barangay_code + '" ' + selected + '>' + barangay.barangay_description  + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>
{{-- <script>
    $(document).on('click', '#email_counselor',function() {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Email Counselor?',
            text: "Email counselor for account completion",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#rrr',
            cancelButtonColor: '#ddd',
            confirmButtonText: 'Send'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url: '',
                type: 'POST',
                data: {
                    id: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Email sent!',
                        text: response,
                    })
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'There was an error processing your request.';
                    Swal.fire(
                        'Error!',
                        errorMessage,
                        'error'
                    );
                }
                });
            }
        });
    });
</script> --}}
@endsection
