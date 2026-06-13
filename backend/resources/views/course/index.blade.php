@extends('master_dashboard')

@section('title', 'Classes')

@section('content-title')
    <span class="student-page-heading">
        <strong>Classes</strong>
        <small>{{ $courses->total() }} {{ Str::plural('class', $courses->total()) }} this semester</small>
    </span>
@endsection

@section('breadcrumb')
    <button data-url="{{ route('create.course') }}" id="btn-open-create" data-modal-title="New Class" class="btn student-add-button">
        <i class="mdi mdi-plus"></i> New Class
    </button>
@endsection

@section('content-body')
    <div class="col-12 course-directory">
        <div class="course-toolbar">
            <form action="{{ route('index.course') }}" class="student-search">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search classes...">
            </form>
            <div class="course-view-toggle" aria-label="Class view">
                <button class="active" type="button" data-course-view="grid" aria-label="Grid view"><i class="mdi mdi-view-grid-outline"></i></button>
                <button type="button" data-course-view="list" aria-label="List view"><i class="mdi mdi-format-list-bulleted"></i></button>
            </div>
        </div>

        <div class="course-grid" data-course-grid>
            <div class="course-list-header">
                <span>Class</span>
                <span>Teacher</span>
                <span>Students</span>
                <span>Start Date</span>
                <span>End Date</span>
                <span>Price</span>
                <span></span>
            </div>
            @forelse ($courses as $course)
                @php
                    $colors = ['blue', 'purple', 'green', 'amber', 'rose', 'cyan'];
                    $color = $colors[$loop->index % count($colors)];
                @endphp
                <article class="course-card">
                    <div class="course-card-top">
                        <span class="course-tag {{ $color }}">Class {{ str_pad($course->id, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="course-name">
                        <h4>{{ $course->title }}</h4>
                        <span class="course-list-tag {{ $color }}">Class {{ str_pad($course->id, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <p class="course-teacher">{{ $course->user?->fullName() ?? 'Teacher unassigned' }}</p>
                    <div class="course-card-details">
                        <span><i class="mdi mdi-account-outline"></i> {{ $course->students_count }} {{ Str::plural('student', $course->students_count) }}</span>
                        <span><i class="mdi mdi-calendar-blank-outline"></i> {{ \Carbon\Carbon::parse($course->start_date)->format('M d, Y') }} - {{ $course->end_date ? \Carbon\Carbon::parse($course->end_date)->format('M d, Y') : 'Ongoing' }}</span>
                        <span><i class="mdi mdi-currency-usd"></i> {{ number_format($course->price, 2) }}</span>
                    </div>
                    <span class="course-list-students">{{ $course->students_count }}</span>
                    <span class="course-list-start">{{ \Carbon\Carbon::parse($course->start_date)->format('M d, Y') }}</span>
                    <span class="course-list-end">{{ $course->end_date ? \Carbon\Carbon::parse($course->end_date)->format('M d, Y') : 'Ongoing' }}</span>
                    <span class="course-list-price">${{ number_format($course->price, 2) }}</span>
                    <div class="course-card-actions">
                        <button data-url="{{ route('edit.course', $course->id) }}" id="btn-open-create" data-modal-title="Edit Class" class="course-menu" aria-label="Edit {{ $course->title }}"><span>Edit</span><i class="mdi mdi-pencil-outline"></i></button>
                        @can('remove course')
                            <button type="button" class="record-delete-button" data-delete-record data-delete-url="{{ route('delete.course') }}" data-delete-id="{{ $course->id }}" data-delete-param="remove_id" data-delete-type="class" data-delete-name="{{ $course->title }}" aria-label="Delete {{ $course->title }}"><i class="mdi mdi-delete-outline"></i></button>
                        @endcan
                    </div>
                </article>
            @empty
                <div class="course-empty">No classes found.</div>
            @endforelse
        </div>

        @if ($courses->hasPages())
            <div class="course-pagination">
                <span>Showing {{ $courses->firstItem() }}-{{ $courses->lastItem() }} of {{ $courses->total() }} classes</span>
                <div>
                    @if (!$courses->onFirstPage()) <a href="{{ $courses->previousPageUrl() }}">Previous</a> @endif
                    @if ($courses->hasMorePages()) <a href="{{ $courses->nextPageUrl() }}">Next</a> @endif
                </div>
            </div>
        @endif
    </div>
@endsection

@push('script-path')
    <script>
        document.querySelectorAll('[data-course-view]').forEach(function (button) {
            button.addEventListener('click', function () {
                document.querySelectorAll('[data-course-view]').forEach(function (item) { item.classList.remove('active'); });
                button.classList.add('active');
                document.querySelector('[data-course-grid]').classList.toggle('list-view', button.dataset.courseView === 'list');
            });
        });
    </script>
@endpush
