@extends('master_dashboard')

@section('title', 'Students')

@section('content-title')
    <span class="student-page-heading">
        <strong>Students</strong>
        <small>Manage student records and enrollment</small>
    </span>
@endsection

@section('breadcrumb')
    <button data-url="{{ route('create.student') }}" id="btn-open-create" data-modal-title="Create Student" class="btn student-add-button">
        <i class="mdi mdi-plus"></i> Add Student
    </button>
@endsection

@section('content-body')
    <div class="col-12 student-directory">
        <div class="student-toolbar">
            <form action="{{ route('index.student') }}" class="student-search">
                @if (request('filter'))
                    <input type="hidden" name="filter" value="{{ request('filter') }}">
                @endif
                <i class="mdi mdi-magnify"></i>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search by name or ID...">
            </form>
            <div class="student-filters">
                <a class="{{ request('filter') ? '' : 'active' }}" href="{{ route('index.student', ['search' => request('search')]) }}">All</a>
                <a class="{{ request('filter') === 'active' ? 'active' : '' }}" href="{{ route('index.student', ['filter' => 'active', 'search' => request('search')]) }}">Active</a>
                <a class="{{ request('filter') === 'at-risk' ? 'active' : '' }}" href="{{ route('index.student', ['filter' => 'at-risk', 'search' => request('search')]) }}">At Risk</a>
            </div>
        </div>

        <div class="student-table-card">
            <div class="table-responsive">
                <table class="table student-table">
                    <thead>
                        <tr><th>Student</th><th>Grade</th><th>Email</th><th>Attendance</th><th>Status</th><th></th></tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            @php
                                $initials = strtoupper(substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1));
                                $attendance = $student->attendances_count > 0 ? round($student->attended_count / $student->attendances_count * 100) : null;
                                $atRisk = in_array(strtolower($student->status), ['inactive', 'at risk']);
                                $progressColor = $attendance === null || $attendance >= 90 ? 'good' : ($attendance >= 75 ? 'warning' : 'danger');
                            @endphp
                            <tr>
                                <td>
                                    <div class="student-identity">
                                        <span class="student-avatar avatar-{{ $loop->index % 6 }}">{{ $initials }}</span>
                                        <span><strong>{{ $student->first_name }} {{ $student->last_name }}</strong><small>STU-{{ str_pad($student->id, 4, '0', STR_PAD_LEFT) }}</small></span>
                                    </div>
                                </td>
                                <td>{{ $student->course?->title ?? 'Unassigned' }}</td>
                                <td>{{ $student->user?->email ?? 'No email' }}</td>
                                <td>
                                    <div class="attendance-meter">
                                        <span class="attendance-track"><span class="{{ $progressColor }}" style="width: {{ $attendance ?? 0 }}%"></span></span>
                                        <strong>{{ $attendance === null ? '--' : $attendance . '%' }}</strong>
                                    </div>
                                </td>
                                <td><span class="student-status {{ $atRisk ? 'at-risk' : 'active' }}">{{ $atRisk ? 'At Risk' : 'Active' }}</span></td>
                                <td>
                                    <button data-url="{{ route('edit.student', $student->id) }}" id="btn-open-create" data-modal-title="Edit Student" class="student-action" aria-label="Edit {{ $student->first_name }}">
                                        <i class="mdi mdi-dots-horizontal"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-5">No students found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="student-table-footer">
                <span>Showing {{ $students->firstItem() ?? 0 }}-{{ $students->lastItem() ?? 0 }} of {{ $students->total() }} students</span>
                <div>
                    @if ($students->onFirstPage())
                        <span class="student-page-button disabled">Previous</span>
                    @else
                        <a class="student-page-button" href="{{ $students->previousPageUrl() }}">Previous</a>
                    @endif
                    @if ($students->hasMorePages())
                        <a class="student-page-button" href="{{ $students->nextPageUrl() }}">Next</a>
                    @else
                        <span class="student-page-button disabled">Next</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
