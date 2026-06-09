@extends('master_dashboard')
@section('title')
    Course | List
@endsection

@section('content-title')
    <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-account-multiple-plus-outline"></i>
    </span> List Course
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Course</a></li>
    <li class="breadcrumb-item active" aria-current="page">
        List Course <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
    </li>
@endsection

@section('content-body')
    <table class="table table-hover table-light text-center" id="show-table">
        <thead>
            <tr>
                <th colspan="7">
                    <div class="col-12 d-flex justify-content-between">
                        @can('create course')
                        <div class="col-3 d-flex justify-content-start">
                            <button data-url="{{route('create.course')}}" id="btn-open-create" data-modal-title="Create course Form" class="btn btn-primary">Create course</button>
                        </div>
                        @endcan
                        <div class="{{Auth::user()->can('create course') ? 'col-8' : 'col-12' }} d-flex justify-content-end">
                            <form class="col-8 d-flex" action="{{ route('index.course') }}">
                                <input type="text" name="search" id="search_txt" placeholder="Search Name..."
                                    class="form-control me-2">
                                <button class="btn btn-primary me-2">Search</button>
                                <a href="{{ route('index.course') }}" class="btn btn-secondary">Clear</a>
                            </form>
                        </div>
                    </div>
                </th>
            </tr>
            <tr>
                 <th>N<sup>o</sup></th>
                <th>Title</th>
                <th>Price</th>
                <th>Teacher</th>
                <th>Start Date</th>
                <th>End Date</th>
                @canany(['edit course', 'remove course'])
                    <th>Action</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $index => $course  )
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$course->title}}</td>
                    <td>{{$course->price}}$</td>
                    <td>{{$course->user->fullName()}}</td>
                    <td>{{$course->start_date}}</td>
                    <td>{{$course->end_date ?? "Not Sure End Date"}}</td>
                    @canany(['edit course', 'remove course'])
                        <td>
                            @can('edit course')
                                <button class="btn btn-warning" data-url="{{ route('edit.course', $course->id) }}"
                                    id="btn-open-create" data-modal-title="Edit course Form" data-id="{{ $course->id }}">
                                    {!! icon_edit() !!} Edit</button>
                            @endcan
                            @can('remove course')
                                <button class="btn btn-danger" id="btn-remove" data-remove-id="{{ $course->id }}" data-bs-toggle="modal" data-bs-target="#removeModal">
                                {!! icon_remove() !!}Remove</button>
                            @endcan
                        </td>
                    @endcanany
                </tr>
            @endforeach
            <tr>
                <td colspan="7">
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
                    <h1 class="modal-title fs-5" id="removeModalLabel">Remove Course</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('delete.course') }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <label for="" class="h4">Do you want to remove this course?</label>
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
         $(document).on('click', '#btn-remove', function() {

            var id = $(this).data('remove-id');
            const urlParams = new URLSearchParams(window.location.search);
            const search = urlParams.get('search');
            const pageNumber = urlParams.get('page')
            $('#remove-id').val(id)
            $('#search').val(search)
            $('#page').val(page)

        })
    </script>
@endpush
