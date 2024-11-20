@extends('layouts.app')
@section('content')
<div class="container">
    <div class="container" style="max-width: 800px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <h2>Request Appointment on Guidance</h2>

        <form action="{{ route('user.request.appointment') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            @csrf
            <div class="form-group mb-3">
                <label for="appointmentDate">Appointment Date:</label>
                <input type="date" class="form-control" id="appointmentDate" name="appointmentDate" required>
                @error('appointmentDate')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="appointmentTime">Appointment Time:</label>
                <input type="time" class="form-control" id="appointmentTime" name="appointmentTime" required>
                @error('appointmentTime')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="durationTo">Duration:</label>
                <div class="d-flex align-items-center">
                    <label for="durationFrom">From:</label>
                    <input type="time" class="form-control" id="durationFrom" name="durationFrom" readonly>
                    @error('durationFrom')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="durationTo">To:</label>
                    <input type="time" class="form-control" id="durationTo" name="durationTo" required>
                    @error('durationTo')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="subject">Subject:</label>
                <input type="text" class="form-control" id="subject" name="subject" required>
                @error('subject')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="reason">Reason:</label>
                <textarea class="form-control" id="reason" name="reason" rows="4" required></textarea>
                @error('reason')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit Request</button>
        </form>
    </div>



</div>
<script>

</script>
<script>
    $(document).ready(function(){
        var status = @json($status);

        checkUserValidity(status);

        //set default date and time
        $('#appointmentDate').val(getDate());
        $('#appointmentTime').val(getTime());
        $('#durationFrom').val(getTime());

        $('#appointmentTime').on('change', function(){
            //set duration from on change appointment time
            $('#durationFrom').val($(this).val());
        })

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

    function validateForm() {
        validated = true;
        var inputs = document.querySelectorAll('input, textarea');

        inputs.forEach(function(input) {
            if (input.value.trim() === '') {
                alert('Please fill out all required fields.');
                input.focus();
                validated = false;
            }
        });

        return validated;
    }


    function getDate(){
        const timestamp = Date.now();

        const currentDate = new Date(timestamp);

        const year = currentDate.getFullYear();
        const month = currentDate.getMonth() + 1;
        const day = currentDate.getDate();

        const formattedDate = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;

        return formattedDate;
    }

    function getTime(){

        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const seconds = now.getSeconds();

        const formattedTime = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;

        return formattedTime;
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
