@extends('master_dashboard')
@section('title')
    Teacher | List
@endsection

@section('content-title')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-account-multiple-plus-outline"></i>
    </span> List Teacher
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Teacher</a></li>
    <li class="breadcrumb-item active" aria-current="page">
        List Teacher <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
    </li>
@endsection

@section('content-body')
    <table class="table table-hover table-light text-center" id="show-table">
        <thead>
            <tr>
                <th colspan="5">
                    <div class="col-12 d-flex justify-content-end">
                        <form class="col-5 d-flex" action="{{ route('index.user') }}">
                            <input type="text" name="search" id="search_txt" placeholder="Search Name..."
                                class="form-control me-2">
                            <button class="btn btn-primary me-2">Search</button>
                            <a href="{{ route('index.user') }}" class="btn btn-secondary">Clear</a>
                        </form>
                    </div>
                </th>
            </tr>
            <tr>
                <th>N<sup>o</sup></th>
                <th>Profile</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teachers as $index => $teacher)
                <tr>
                    <td>
                        {{ $index + 1 }}
                    </td>
                    <td>
                        <img src="{{ asset('assets/images/teacher/' . $teacher->profile) }}" alt="">
                    </td>
                    <td>{{ $teacher->fullName() }}</td>
                    <td>{{ $teacher->email }}</td>
                    <td>
                        <a href="{{ route('edit.user', $teacher->id) }}" class="btn btn-warning"> {!! icon_edit() !!}
                            Edit</a>
                        <button class="btn btn-danger" id="btn-remove" data-id="{{ $teacher->id }}">
                            {!! icon_remove() !!}Remove</button>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5">
                    <div class="d-flex col-12 justify-content-end">
                        @for ($i = 1; $i <= $total_pages; $i++)
                            <button id="btn-page" data-page-number="{{ $i }}"
                                class="btn btn-page btn-secondary p-2 me-2">{{ $i }}</button>
                        @endfor
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
@push('script-path')
    <script>
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
            let url = "{{ route('index.user') }}";
            if (search) {
                url = url + "?search=" + search
            }

            var fullUrl = new URL(url);
            fullUrl.searchParams.append('page', pageNumber)
            window.location.href = fullUrl;
        })

        function fullName(first_name, last_name, gender) {
            return (gender == "Male" ? "Mr. " : "Ms. ") + first_name + " " + last_name;
        }

        $(document).on('click', '#btn-remove', function() {

            var id = $(this).data('id');
            const urlParams = new URLSearchParams(window.location.search);
            const search = urlParams.get('search');
            const pageNumber = urlParams.get('page')
            if (search) {
                $('#search_txt').val(search);
            }

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success me-2",
                    cancelButton: "btn btn-danger me-2"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "It will remove from database",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ route('delete.user') }}",
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id,
                            search,
                            page:pageNumber,
                        },
                        success: function(response) {
                            console.log(response);

                            if (response.status === 200) {
                                swalWithBootstrapButtons.fire({
                                    title: "Deleted!",
                                    text: response.message,
                                    icon: "success"
                                });

                                let users = response.data;
                                let row = '';
                                users.forEach((user, index, array) => {
                                    row += `
                                            <tr>
                                                 <td>
                                                 ${index + 1}
                                                </td>
                                                <td>
                                                    <img src="{{ asset('assets/images/teacher/${user.profile}') }}" alt="">
                                                </td>
                                                <td>${fullName(user.first_name, user.last_name, user.gender)}</td>
                                                <td>${user.email}</td>
                                                <td>
                                                    <a href="/user/update/${user.id}" class="btn btn-warning"> {!! icon_edit() !!} Edit</a>
                                                    <button class="btn btn-danger" id="btn-remove" data-id="${user.id}"> {!! icon_remove() !!}Remove</button>
                                                </td>
                                            </tr>
                                        `;
                                });
                                // generate button pagination
                                var buttons = '';
                                for (let i = 1; i <= response.total_page; i++) {
                                    buttons += `<button id="btn-page" data-page-number="${i}"
                                        class="btn btn-page btn-secondary p-2 me-2">${i}</button>`
                                }
                                row += `
                                <tr>
                                    <td colspan="5">
                                        <div class="d-flex col-12 justify-content-end">
                                               ${buttons}
                                        </div>
                                    </td>
                                </tr>
                                `;
                                $('#show-table').find('tbody').html(row);
                            } else {
                                swalWithBootstrapButtons.fire({
                                    title: "Error",
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        }
                    })
        $(document).on('click', '#btn-remove', function() {
            var id = $(this).data('id');
            const urlParams = new URLSearchParams(window.location.search);
            const search = urlParams.get('search');
            const pageNumber = urlParams.get('page')
            if (search) {
                $('#search_txt').val(search);
            }
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success me-2",
                    cancelButton: "btn btn-danger me-2"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete.user') }}",
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: {
                            // _token: "{{ csrf_token() }}",
                            id
                        },
                        data: {
                            id
                        },
                        success: function(response) {
                                if (response.status === 200) {
                                    swalWithBootstrapButtons.fire({
                                        title: "Deleted!",
                                        text: response.message,
                                        icon: "success"
                                    });
                                    let users = response.data;
                                    let row = '';
                                    users.forEach((user, index, array) => {
                                        row += `
                                            <tr>
                                                 <td>
                                                 ${index + 1}
                                                </td>
                                                <td>
                                                    <img src="{{ asset('assets/images/teacher/${user.profile}') }}" alt="">
                                                </td>
                                                <td>${fullName(user.first_name, user.last_name, user.gender)}</td>
                                                <td>${user.email}</td>
                                                <td>
                                                    <a href="/user/update/${user.id}" class="btn btn-warning"> {!! icon_edit() !!} Edit</a>
                                                    <button class="btn btn-danger" id="btn-remove" data-id="${user.id}"> {!! icon_remove() !!}Remove</button>
                                                </td>
                                            </tr>
                                        `;
                                    });
                                    console.log(row);

                                    $('#show-table').find('tbody').html(row);
                            } else {
                                swalWithBootstrapButtons.fire({
                                    title: "Error",
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                            // location.reload()

                        }
                    })
                }
            });
        });

                }
            });
        })
    </script>
@endpush
