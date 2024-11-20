@extends('layouts.app')
@section('content')
<style>
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
        margin: 1rem auto; /* Center the table-container */
        text-align: left;
        max-width: 100%; /* Set a maximum width for the table-container */
    }

    .table-container td{
        /* border: 1px solid #000; */
        padding: 5px;
        width: 50%;
    }

    .table-container td > span{
        border-bottom: 1px solid black;
        font-weight: bold;
        text-transform: capitalize;
    }

    .description p {
        border-bottom: 1px solid black;
        text-transform: capitalize;
    }

    .heading{
        border-bottom: 1px solid #000;
    }

</style>
    <div class="student-report-container shadow-lg">
      <div>
        <h3>Student Concern List</h3>
      </div>

      <table id="appointmentList" class="display">
        <thead>
            <tr>
                <th>#</th>
                <th>Status</th>
                <th>Requested on</th>
                <th>Action</th>
            </tr>
        </thead>
      </table>
    </div>

    <!-- Student Concern Modal -->
    <div class="modal fade" id="student_concern_modal" tabindex="-1" aria-labelledby="student_concern_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title fs-5" id="student_concern_modalLabel">Student Concern <small id="student_last_update"></small></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="report-form-container">
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
                        <div class="content">
                            <div class="title">
                                <h5><b>I. IDENTIFYING INFORMATION</b></h5>
                            </div>
                            <div class="table-title">
                                <h5><b>A. VICTIM</b></h5>
                            </div>
                                <div class="table-container">
                                    <table class="w-100">
                                        <tr>
                                            <td>Name: <span id="victim_name" style="width: 273px;"></span></td>
                                            <td>Signature: <span id="victim_signature"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Age: <span id="victim_age" style="width: 285px;"></span></td>
                                            <td>Gender: <span id="victim_gender" style="width: 215px;"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Grade & Section
                                                <span id="victim_grade" style="width: 215px;"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Parents/Guardian: <span id="victim_parent_guardian"></span></td>
                                            <td>Signature: <span id="parent_guardian_signature"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Contact no: <span id="victim_parent_contact" style="width: 242px;"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Class Adviser: <span id="victim_class_adviser" style="width: 225px;"></span></td>
                                            <td>Signature: <span id="adviser_signature"></span></td>
                                        </tr>
                                    </table>
                                </div>
                            <div class="table-title">
                                <h5><b>B. COMPLAINANT</b></h5>
                            </div>
                            <div class="table-container">
                                <table class="w-100">
                                    <tr>
                                        <td>Name: <span id="complainant_name" style="width: 273px;"></span></td>
                                        <td>Signature: <span id="complainant_signature"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Address: <span id="complainant_address" style="width: 260px;"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Contact no: <span id="complainant_contact" style="width: 242px;"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Relation to the Victim: <span id="relation_to_victim" style="width: 173px;"></span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="table-title">
                                <h5><b>C. OFFENDER/S</b></h5>
                            </div>
                            <div class="table-container">
                                <table class="w-100">
                                    <tr>
                                        <td>Name: <span id="offender_name" style="width: 273px;"></span></td>
                                        <td>Signature: <span id="offender_signature"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Age: <span id="offender_age" style="width: 285px;"></span></td>
                                        <td>Gender: <span id="offender_gender" style="width: 215px;"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Grade & Section
                                            <span id="offender_grade" style="width: 215px;">
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Parents/Guardian: <span id="offender_parent_guardian"></span></td>
                                        <td>Signature: <span id="offender_parent_guardian_signature"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Contact no: <span id="offender_parent_contact" style="width: 242px;"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Class Adviser: <span id="offender_class_adviser" style="width: 225px;"></span></td>
                                        <td>Signature: <span id="offender_adviser_signature"></span></td>
                                    </tr>
                                </table>
                            </div>
                            <div>
                                <h5 class="title"><b>II. PROBLEM PRESENTED</b></h5>
                                <div class="description">
                                    <p class="text-start" id="main_concern" class="w-100"></p>
                                </div>
                                <h6 class="title"><b>Action Taken:</b></h6>
                                <div class="description">
                                    <p class="text-start" id="action_taken" class="w-100"></p>
                                </div>
                                <h6 class="title"><b>Recommendation:</b></h6>
                                <div class="description">
                                    <p class="text-start" id="recommendation" class="w-100"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Student Concern Editor -->
    <div class="modal fade" id="concern_editor" tabindex="-1" aria-labelledby="concern_editorLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5 text-danger" id="concern_editorLabel">Take Action!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="{{ route('admin.student.concern.action') }}">
                    @csrf
                    <input type="text" name="concern_id" id="concern_id" hidden>
                    <div class="col-md-12">
                        <p>Problem presented:</p>
                        <p id="concern" class="fw-bold text-capitalize"></p>
                    </div>
                    <div class="col-md-12">
                        <label for="actiontaken">Action Taken:</label>
                        <input type="text" id="actiontaken" class="form-control" name="actiontaken" placeholder="Take action on this concern!" required>
                    </div>
                    <div class="col-md-12">
                        <label for="rec">Recommendation:</label>
                        <input type="text" id="rec" class="form-control" name="rec" placeholder="What are the guidance's will recommend in this concern?" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
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
        var table = $('#appointmentList').DataTable({
            processing: true,
            serverSide: true,
            scrollY: '50vh',
            ajax: {
                method: 'get',
                url: "{{ route('fetch.counselor.reports') }}",
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'report_status', name: 'report_status'},
                {data: 'formatted_requested_date', name: 'formatted_requested_date'},
                {data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        $(document).on('click', '#update_status_btn',function() {
            var id = $(this).data('id');
            var status_name = $(this).data('name');
            var concern_id = $(this).data('concernid');
            Swal.fire({
                title: 'Update Report Status',
                text: 'Update the current status into ' + '"' + status_name +'"',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#0000FF',
                cancelButtonColor: '#ddd',
                confirmButtonText: 'Confirm'
                }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    $.ajax({
                    url: '{{ route("admin.student.concern.status") }}',
                    type: 'POST',
                    data: {
                        id: id,
                        concern_id: concern_id,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response,
                            icon: 'success'
                        }).then(() => {
                            table.ajax.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'There was an error processing your request.';
                        Swal.fire(
                            'Error!',
                            errorMessage,
                            'error'
                        );
                    },
                    complete: function() {
                        hideLoading();
                    }
                    });
                }
            });
        });

        $('#concern_editor').on('show.bs.modal', function(event){
            var id = $(event.relatedTarget).data('concernid');
            $('#concern_id').val(id)
            $.ajax({
                url: '{{ route("fetch.report.information") }}',
                type: 'GET',
                data: {
                    id: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response) {
                        $('#concern').html(response.main_concern);
                        $('#actiontaken').val(response.action_taken);
                        $('#rec').val(response.recommendation);
                    } else {
                        alert('No data found. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        });

        $('#student_concern_modal').on('show.bs.modal', function(event){
            var id = $(event.relatedTarget).data('id');

            $.ajax({
                url: '{{ route("fetch.report.information") }}',
                type: 'GET',
                data: {
                    id: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response) {

                        for (let key in response) {
                            if (response.hasOwnProperty(key)) {
                                let element = document.getElementById(key);
                                if (element) {
                                    if (response[key] === null) {
                                        element.innerHTML = "(To be updated)";
                                    } else {
                                        element.innerHTML = response[key];
                                    }
                                }
                            }
                        }


                    } else {
                        alert('No data found. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        });

        $(document).on('click', '#download_report_info',function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Download',
                text: 'Download student concern information',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#rrr',
                cancelButtonColor: '#ddd',
                confirmButtonText: 'Confirm'
                }).then((result) => {
                if (result.isConfirmed) {
                    var token = $('meta[name="csrf-token"]').attr('content');
                    var url = `{{ route('admin.student.concern.download') }}?id=${id}&_token=${token}`;
                    window.open(url, '_blank');
                }
            });
        });


        $(document).on('click', '#delete_report_btn',function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Remove?',
                text: 'You will not be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff0000',
                cancelButtonColor: '#ddd',
                confirmButtonText: 'Confirm'
                }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    $.ajax({
                    url: '{{ route("admin.student.concern.remove") }}',
                    type: 'POST',
                    data: {
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response,
                            icon: 'success'
                        }).then(() => {
                            table.ajax.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'There was an error processing your request.';
                        Swal.fire(
                            'Error!',
                            errorMessage,
                            'error'
                        );
                    },
                    complete: function() {
                        hideLoading();
                    }
                    });
                }
            });
        });
      });
    </script>
    <script>
        $(document).ready(function(){
        @if(session('error_update'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error_update') }}'
            });
        @elseif(session('status_update'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('status_update') }}'
            });
        @elseif(session('status_no_update'))
            Swal.fire({
                icon: 'info',
                title: 'No Changes!',
                text: '{{ session('status_no_update') }}'
            });
        @endif
        })
    </script>

@endsection
