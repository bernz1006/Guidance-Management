@extends('layouts.app')
@section('content')
<div class="container">
    <div class="container">
        <div class="container" style="max-width: 800px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <h2>Request for Good Moral Certificate</h2>
            {{-- @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif --}}
            <form action="{{ route('user.request.moral') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                @csrf
                <div class="form-group mb-3">
                    <label for="requestDate">Request Date: (Please specify the date you expect the certificate.)</label>
                    <input type="date" class="form-control" id="requestDate" name="requestDate" required>
                    @error('requestDate')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="reason">Reason:(Please justify your reason.)</label>
                    <textarea class="form-control" id="reason" name="reason" rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Request</button>
            </form>
        </div>
    </div>

    <div class="good-table-container mt-5 shadow-lg">
        <h5>Recent Good Moral Certificate Request</h5>
        <table id="GoodMoralList" class="display">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Expected Date of Return</th>
                    <th>Notes</th>
                    <th>Requested On</th>
                    <th>Cancel Request</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@include('layouts.loading')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function(){
        var status = @json($status);

        checkUserValidity(status);

        var table = $('#GoodMoralList').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                method: 'get',
                url: "{{ route('fetch.user.gm.request') }}",
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {data: 'appointment_status', name: 'appointment_status'},
                {data: 'reason', name: 'reason'},
                {data: 'formatted_request_date', name: 'formatted_request_date'},
                {data: 'notes', name: 'notes'},
                {data: 'formatted_request_on', name: 'formatted_request_on'},
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
                confirmButtonText: 'Confirm',
                allowOutsideClick: false
                }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    $.ajax({
                    url: '{{ route("user.request.cancel") }}',
                    type: 'POST',
                    data: {
                        id: id,
                        request_type: 4,
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

    function checkUserValidity(status){
        if(status == 'Incomplete'){
            Swal.fire({
                title: "Please complete your profile!",
                text: "Please complete your profile to be able to request.",
                icon: "error",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Go to Profile"
                }).then((result) => {
                if (result.isConfirmed) {
                    //go to route = {{ route('user.viewProfile') }}
                    window.location.href = '{{ route("user.viewProfile") }}';
                }
            });
        }
    }

    function validateForm() {
        validated = true;
        var inputs = document.querySelectorAll('input, textarea');

        inputs.forEach(function(input) {
            if (input.value.trim() === '' && input.required) {
                alert('Please fill out all required fields.');
                input.focus();
                validated = false;
            }
        });

        return validated;
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
