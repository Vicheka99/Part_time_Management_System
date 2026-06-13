@extends('master_dashboard')

@section('title', 'Teachers')

@section('content-title')
    <span class="student-page-heading">
        <strong>Teachers</strong>
        <small>Manage teacher profiles and assignments</small>
    </span>
@endsection

@section('breadcrumb')
    <button data-url="{{ route('create.user') }}" id="btn-open-create" data-modal-title="Add Teacher" class="btn student-add-button">
        <i class="mdi mdi-plus"></i> Add Teacher
    </button>
@endsection

@section('content-body')
    <div class="col-12 teacher-directory">
        <form action="{{ route('index.user') }}" class="student-search teacher-search">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search teachers...">
        </form>

        <div class="teacher-grid">
            @forelse ($teachers as $teacher)
                @php
                    $initials = strtoupper(substr($teacher->first_name, 0, 1) . substr($teacher->last_name, 0, 1));
                    $colors = ['blue', 'purple', 'green', 'amber', 'rose', 'cyan'];
                    $color = $colors[$loop->index % count($colors)];
                    $courseNames = $teacher->courses->pluck('title')->take(2)->join(', ');
                @endphp
                <article class="teacher-card">
                    <div class="teacher-card-header">
                        @if ($teacher->profile)
                            <img class="teacher-avatar-image" src="{{ asset('assets/images/teacher/' . $teacher->profile) }}" alt="">
                        @else
                            <span class="teacher-avatar {{ $color }}">{{ $initials }}</span>
                        @endif
                        <div>
                            <strong>{{ $teacher->fullName() }}</strong>
                            <small>TCH-{{ str_pad($teacher->id, 3, '0', STR_PAD_LEFT) }}</small>
                        </div>
                        <span class="teacher-status">Active</span>
                    </div>
                    <div class="teacher-contact">
                        <span><i class="mdi mdi-book-open-variant"></i> {{ $courseNames ?: 'No classes assigned' }}</span>
                        <span><i class="mdi mdi-email-outline"></i> {{ $teacher->email }}</span>
                    </div>
                    <div class="teacher-metrics">
                        <span><strong>{{ $teacher->courses_count }}</strong><small>Classes</small></span>
                        <span><strong>{{ $teacher->students_count }}</strong><small>Students</small></span>
                        <span><strong>{{ (int) ($teacher->created_at?->diffInYears(now()) ?? 0) }} yrs</strong><small>Account Age</small></span>
                    </div>
                    <div class="teacher-card-actions">
                        <button data-url="{{ route('edit.user', $teacher->id) }}" id="btn-open-create" data-modal-title="Edit Teacher" class="teacher-card-edit">Edit</button>
                        @can('remove users')
                            <button type="button" class="teacher-card-delete" data-delete-record data-delete-url="{{ route('delete.user') }}" data-delete-id="{{ $teacher->id }}" data-delete-param="id" data-delete-type="teacher" data-delete-name="{{ $teacher->fullName() }}">Delete</button>
                        @endcan
                    </div>
                </article>
            @empty
                <div class="course-empty">No teachers found.</div>
            @endforelse
        </div>

        @if ($teachers->hasPages())
            <div class="course-pagination">
                <span>Showing {{ $teachers->firstItem() }}-{{ $teachers->lastItem() }} of {{ $teachers->total() }} teachers</span>
                <div>
                    @if (!$teachers->onFirstPage()) <a href="{{ $teachers->previousPageUrl() }}">Previous</a> @endif
                    @if ($teachers->hasMorePages()) <a href="{{ $teachers->nextPageUrl() }}">Next</a> @endif
                </div>
            </div>
        @endif
    </div>
@endsection
