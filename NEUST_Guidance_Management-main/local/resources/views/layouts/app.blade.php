<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Guidance Management</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    {{-- <link rel="icon" href="img/logo.png"></link> --}}
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.css" rel="stylesheet" />

</head>

<body>
    <div id="app">
        <aside id="sidebar">
            <div class="logo-section">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width: 50px;">
                <!-- <span>GUIDANCE</span>
                <span>MANAGEMENT</span> -->
            </div>
            <ul class="sidebar-nav">
                @guest
                @else
                    @php
                        $currentRoute = Route::currentRouteName();
                    @endphp
                    @if (Auth::user()->user_type == 2 )
                        <li class="sidebar-item {{ $currentRoute == 'user.viewDashboard' ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('user.viewDashboard') }}">
                                <i class="bi bi-house-door-fill"></i>
                                <span>Guidance Management</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ in_array($currentRoute, ['user.viewFormAppointment', 'user.viewFormDrop', 'user.viewFormMoral']) ? 'active' : '' }}">
                            <a class="sidebar-link" href="#">
                                <i class="bi bi-ui-checks"></i>
                                <span>{{ __('Request Forms') }}</span>
                            </a>
                            <ul id="submenu">
                                <li><a class="{{ $currentRoute == 'user.viewFormAppointment' ? 'active' : '' }}" href="{{ route('user.viewFormAppointment') }}">Request Appointment</a></li>
                                <li><a class="{{ $currentRoute == 'user.viewFormDrop' ? 'active' : '' }}" href="{{ route('user.viewFormDrop') }}">Request for Dropping</a></li>
                                <li><a class="{{ $currentRoute == 'user.viewFormMoral' ? 'active' : '' }}" href="{{ route('user.viewFormMoral') }}">Request Good Moral Certificate</a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item {{ $currentRoute == 'user.viewAppointments' ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('user.viewAppointments') }}">
                                <i class="bi bi-calendar-check-fill"></i>
                                <span>{{ __('My Appointments') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ $currentRoute == 'user.viewReportForm' ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('user.viewReportForm') }}">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <span>{{ __('Report Concern') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ $currentRoute == 'user.viewCOC' ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('user.viewCOC') }}">
                                <i class="bi bi-book-fill"></i>
                                <span>{{ __('Code of Conduct') }}</span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->user_type == 1)
                        <li class="sidebar-item {{ $currentRoute == 'admin.viewDashboard' ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.viewDashboard') }}">
                                <i class="bi bi-house-door-fill"></i>
                                <span>Guidance Management</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ $currentRoute == 'admin.viewStudentList' ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.viewStudentList') }}">
                                <i class="bi bi-people-fill"></i>
                                <span class="nav-text">{{ __('Student List') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ $currentRoute == 'admin.viewReports' ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.viewReports') }}">
                                <i class="bi bi-person-fill-exclamation"></i>
                                <span>{{ __('Student Reports') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ $currentRoute == 'admin.viewDropRequestList' ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.viewDropRequestList') }}">
                                <i class="bi bi-person-fill-x"></i>
                                <span>{{ __('Student Drop') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ $currentRoute == 'admin.viewGoodMoralList' ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.viewGoodMoralList') }}">
                                <i class="bi bi-award-fill"></i>
                                <span>{{ __('Student Good Moral') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ $currentRoute == 'admin.viewAppointments' ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.viewAppointments') }}">
                                <i class="bi bi-calendar-check-fill"></i>
                                <span>{{ __('Student Appointments') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ $currentRoute == 'admin.viewForms' ? 'active' : '' }} {{ in_array($currentRoute, ['admin.viewReferralForm', 'admin.viewGoodMoralCert', 'admin.viewHomeVisitationForm', 'admin.viewTravelForm']) ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.viewForms') }}">
                                <i class="bi bi-ui-checks"></i>
                                <span>{{ __('Generate Forms') }}</span>
                            </a>
                            {{-- <ul id="submenu">
                                <li><a data-id="2" href="#">Good Moral Certificate</a></li>
                                <li><a data-id="3" href="#">Home Visitation Form</a></li>
                                <li><a data-id="4" href="#">Travel Order Form</a></li>
                            </ul> --}}
                        </li>
                        <li class="sidebar-item {{ $currentRoute == 'admin.viewSrdRecords' ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.viewSrdRecords') }}">
                                <i class="bi bi-folder-fill"></i>
                                <span>{{ __('SARDO Records') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ $currentRoute == 'admin.viewCreateModule' ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.viewCreateModule') }}">
                                <i class="bi bi-file-earmark-plus-fill"></i>
                                <span>{{ __('Create Module') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ $currentRoute == 'admin.viewCOC' ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.viewCOC') }}">
                                <i class="bi bi-book-fill"></i>
                                <span>{{ __('Code of Conduct') }}</span>
                            </a>
                        </li>
                    @endif

            </ul>
            <div class="sidebar-footer">
                @if(Auth::user()->user_type == 2)
                <a class="sidebar-link text-capitalize" href="{{ route('user.viewProfile') }}">
                    <i class="bi bi-person-fill"></i>
                    <span class="nav-text">
                        {{ Auth::user()->first_name}} {{ Auth::user()->last_name }}
                    </span>
                </a>
                @endif
                @if(Auth::user()->user_type == 1)
                <a class="sidebar-link" href="{{ route('admin.viewAddAccount') }}">
                    <i class="bi bi-person-fill-add"></i>
                    <span class="nav-text">Add Counselor</span>
                </a>
                @endif
                <a class="sidebar-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>{{ __('Logout') }}</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
            @endguest
        </aside>

        <main class="main">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>

    @stack('scripts')

</body>
</html>
