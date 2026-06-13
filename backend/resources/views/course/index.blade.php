@extends('master_dashboard')

@section('title', 'Courses')

@section('content-title')
    <span class="student-page-heading">
        <strong>Courses</strong>
        <small>{{ $courses->total() }} {{ Str::plural('course', $courses->total()) }} this semester</small>
    </span>
@endsection

@section('breadcrumb')
    <button data-url="{{ route('create.course') }}" id="btn-open-create" data-modal-title="New Course" class="btn student-add-button">
        <i class="mdi mdi-plus"></i> New Course
    </button>
@endsection

@section('content-body')
    <div class="col-12 course-directory">
        <div class="course-toolbar">
            <form action="{{ route('index.course') }}" class="student-search">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search courses...">
            </form>
            <div class="course-view-toggle" aria-label="Course view">
                <button class="active" type="button" data-course-view="grid" aria-label="Grid view"><i class="mdi mdi-view-grid-outline"></i></button>
                <button type="button" data-course-view="list" aria-label="List view"><i class="mdi mdi-format-list-bulleted"></i></button>
            </div>
        </div>

        <div class="course-grid" data-course-grid>
            <div class="course-list-header">
                <span>Course</span>
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
                        <span class="course-tag {{ $color }}">Course {{ str_pad($course->id, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="course-name">
                        <h4>{{ $course->title }}</h4>
                        <span class="course-list-tag {{ $color }}">Course {{ str_pad($course->id, 2, '0', STR_PAD_LEFT) }}</span>
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
                    <button data-url="{{ route('edit.course', $course->id) }}" id="btn-open-create" data-modal-title="Edit Course" class="course-menu" aria-label="Edit {{ $course->title }}"><span>Edit</span><i class="mdi mdi-dots-horizontal"></i></button>
                </article>
            @empty
                <div class="course-empty">No courses found.</div>
            @endforelse
        </div>

        @if ($courses->hasPages())
            <div class="course-pagination">
                <span>Showing {{ $courses->firstItem() }}-{{ $courses->lastItem() }} of {{ $courses->total() }} courses</span>
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
