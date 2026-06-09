<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('assets/js/custome.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>



    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="liveToast" class=" toast text-light" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header" style="background-color: unset; color:unset;">
                <strong class="me-auto">Bootstrap</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
        </div>
    </div>
    @if (Session::has('Success'))
        <script>
            let message = @json(Session::get('Success'));
            show_toast("Success", message)
        </script>
    @endif
    @if (Session::has('Error'))
        <script>
            let message = @json(Session::get('Error'));
            show_toast("Error", message)
        </script>
    @endif

    <div class="container-scroller">

        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <a class="navbar-brand brand-logo" href="/"><img src="{{ asset('assets/images/logo.svg') }}"
                        alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="/"><img
                        src="{{ asset('assets/images/logo.svg') }}" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>

                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="nav-profile-img">
                                <img src="{{ asset('assets/images/teacher/' . Auth::user()->profile) }}"
                                    alt="image">
                                <span class="availability-status online"></span>
                            </div>
                            <div class="nav-profile-text">
                                <p class="mb-1 text-black">{{ Auth::user()->fullName() }}</p>
                            </div>
                        </a>
                        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn"><i class="mdi mdi-logout me-2 text-primary"></i> Signout
                                    </a></button>
                            </form>
                        </div>
                    </li>

                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <span class="menu-title">Dashboard</span>
                            <i class="mdi mdi-home menu-icon"></i>
                        </a>
                    </li>
                    @can(['create users', 'edit users', 'remove users', 'view users'])
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                                aria-controls="ui-basic">
                                <span class="menu-title">Teacher</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-basic">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('create.user') }}">Register Teacher</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('index.user') }}">View Teacher</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan
                    @can('view course')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('index.course') }}" aria-expanded="false"
                                aria-controls="ui-basic">
                                <span class="menu-title">Course</span>
                            </a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index.student') }}" aria-expanded="false"
                            aria-controls="ui-basic">
                            <span class="menu-title">Student</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            @yield('content-title')
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                @yield('breadcrumb')
                            </ul>
                        </nav>
                    </div>
                    <div class="row">
                        @yield('content-body')
                    </div>
                </div>
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2025 <a
                                href="https://www.bootstrapdash.com/" target="_blank">EduDash</a></span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made
                            with <i class="mdi mdi-heart text-danger"></i></span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary d-none" id="btn-show-modal" data-bs-toggle="modal"
        data-bs-target="#exampleModal"></button>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            const urlParams = new URLSearchParams(window.location.search);
            const search = urlParams.get('search');
            if (search) {
                $('#search_txt').val(search);
            }

            const page = urlParams.get('page');
            if (page) {
                let btnPage = $('.btn-page');
                // console.log(btnPage);

                btnPage.each((index, element) => {
                    // console.log($(element).data('page-number'));
                    if ($(element).data('page-number') == page) {
                        // console.log(element);
                        $(element).removeClass('btn-secondary')
                        $(element).addClass('btn-primary')
                    }
                });

            }

            $(document).on('click', '#btn-page', function() {
                let pageNumber = $(this).data('page-number')
                let url = window.location.origin + window.location.pathname;
                console.log(url);

                if (search) {
                    url = url + "?search=" + search
                }

                var fullUrl = new URL(url);
                fullUrl.searchParams.append('page', pageNumber)
                window.location.href = fullUrl;
            })

            $(document).on('click', '.preview-profile', function() {
                $('#profile').click()
            })
            $(document).on('change', '#profile', function() {
                var formData = new FormData();
                // console.log( $('#profile'));
                // console.log( $('#profile')[0]);
                // console.log($('#profile')[0].files);
                // console.log($('#profile')[0].files[0]);
                var profile = $('#profile')[0].files[0];
                formData.append('profile', profile)

                $.ajax({
                    // url: '/upload-file'
                    url: "{{ route('uploadFile') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    caches: false,
                    success: function(response) {
                        console.log(response);
                        $('#show-profile').attr('src',
                            '{{ asset('assets/images/teacher/') }}' + "/" + response)
                        $('#profile_name').val(response);
                    }
                });
            })

            $(document).on('click', '#btn-open-create', function() {
                let tittle = $(this).data('modal-title');
                let url = $(this).data('url');
                $('#btn-show-modal').click();
                $('.modal-title').text(tittle);

                $.ajax({
                    url,
                    method: 'get',
                    success: function(response) {
                        $('.modal-body').html(response)
                    },
                    error: function() {
                        console.log("Error");

                    }
                });
            })

        })
    </script>
    @stack('script-path')
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>
