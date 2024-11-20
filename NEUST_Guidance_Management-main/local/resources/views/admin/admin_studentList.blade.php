@extends('layouts.app')
@section('content')

    <div class="student-list-container shadow-lg">
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
      <div>
        <h3>Student Information</h3>
      </div>

      <table id="studentList" class="display">
        <thead>
            <tr>
                <th>#</th>
                <th>Profile Status</th>
                <th>Profile Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
      </table>
    </div>

    @include('layouts.student_profile')

    <!-- Student Editor Modal -->
    <div class="modal fade" id="student_editor_modal" tabindex="-1" aria-labelledby="student_editor_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="student_editor_modalLabel">Edit Student Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit_student_form" class="row g-3" method="POST" action="{{ route('admin.student.update') }}">
                    @csrf
                    <input type="text" name="student_id" id="student_id" hidden>
                    <div class="col-md-12">
                        <label for="lrn" class="form-label">Learner Reference Number <small class="text-danger">(12-digit number)</small></label>
                        <input type="text" id="lrn" class="form-control" name="lrn" pattern="\d{12}" title="Please enter a 12-digit number" maxlength="12" oninput="validateLRN(this)" placeholder="(Need to update)" required>
                    </div>
                    <div class="col-md-6">
                        <label for="elem_school" class="form-label">Elementary School Graduate</label>
                        <input type="text" id="elem_school" class="form-control" name="elem_school" placeholder="(Need to update)">
                    </div>
                    <div class="col-md-6">
                        <label for="gen_average" class="form-label">Student General Average</label>
                        <input type="number" min="50" max="100" id="gen_average" name="gen_average" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="current_grade_options" class="form-label">Student Current Grade</label>
                        <select id="current_grade_options" class="form-select" name="current_grade_options">
                            @php
                            foreach ($grade_levels as $level) {
                                echo "<option value=\"$level->id\">$level->grade_level</option>";
                            }
                            @endphp
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="current_section_options" class="form-label">Student Current Section</label>
                        <select id="current_section_options" class="form-select" name="current_section_options">
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="adviser" class="form-label">Adviser</label>
                        <select id="adviser" class="form-select" name="adviser">
                            <option value="0" selected disabled>Select</option>
                            @php
                            foreach ($advisers as $adviser) {
                                echo "<option value=\"$adviser->id\">$adviser->adviser_name</option>";
                            }
                            @endphp
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>

    @include('layouts.loading');

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function() {
          var table = $('#studentList').DataTable({
            processing: true,
            serverSide: true,
            scrollY: '50vh',
            ajax: {
                method: 'get',
                url: "{{ route('fetch.counselor.studentList') }}",
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true, searchable: false },
                {data: 'profile_status', name: 'profile_status'},
                {data: 'profile_image', name: 'profile_image', orderable: false, searchable: false },
                {data: 'fullname', name: 'fullname'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#student_info_modal').on('show.bs.modal', function (event) {
            var id = $(event.relatedTarget).data('id');

            var url_img = "{{ route('student.image', ['id' => ':id']) }}".replace(':id', id);
            $('#student_profile_img').attr('src', url_img);

            $('#student_profile_img').on('error', function() {
                console.error('Image not found at ' + url_img);
                $(this).attr('src', "{{ asset('img/default.jpg') }}");
            });

            $.ajax({
                url: '{{ route("student.information", ["id" => ":id"]) }}'.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    if (response) {
                        $('#student_last_update').html('(Last update: ' + response.last_update + ')');
                        $('#student_name').html(response.firstname + ' ' + (response.middlename ? response.middlename : '') + ' ' + response.lastname + (response.suffix ? response.suffix : '') +  ' <small class="text-secondary">' + (response.school_id ? response.school_id : '')+ '</small>');
                        $('#student_grade_level').html(response.current_grade);
                        $('#student_section').html(response.current_section);
                        $('#student_address').html((response.house_no_street ? response.house_no_street + ', ' : '') + (response.baranggay ? response.baranggay + ', ' : '') + (response.municipality ? response.municipality + ', ' : '') + (response.province ? response.province : ''));
                        $('#student_lrn').html((response.lrn ? response.lrn : '<span class="text-danger">(Need to update student LRN)</span>'));
                        $('#student_age').html(response.age);
                        $('#student_fullname').html(response.firstname + ' ' + (response.middlename ? response.middlename : '') + ' ' + response.lastname);
                        $('#student_email').html(response.email);
                        $('#student_contact').html((response.contact_no ? response.contact_no : '<span class="text-danger">(Need to update)</span>'));
                        $('#student_sex').html((response.sex ? response.sex : '<span class="text-danger">(Need to update)</span>'));
                        $('#student_birthdate').html((response.birthday ? response.birthday : '<span class="text-danger">(Need to update)</span>'));
                        $('#student_religion').html((response.religion ? response.religion : '<span class="text-danger">(Need to update)</span>'));
                        $('#student_nationality').html((response.nationality ? response.nationality : '<span class="text-danger">(Need to update)</span>'));
                        $('#student_father').html((response.father ? response.father : '<span class="text-danger">(Need to update)</span>'));
                        $('#student_father_occupation').html((response.father_occupation ? response.father_occupation : '<span class="text-danger">(Need to update)</span>'));
                        $('#student_mother').html((response.mother ? response.mother : '<span class="text-danger">(Need to update)</span>'));
                        $('#student_mother_occupation').html((response.mother_occupation ? response.mother_occupation : '<span class="text-danger">(Need to update)</span>'));
                        $('#student_living_with').html((response.living_with ? response.living_with : '<span class="text-danger">(Need to update)</span>'));
                        $('#student_no_of_siblings').html(response.no_of_siblings + ' <span>('+ response.position +')</span>');
                        $('#student_elem_school').html((response.elem_school ? response.elem_school : '<span class="text-danger">(Need to update)</span>'));
                        $('#student_gen_average').html(response.gen_average);
                        if(response.current_grade == 'Grade 7'){
                            $('#student_current_grade').html('Grade 6');
                        }else if(response.current_grade == 'Grade 8'){
                            $('#student_current_grade').html('Grade 7');
                        }else if(response.current_grade == 'Grade 9'){
                            $('#student_current_grade').html('Grade 8');
                        }else if(response.current_grade == 'Grade 10'){
                            $('#student_current_grade').html('Grade 9');
                        }

                        $('#student_school_id_2').html(response.school_id);
                        $('#student_adviser').html((response.adviser ? response.adviser : '<span class="text-danger">(Need to update)</span>'));

                    } else {
                        console.log('No data found');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        $('#student_editor_modal').on('show.bs.modal', function (event) {
            var id = $(event.relatedTarget).data('id');
            $('#student_id').val(id);

            $.ajax({
                url: '{{ route("student.information", ["id" => ":id"]) }}'.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    if (response) {
                        $('#lrn').val(response.lrn);
                        $('#elem_school').val(response.elem_school);
                        $('#gen_average').val(response.gen_average);
                        $('#current_grade_options').val(response.current_grade_id).change();
                        $('#adviser').val(response.adviser_id).change();

                        fetchSections(response.current_grade_id, response.current_section_id);

                        $('#current_grade_options').on('change', function(){
                            var grade = $('#current_grade_options').val();
                            fetchSections(grade, response.current_section_id);
                        });

                    } else {
                        console.log('No data found');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        $('#student_editor_modal').on('hide.bs.modal', function () {
            // $(this).find('input, select').val('').change();
            $('#current_grade_options').off('change');
            $('#edit_student_form')[0].reset();
        });

        $(document).on('click', '#email_student_btn', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Email?',
                text: 'Notify student about account completion.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#rrr',
                cancelButtonColor: '#ddd',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    $.ajax({
                        url: '{{ route("admin.student.email") }}',
                        type: 'POST',
                        data: {
                            id: id,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success'
                            });
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'There was an error processing your request.';
                            Swal.fire({
                                title: 'Error!',
                                text: errorMessage,
                                icon: 'error'
                            });
                        },
                        complete: function() {
                            hideLoading();
                        }
                    });
                }
            });
        });

        $(document).on('click', '#download_info_btn', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Generate?',
                text: 'Generate student information.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#rrr',
                cancelButtonColor: '#ddd',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    var token = $('meta[name="csrf-token"]').attr('content');
                    var url = `{{ route('admin.student.pdf.information') }}?id=${id}&_token=${token}`;
                    window.open(url, '_blank');
                }
            });
        });

        function validateLRN(input) {
            if (input.value.length > 12) {
                input.value = input.value.slice(0, 12);
            }
        }

        function fetchSections(grade, current_section){
            $.ajax({
                type: 'GET',
                url: '{{ route("fetch.sections", ["id" => ":id"]) }}'.replace(':id', grade),
                success: function(sections) {
                    var current_section_options = $('#current_section_options');
                    current_section_options.empty();

                    $.each(sections, function(index, section) {
                        var selected = (section.id == current_section) ? 'selected' : '';
                        current_section_options.append('<option value="' + section.id + '" ' + selected + '>' + section.section_name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
      });
    </script>

@endsection
