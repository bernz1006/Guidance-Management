@extends('layouts.app')
@section('content')
<div class="view-appointment-container container shadow-lg">
    <div>
      <h3>Recent Appointments</h3>
    </div>

    <table id="appointmentList" class="display">
      <thead>
          <tr>
              <th>#</th>
              <th>Status</th>
              <th>Date</th>
              <th>Time</th>
              <th>From</th>
              <th>To</th>
              <th>Duration</th>
              <th>About</th>
              <th>Reason</th>
              <th>Requested On</th>
              <th>Cancel Request</th>
          </tr>
      </thead>
    </table>
  </div>

  @include('layouts.loading')

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
        var table = $('#appointmentList').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                method: 'get',
                url: "{{ route('fetch.user.appointments') }}",
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true, searchable: false },
                {data: 'appointment_status', name: 'appointment_status'},
                {data: 'formatted_appointment_date', name: 'formatted_appointment_date'},
                {data: 'formatted_appointment_time', name: 'formatted_appointment_time'},
                {data: 'formatted_appointment_time_from', name: 'formatted_appointment_time_from'},
                {data: 'formatted_appointment_time_to', name: 'formatted_appointment_time_to'},
                {data: 'duration', name: 'duration'},
                {data: 'subject', name: 'subject'},
                {data: 'reason', name: 'reason'},
                {data: 'formatted_requested_date', name: 'formatted_requested_date'},
                {data: 'cancel_btn', name: 'cancel_btn', orderable: false, searchable: false},
            ]
        });

        $(document).on('click', '#cancel_req_btn',function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Cancel Request?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#ddd',
                confirmButtonText: 'Confirm'
                }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    $.ajax({
                    url: '{{ route("user.request.cancel") }}',
                    type: 'POST',
                    data: {
                        id: id,
                        request_type: 2,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Request cancelled!',
                            text: response,
                        }).then(() => {
                            // Reload the DataTable
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
@endsection
