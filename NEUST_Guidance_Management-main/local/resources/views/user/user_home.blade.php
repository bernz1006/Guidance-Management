@extends('layouts.app')
@section('content')
<div class="container">
    <div class="user-home-content">
        <div class="mission-container justify-content-center text-center shadow-lg" data-aos="fade-left">
            <h1>MISSION</h1>
            <p>To protect and promote the right of every Filipino to quality, equitable, culture-based, and complete basic education where</p>
            <p>Students learn in a child-friendly, gender-sensitive, safe and motivating environment</p>
            <p>Teachers facilitate learning and constantly nurture every learner</p>
            <p>Administrators and staff, as stewards of the institution, ensure an enabling and supportive environment for effective learning to happen</p>
            <p>Family, community and other stakeholders actively engaged and share responsibility for developing lifelong learners</p>
        </div>

        <div class="vision-container justify-content-center text-center shadow-lg" data-aos="fade-right">
            <h1>VISION</h1>
            <p>We dream of Filipinos who passionately love their country and whose competencies and values enable them to realize their full potential and contribute meaningfully to building the nation.</p>
            <p>We are a learner-centered public institution, the Department of Education continuously improves itself to better serve its stakeholders.</p>
        </div>

        <div class="benefits-container justify-content-center shadow-lg">
            <h1 class="text-center">BENEFITS OF COUNSELLING</h1>
            <ul class="benefits mr-5 ml-5">
                <h5>All students should not be:</h5>
                <li>You are accepted by the counsellor for who you are.</li>
                <li>It can offer a supportive non-judgmental and confidential setting in which you can explore any issue.</li>
                <li>It can help you see issues more objectively.</li>
                <li>It can help you express your feelings and come to terms with past experiences.</li>
                <li>It can help you build self-esteem and confidence.</li>
                <li>It can help you take control of your life and become more assertive.</li>
                <li>It can improve your communication.</li>
                <li>It can help you to become more realistic in setting goals.</li>
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function(){
        var status = @json($status);

        checkIfDrop(status);


        function checkIfDrop(status) {
            if (status == '0') {
                Swal.fire({
                    title: "You are already dropped.",
                    text: "You don't have access to this system. Please contact your counselor if this is a mistake.",
                    icon: "error",
                    confirmButtonColor: "#ff0000",
                    confirmButtonText: "Back",
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create a form element
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route("logout") }}';

                        // Add CSRF token to the form
                        const csrfToken = '{{ csrf_token() }}';
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = '_token';
                        input.value = csrfToken;
                        form.appendChild(input);

                        // Append the form to the body and submit it
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }
        }
    });
</script>

    <script>
        @if(session('login_success'))
        Swal.fire({
                title: 'Welcome User!',
                text: "{{ session('login_success') }}",
                icon: 'success',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('ErrorMsg'))
            Swal.fire({
                title: 'Error!',
                text: "{{ session('ErrorMsg') }}",
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endsection
