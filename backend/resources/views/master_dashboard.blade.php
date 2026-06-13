<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-dashboard.css') }}?v={{ filemtime(public_path('assets/css/admin-dashboard.css')) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/edumanage-theme.css') }}?v={{ filemtime(public_path('assets/css/edumanage-theme.css')) }}">
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
                <strong class="me-auto">{{ config('app.name') }}</strong>
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
                        alt="{{ config('app.name') }}" /></a>
                <a class="navbar-brand brand-logo-mini" href="/"><img
                        src="{{ asset('assets/images/logo-mini.svg') }}" alt="{{ config('app.name') }}" /></a>
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
                                @if (Auth::user()->profile)
                                    <img src="{{ asset('assets/images/teacher/' . Auth::user()->profile) }}" alt="image">
                                @else
                                    <span class="profile-initials">{{ strtoupper(substr(Auth::user()->first_name, 0, 1) . substr(Auth::user()->last_name, 0, 1)) }}</span>
                                @endif
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
                @include('partials.admin_sidebar')
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
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">&copy; {{ now()->year }} {{ config('app.name') }}. All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">School management made simple.</span>
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

            async function refreshDashboardContent(url) {
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'text/html',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const html = await response.text();
                const page = new DOMParser().parseFromString(html, 'text/html');
                const nextContent = page.querySelector('.content-wrapper');

                if (!response.ok || !nextContent) {
                    throw new Error('Could not update the page content.');
                }

                document.querySelector('.content-wrapper').replaceWith(nextContent);
                document.title = page.title;
                window.history.pushState({}, '', url);
            }

            $(document).on('submit', '.student-form', async function(event) {
                event.preventDefault();

                const form = this;
                const submitButton = form.querySelector('button[type="submit"], button:not([type])');
                const originalText = submitButton ? submitButton.innerHTML : '';

                form.querySelectorAll('.is-invalid').forEach(function(field) {
                    field.classList.remove('is-invalid');
                });

                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';
                }

                try {
                    const response = await fetch(form.action, {
                        method: form.method,
                        body: new FormData(form),
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const data = await response.json();

                    if (!response.ok) {
                        Object.keys(data.errors || {}).forEach(function(name) {
                            const field = form.querySelector('[name="' + name + '"]');
                            if (field) field.classList.add('is-invalid');
                        });
                        throw new Error(data.message || 'Please check the form and try again.');
                    }

                    const modalElement = form.closest('.modal');
                    if (modalElement) {
                        bootstrap.Modal.getOrCreateInstance(modalElement).hide();
                    }

                    await refreshDashboardContent(data.redirect || window.location.href);
                    show_toast('Success', data.message);
                } catch (error) {
                    show_toast('Error', error.message);
                } finally {
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                    }
                }
            });

            $(document).on('submit', '.student-search', async function(event) {
                event.preventDefault();
                const url = new URL(this.action, window.location.origin);
                new FormData(this).forEach(function(value, key) {
                    if (value) url.searchParams.set(key, value);
                });

                try {
                    await refreshDashboardContent(url.toString());
                } catch (error) {
                    show_toast('Error', error.message);
                }
            });

            $(document).on('change', '.attendance-filters input, .attendance-filters select', async function() {
                const form = this.form;
                const url = new URL(form.action, window.location.origin);
                new FormData(form).forEach(function(value, key) {
                    if (value) url.searchParams.set(key, value);
                });
                try {
                    await refreshDashboardContent(url.toString());
                } catch (error) {
                    show_toast('Error', error.message);
                }
            });

            $(document).on('click', '[data-attendance-status]', async function() {
                const button = this;
                const actions = button.closest('.attendance-actions');
                const row = button.closest('[data-attendance-row]');
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('attendance_date', actions.dataset.date);
                formData.append('attendance[' + actions.dataset.student + ']', button.dataset.attendanceStatus);
                formData.append('course[' + actions.dataset.student + ']', actions.dataset.course || '');

                try {
                    const response = await fetch('{{ route('attendance.store') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}
                    });
                    const data = await response.json();
                    if (!response.ok) throw new Error(data.message || 'Could not save attendance.');

                    actions.querySelectorAll('button').forEach(function(item) {
                        item.className = '';
                    });
                    button.className = 'active ' + button.dataset.attendanceStatus;
                    const status = row.querySelector('[data-status]');
                    status.className = 'status-pill status-' + button.dataset.attendanceStatus;
                    status.textContent = button.dataset.attendanceStatus.charAt(0).toUpperCase() + button.dataset.attendanceStatus.slice(1);
                    row.querySelector('[data-check-in]').textContent = new Date().toLocaleTimeString([], {hour: 'numeric', minute: '2-digit'});
                    await refreshDashboardContent(window.location.href);
                    show_toast('Success', data.message);
                } catch (error) {
                    show_toast('Error', error.message);
                }
            });

            $(document).on('click', '.student-filters a, .student-page-button[href], .course-pagination a', async function(event) {
                event.preventDefault();
                try {
                    await refreshDashboardContent(this.href);
                } catch (error) {
                    show_toast('Error', error.message);
                }
            });

            $(document).on('click', '[data-course-view]', function() {
                $('[data-course-view]').removeClass('active');
                $(this).addClass('active');
                $('[data-course-grid]').toggleClass('list-view', $(this).data('course-view') === 'list');
            });

            $(document).on('click', '[data-delete-record]', async function() {
                const button = this;
                const type = button.dataset.deleteType;
                const result = await Swal.fire({
                    title: 'Delete ' + type + '?',
                    text: button.dataset.deleteName + ' will be permanently removed.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    confirmButtonColor: '#dc2626'
                });
                if (!result.isConfirmed) return;

                try {
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('_method', 'DELETE');
                    formData.append(button.dataset.deleteParam, button.dataset.deleteId);
                    const response = await fetch(button.dataset.deleteUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}
                    });
                    const data = await response.json();
                    if (!response.ok) throw new Error(data.message || 'Could not delete ' + type + '.');
                    await refreshDashboardContent(window.location.href);
                    show_toast('Success', data.message);
                } catch (error) {
                    show_toast('Error', error.message);
                }
            });

            function restoreAdminSettings() {
                const form = document.getElementById('admin-settings-form');
                const settings = JSON.parse(localStorage.getItem('adminSettings') || '{}');
                if (!form) return;
                Object.entries(settings).forEach(function([name, value]) {
                    const field = form.elements[name];
                    if (!field) return;
                    if (field.type === 'checkbox') field.checked = value;
                    else field.value = value;
                });
            }

            restoreAdminSettings();
            $(document).on('submit', '#admin-settings-form', function(event) {
                event.preventDefault();
                const settings = {};
                Array.from(this.elements).forEach(function(field) {
                    if (!field.name) return;
                    settings[field.name] = field.type === 'checkbox' ? field.checked : field.value;
                });
                localStorage.setItem('adminSettings', JSON.stringify(settings));
                show_toast('Success', 'Settings saved on this device.');
            });

        })
    </script>
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    @stack('script-path')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('[data-custom-sidebar="true"]');
            if (!sidebar) return;

            sidebar.querySelectorAll(':scope > .nav-item > .collapse').forEach(function (menu) {
                menu.addEventListener('show.bs.collapse', function () {
                    sidebar.querySelectorAll(':scope > .nav-item > .collapse.show').forEach(function (openMenu) {
                        if (openMenu !== menu) bootstrap.Collapse.getOrCreateInstance(openMenu, { toggle: false }).hide();
                    });
                });
            });
        });
    </script>
</body>

</html>
