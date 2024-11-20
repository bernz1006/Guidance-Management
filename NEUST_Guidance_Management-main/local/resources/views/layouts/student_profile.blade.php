<!-- Student Info Modal -->
<div class="modal fade" id="student_info_modal" tabindex="-1" aria-labelledby="student_info_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title fs-5" id="student_info_modalLabel">Student Information <small id="student_last_update"></small></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img id="student_profile_img" src="" alt="Student Image" class="" width="110" height="110" style="object-fit: cover;">
                                <div class="mt-3">
                                    <h4 class="text-capitalize" id="student_name"></h4>
                                    <p class="text-secondary mb-1"><span id="student_grade_level"></span> - <span id="student_section"></span></p>
                                    <p class="text-secondary mb-1" id="student_lrn"></p>
                                    <p class="text-muted font-size-sm" id="student_address"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="d-flex align-items-center mb-3">Personal Information</h5>
                            <div class="d-flex">
                                <section class="w-50">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 text-secondary">Full Name</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-capitalize" id="student_fullname"></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 text-secondary">Contact</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p id="student_contact"></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 text-secondary">Birth Date</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p id="student_birthdate"></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 text-secondary">Nationality</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p id="student_nationality"></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 text-secondary">Father</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p id="student_father"></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 text-secondary">Mother</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p id="student_mother"></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 text-secondary">Curently living with</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p id="student_living_with"></p>
                                        </div>
                                    </div>
                                </section>
                                <section class="w-50">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 text-secondary">Email</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p id="student_email"></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 text-secondary">Gender</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p id="student_sex"></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 text-secondary">Age</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p id="student_age"></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 text-secondary">Religion</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p id="student_religion"></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 text-secondary">Father Occupation</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p id="student_father_occupation"></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 text-secondary">Mother Occupation</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p id="student_mother_occupation"></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0 text-secondary">No. of Siblings(position)</h6>
                                        </div>
                                        <div class="col-sm-9">
                                            <p id="student_no_of_siblings"></p>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        <h5 class="d-flex align-items-center mb-3">Educational Background</h5>                                        </div>
                                    <div class="d-flex">
                                        <section class="w-50">
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0 text-secondary">Elementary School Graduate</h6>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p id="student_elem_school"></p>
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
                                                    <p id="student_gen_average"></p>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="w-50">
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0 text-secondary">Last Grade Level Completed</h6>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p id="student_current_grade"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0 text-secondary">School ID</h6>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p id="student_school_id_2"></p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0 text-secondary">Adviser</h6>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p id="student_adviser"></p>
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
    </div>
</div>
