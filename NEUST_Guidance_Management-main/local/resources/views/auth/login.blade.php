<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" href="../img/logo.png"></link>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Guidance Management</title>
</head>
{{-- <style>
    body{
        background-image: url("{{ asset('img/bnhs-background.jpg') }}");
        background-size: cover;
        background-repeat: no-repeat;
    }


</style> --}}
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h1>Create Account</h1>
                {{-- <div class="social-container">
                    <a href="#" class="social"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social"><i class="bi bi-google"></i></a>
                </div>
                <span>or use your email for registration</span> --}}

                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="First Name">

                @error('first_name')
                    <script>
                        const container = document.getElementById('container');
                        container.classList.add("right-panel-active");

                        var register_firstname_error_message = @json($message);
                        Swal.fire({
                            title: 'Error!',
                            text: register_firtname_error_message,
                            icon: 'error', // This sets the red 'X' icon
                            confirmButtonText: 'Try Again'
                        });
                    </script>
                @enderror

                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder="Last Name">

                @error('last_name')
                    <script>
                        const container = document.getElementById('container');
                        container.classList.add("right-panel-active");

                        var register_lastname_error_message = @json($message);
                        Swal.fire({
                            title: 'Error!',
                            text: register_lastname_error_message,
                            icon: 'error', // This sets the red 'X' icon
                            confirmButtonText: 'Try Again'
                        });
                    </script>
                @enderror

                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

                @error('email')
                    <script>
                        const container = document.getElementById('container');
                        container.classList.add("right-panel-active");

                        var register_email_error_message = @json($message);
                        Swal.fire({
                            title: 'Oops!',
                            text: register_email_error_message,
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });

                    </script>
                @enderror

                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

                @error('password')
                    <script>
                        const container = document.getElementById('container');
                        container.classList.add("right-panel-active");

                        var register_password_error_message = @json($message);
                        Swal.fire({
                            title: 'Oops!',
                            text: register_password_error_message,
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    </script>
                @enderror

                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">

                <button type="submit">Create Account</button>
            </form>
        </div>

        <div class="form-container sign-in-container">
            <form  id="loginForm" action="{{ route('login') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h1>Sign in</h1>
                {{-- <div class="social-container">
                    <a href="#" class="social"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social"><i class="bi bi-google"></i></a>
                </div>
                <span>or use your account</span> --}}

                <input id="login_email" type="login_email" class="form-control @error('login_email') is-invalid @enderror" name="login_email" value="{{ old('login_email') }}" required autocomplete="login_email" autofocus placeholder="Email">

                @error('login_email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="login_password" type="password" class="form-control @error('login_password') is-invalid @enderror" name="login_password" required autocomplete="current-password" placeholder="Password">

                @error('login_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                {{-- <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label> --}}

                <button type="submit">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <img src="{{ asset('img/logo.png') }}" alt="" style="width:100px;">
                    <h1>Good day, Student!</h1>
                    <p>Already have an account? Sign in to continue</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <img src="{{ asset('img/logo.png') }}" alt="" style="width:100px; ">
                    <h1>Good day, Student!</h1>
                    <p>No, Account? Sign up to continue</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        // const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
        // document.getElementById('loginForm').addEventListener('submit', async function(event) {
        //     event.preventDefault();

        //     await Swal.fire({
        //         icon: 'error',
        //         title: 'Oops...',
        //         text: 'Invalid email or password!',
        //         confirmButtonText: 'OK'
        //     });
        // });

        @if(session('ErrorMsg'))
            Swal.fire({
                title: 'Error!',
                text: "{{ session('ErrorMsg') }}",
                icon: 'error', // This sets the red 'X' icon
                confirmButtonText: 'Try Again'
            });
        @endif

        @if(session('registration_success'))
            Swal.fire({
                title: 'Registration Successful!',
                text: "{{ session('registration_success') }}",
                icon: 'success',
                timer: 3000, // Auto-close the alert after 3 seconds
                showConfirmButton: false // Hide the confirm button since the alert auto-closes
            });
        @endif

        @if(session('student_drop_status'))
            Swal.fire({
                title: "You are already dropped.",
                text: "You don't have access to this system. Please contact your counselor if this is a mistake.",
                icon: "error",
                confirmButtonColor: "#ff0000",
                confirmButtonText: "Ok",
            });
        @endif
    </script>
</body>
</html>




