@extends('master_dashboard')
@section('title')
    Student | List
@endsection

@section('content-title')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-account-multiple-plus-outline"></i>
    </span> List Student
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Student</a></li>
    <li class="breadcrumb-item active" aria-current="page">
        List Student <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
    </li>
@endsection

@section('content-body')
    <table class="table table-hover table-light text-center" id="show-table">
        <thead>
            <tr>
                <th colspan="11">
                    <div class="col-12 d-flex justify-content-between">
                        {{-- @can('create course') --}}
                        <div class="col-3 d-flex justify-content-start">
                            <button data-url="{{route('create.student')}}" id="btn-open-create" data-modal-title="Create Student Form" class="btn btn-primary">Create Student</button>
                        </div>
                        {{-- @endcan --}}
                        <div class="col-8 d-flex justify-content-end">
                            <form class="col-8 d-flex" action="{{ route('index.student') }}">
                                <input type="text" name="search" id="search_txt" placeholder="Search Name..."
                                    class="form-control me-2">
                                <button class="btn btn-primary me-2">Search</button>
                                <a href="{{ route('index.student') }}" class="btn btn-secondary">Clear</a>
                            </form>
                        </div>
                    </div>
                </th>
            </tr>
            <tr>
                <th>N<sup>o</sup></th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Score</th>
                <th>Status</th>
                <th>Course</th>
                <th>Created_by</th>
                <th>Created_at</th>
                <th>Updated_at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $index => $student  )
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$student->first_name}}</td>
                    <td>{{$student->last_name}}</td>
                    <td>{{$student->gender}}</td>
                    <td>{{$student->score}}</td>
                    <td>{{$student->status}}</td>
                    <td>{{$student->course->title}}</td>
                    <td>{{ $student->user?->fullName() ?? 'Unknown' }}</td>
                    <td>{{\Carbon\Carbon::parse($student->created_at)->format('d-m-Y')}}</td>
                    <td>{{\Carbon\Carbon::parse($student->updated_at)->format('d-m-Y')}}</td>

                    <td>
                        <button class="btn btn-warning btn-edit-student" data-url="{{ route('edit.student', $student->id) }}"
                            data-modal-title="Edit student Form" data-id="{{ $student->id }}">
                            {!! icon_edit() !!} Edit</button>
                        <button class="btn btn-danger btn-remove-student" data-remove-id="{{ $student->id }}" data-bs-toggle="modal" data-bs-target="#removeModal">
                            {!! icon_remove() !!}Remove</button>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="11">
                    <div class="d-flex col-12 justify-content-end">
                        @for ($i = 1; $i <= $total_pages; $i++)
                            <button id="btn-page" data-page-number="{{$i}}"
                                class="btn btn-page btn-secondary p-2 me-2">{{$i}}</button>
                        @endfor
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="removeModal" tabindex="-1" aria-labelledby="removeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="removeModalLabel">Remove student</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('delete.student') }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <label for="" class="h4">Do you want to remove this student?</label>
                        <input type="hidden" id="remove-id" name="remove_id">
                        <div class="mt-2">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-success">No</button>
                            <button class="btn btn-danger">Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script-path')
    <script>
         $(document).on('click', '.btn-edit-student', function() {
            let url = $(this).data('url');
            let title = $(this).data('modal-title');
            $('#btn-show-modal').click();
            $('.modal-title').text(title);
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

        $(document).on('click', '.btn-remove-student', function() {
            var id = $(this).data('remove-id');
            $('#remove-id').val(id);
        })
    </script>
@endpush
