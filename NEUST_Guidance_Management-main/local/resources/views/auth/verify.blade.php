@extends('layouts.app')

@section('content')
<style>
    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #4169e1;
        color: #fff;
        border-bottom: none;
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
        font-size: 1.25rem;
        font-weight: 500;
    }
    .card-body {
        padding: 2rem;
    }
    .btn-link {
        color: #007bff;
        text-decoration: none;
    }
    .btn-link:hover {
        color: #0056b3;
        text-decoration: underline;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="row justify-content-center w-100">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">{{ __('Verify Your Email Address') }}</div>
                    <div class="card-body">
                        @if (session('resent'))
                            <script>
                                Swal.fire({
                                    title: "Email Sent!",
                                    text: "Please check your email.",
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            </script>
                        @endif
                        <p class="mb-3">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                        <p>{{ __('If you did not receive the email') }},</p>
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection
