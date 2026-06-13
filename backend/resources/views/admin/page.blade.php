@extends('master_dashboard')
@section('title', $title)
@section('content-title')
    @if ($page === 'attendance-take')
        <span class="student-page-heading"><strong>Attendance</strong><small>Track and manage daily attendance records</small></span>
    @elseif ($page === 'subject-list')
        <span class="student-page-heading"><strong>Subjects</strong><small>{{ $courses->count() }} {{ Str::plural('subject', $courses->count()) }} offered this year</small></span>
    @elseif ($page === 'attendance-summary')
        <span class="student-page-heading"><strong>Reports</strong><small>Analytics and insights for your academy</small></span>
    @elseif ($page === 'settings')
        <span class="student-page-heading"><strong>Settings</strong><small>Manage your school's configuration and preferences</small></span>
    @else
        <span class="page-title-icon bg-gradient-primary text-white me-2"><i class="mdi {{ $icon }}"></i></span> {{ $title }}
    @endif
@endsection
@section('breadcrumb')
    @if ($page === 'attendance-take')
        <button class="btn student-add-button" type="button" onclick="window.print()">Export Report</button>
    @elseif ($page === 'subject-list')
        <button data-url="{{ route('create.course') }}" id="btn-open-create" data-modal-title="Add Subject" class="btn student-add-button"><i class="mdi mdi-plus"></i> Add Subject</button>
    @elseif ($page === 'attendance-summary')
        <button class="btn student-add-button" type="button" onclick="window.print()">Generate Report</button>
    @else
        <li class="breadcrumb-item">{{ $group }}</li><li class="breadcrumb-item active">{{ $title }}</li>
    @endif
@endsection
@section('content-body')
    @if ($page === 'student-add')
        <div class="col-12"><div class="card admin-card"><div class="card-body">
            <div class="mb-4"><h4 class="card-title mb-1">Register New Student</h4><p class="text-muted">Create the student account and assign their class.</p></div>
            @include('student.create')
        </div></div></div>
    @elseif ($page === 'attendance-take')
        @php
            $present = $dayAttendances->where('status', 'present')->count();
            $absent = $dayAttendances->where('status', 'absent')->count();
            $late = $dayAttendances->where('status', 'late')->count();
            $rate = $dayAttendances->count() ? round(($present + $late) / $dayAttendances->count() * 100) : 0;
        @endphp
        <div class="col-12 attendance-page">
            <div class="attendance-summary">
                @foreach ([['Present', $present, 'present'], ['Absent', $absent, 'absent'], ['Late', $late, 'late'], ['Rate', $rate . '%', 'rate']] as [$label, $value, $class])
                    <div class="attendance-summary-card"><strong class="{{ $class }}">{{ $value }}</strong><span>{{ $label }}</span></div>
                @endforeach
            </div>
            <form class="attendance-filters" action="{{ route('admin.page', 'attendance-take') }}">
                <input type="date" name="date" value="{{ $attendanceDate }}">
                <select name="course"><option value="">All Classes</option>@foreach($courses as $course)<option value="{{ $course->id }}" {{ $courseId === $course->id ? 'selected' : '' }}>{{ $course->title }}</option>@endforeach</select>
            </form>
            <div class="attendance-table-card"><div class="table-responsive"><table class="table attendance-table">
                <thead><tr><th>Student</th><th>Class</th><th>Check-in Time</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                @forelse ($students as $student)
                    @php $record = $student->attendances->first(); $status = $record?->status; @endphp
                    <tr data-attendance-row>
                        <td><strong>{{ $student->first_name }} {{ $student->last_name }}</strong><small>STU-{{ str_pad($student->id, 4, '0', STR_PAD_LEFT) }}</small></td>
                        <td>{{ $student->course?->title ?? 'Unassigned' }}</td>
                        <td data-check-in>{{ $record ? $record->updated_at->format('g:i A') : '—' }}</td>
                        <td><span data-status class="status-pill {{ $status ? 'status-' . $status : 'status-unmarked' }}">{{ $status ? ucfirst($status) : 'Unmarked' }}</span></td>
                        <td><div class="attendance-actions" data-student="{{ $student->id }}" data-course="{{ $student->course_id }}" data-date="{{ $attendanceDate }}">
                            @foreach (['present' => 'P', 'late' => 'L', 'absent' => 'A'] as $value => $short)<button type="button" data-attendance-status="{{ $value }}" class="{{ $status === $value ? 'active ' . $value : '' }}">{{ $short }}</button>@endforeach
                        </div></td>
                    </tr>
                @empty <tr><td colspan="5" class="text-center text-muted py-5">No students found.</td></tr> @endforelse
                </tbody>
            </table></div></div>
        </div>
    @elseif (in_array($page, ['attendance-records', 'student-attendance']))
        <div class="col-12"><div class="card admin-card"><div class="card-body"><h4 class="card-title">{{ $title }}</h4>
            <div class="table-responsive"><table class="table module-table"><thead><tr><th>Date</th><th>Student</th><th>Class</th><th>Status</th></tr></thead><tbody>
            @forelse ($attendances as $record)<tr><td>{{ $record->attendance_date->format('M d, Y') }}</td><td>{{ $record->student?->fullName() ?? 'Deleted student' }}</td><td>{{ $record->course?->title ?? 'Unassigned' }}</td><td><span class="status-pill status-{{ $record->status }}">{{ $record->status }}</span></td></tr>
            @empty <tr><td colspan="4" class="text-center text-muted py-5">No attendance records yet.</td></tr> @endforelse
            </tbody></table></div>
        </div></div></div>
    @elseif ($page === 'attendance-summary')
        @php
            $averageScore = round($students->avg(fn ($student) => (float) $student->score) ?? 0, 1);
            $passRate = $students->count() ? round($students->filter(fn ($student) => (float) $student->score >= 50)->count() / $students->count() * 100, 1) : 0;
            $atRisk = $students->filter(fn ($student) => in_array(strtolower($student->status), ['at risk', 'inactive']))->count();
            $attendanceRate = $attendances->count() ? round($attendances->whereIn('status', ['present', 'late'])->count() / $attendances->count() * 100, 1) : 0;
        @endphp
        <div class="col-12 reports-page">
            <div class="report-charts">
                <div class="report-card"><h5>Monthly Attendance Breakdown</h5><div class="report-chart-wrap"><canvas id="attendanceReportChart"></canvas></div></div>
                <div class="report-card"><h5>Class Performance vs. Attendance</h5><div class="report-chart-wrap"><canvas id="performanceReportChart"></canvas></div></div>
            </div>
            <div class="report-kpis">
                <div><strong class="blue">{{ $averageScore }}</strong><span>Average Score</span><small>Across all students</small></div>
                <div><strong class="green">{{ $passRate }}%</strong><span>Pass Rate</span><small>Score of 50 or higher</small></div>
                <div><strong class="amber">{{ $atRisk }}</strong><span>At-Risk Students</span><small>Marked at risk or inactive</small></div>
                <div><strong class="green">{{ $attendanceRate }}%</strong><span>Attendance Rate</span><small>Present or late records</small></div>
            </div>
            <div class="report-card recent-reports"><h5>Recent Reports</h5>
                @foreach ([['Monthly Attendance Report', 'Attendance', 'blue'], ['Student Performance Summary', 'Academic', 'green'], ['Teacher Workload Analysis', 'Staff', 'purple']] as [$name, $type, $color])
                    <div class="report-row"><span class="report-file"><i class="mdi mdi-file-document-outline"></i></span><div><strong>{{ $name }}</strong><small>Generated from current academy data</small></div><span class="report-type {{ $color }}">{{ $type }}</span><button type="button" onclick="window.print()">Download</button></div>
                @endforeach
            </div>
        </div>
        @push('script-path')
            <script>
                new Chart(document.getElementById('attendanceReportChart'), {type:'bar',data:{labels:@json($monthlyAttendance->pluck('label')),datasets:[{label:'Present',data:@json($monthlyAttendance->pluck('present')),backgroundColor:'#4f5bff'},{label:'Absent / Late',data:@json($monthlyAttendance->pluck('missed')),backgroundColor:'#e5eaf2'}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom'}},scales:{y:{beginAtZero:true}}}});
                new Chart(document.getElementById('performanceReportChart'), {type:'line',data:{labels:@json($coursePerformance->pluck('label')),datasets:[{label:'Avg Score',data:@json($coursePerformance->pluck('score')),borderColor:'#4f5bff',backgroundColor:'#4f5bff',tension:.35},{label:'Attendance %',data:@json($coursePerformance->pluck('attendance')),borderColor:'#10b981',backgroundColor:'#10b981',tension:.35}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom'}},scales:{y:{beginAtZero:true,max:100}}}});
            </script>
        @endpush
    @elseif ($page === 'attendance-reports')
        @php $total = max(1, $attendances->count()); @endphp
        @foreach (['present' => 'success', 'absent' => 'danger', 'late' => 'warning', 'excused' => 'info'] as $status => $color)
            @php $count = $attendances->where('status', $status)->count(); @endphp
            <div class="col-md-3 grid-margin"><div class="card admin-card"><div class="card-body"><p class="text-muted text-capitalize">{{ $status }}</p><h2>{{ $count }}</h2><div class="progress mt-3"><div class="progress-bar bg-{{ $color }}" style="width: {{ round($count / $total * 100) }}%"></div></div></div></div></div>
        @endforeach
    @elseif ($page === 'subject-list')
        <div class="col-12 subject-page">
            <div class="subject-summary">
                <div><strong>{{ $courses->count() }}</strong><span>Total Subjects</span></div>
                <div><strong>{{ $courses->count() }}</strong><span>Total Classes</span></div>
                <div><strong>{{ $courses->sum(fn ($course) => $course->students->count()) }}</strong><span>Total Students</span></div>
            </div>
            <form class="student-search subject-search" action="{{ route('admin.page', 'subject-list') }}"><input type="search" name="search" value="{{ request('search') }}" placeholder="Search subjects..."></form>
            <div class="subject-grid">
                @forelse ($courses as $course)
                    @php
                        $colors = ['blue', 'purple', 'green', 'amber', 'cyan', 'rose'];
                        $icons = ['mdi-sigma', 'mdi-alpha-a', 'mdi-flask-outline', 'mdi-bank-outline', 'mdi-code-tags', 'mdi-palette-outline'];
                        $color = $colors[$loop->index % count($colors)];
                        $icon = $icons[$loop->index % count($icons)];
                    @endphp
                    <article class="subject-card">
                        <div class="subject-card-header"><span class="subject-icon {{ $color }}"><i class="mdi {{ $icon }}"></i></span><div><strong>{{ $course->title }}</strong><small>SUB-{{ str_pad($course->id, 3, '0', STR_PAD_LEFT) }}</small></div></div>
                        <p>Assigned to {{ $course->user?->fullName() ?? 'no teacher yet' }}.</p>
                        <div class="subject-metrics">
                            <span><strong>1</strong><small>Class</small></span>
                            <span><strong>{{ $course->user_id ? 1 : 0 }}</strong><small>Teacher</small></span>
                            <span><strong>{{ $course->students->count() }}</strong><small>Students</small></span>
                        </div>
                        <div class="subject-card-actions">
                            <button data-url="{{ route('edit.course', $course->id) }}" id="btn-open-create" data-modal-title="Edit Subject" class="teacher-edit-button">Edit</button>
                            @can('remove course')
                                <button type="button" class="teacher-card-delete" data-delete-record data-delete-url="{{ route('delete.course') }}" data-delete-id="{{ $course->id }}" data-delete-param="remove_id" data-delete-type="subject" data-delete-name="{{ $course->title }}">Delete</button>
                            @endcan
                        </div>
                    </article>
                @empty <div class="course-empty">No subjects found.</div> @endforelse
            </div>
        </div>
    @elseif (in_array($page, ['class-schedule', 'teacher-classes', 'class-students', 'subject-assign']))
        <div class="col-12"><div class="card admin-card"><div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3"><div><h4 class="card-title mb-1">{{ $title }}</h4><p class="text-muted mb-0">Classes are the current subject and schedule source.</p></div><button data-url="{{ route('create.course') }}" id="btn-open-create" data-modal-title="Create Class" class="btn btn-gradient-primary">Add Class</button></div>
            <div class="table-responsive"><table class="table module-table"><thead><tr><th>Class / Subject</th><th>Teacher</th><th>Schedule</th><th>Students</th><th></th></tr></thead><tbody>
            @forelse ($courses as $course)<tr><td><strong>{{ $course->title }}</strong><br><small class="text-muted">{{ \Illuminate\Support\Str::limit($course->description, 45) }}</small></td><td>{{ $course->user?->fullName() ?? 'Unassigned' }}</td><td>{{ $course->start_date }} - {{ $course->end_date ?? 'Ongoing' }}</td><td>{{ $course->students->count() }}</td><td><div class="record-actions"><button data-url="{{ route('edit.course', $course->id) }}" id="btn-open-create" data-modal-title="Edit Class" class="btn btn-sm btn-outline-primary">Manage</button>@can('remove course')<button type="button" class="btn btn-sm btn-outline-danger" data-delete-record data-delete-url="{{ route('delete.course') }}" data-delete-id="{{ $course->id }}" data-delete-param="remove_id" data-delete-type="class" data-delete-name="{{ $course->title }}">Delete</button>@endcan</div></td></tr>
            @empty <tr><td colspan="5" class="text-center text-muted py-5">No classes available.</td></tr> @endforelse
            </tbody></table></div>
        </div></div></div>
    @elseif ($page === 'student-performance')
        <div class="col-12"><div class="card admin-card"><div class="card-body"><h4 class="card-title">Student Performance</h4><div class="table-responsive"><table class="table module-table"><thead><tr><th>Student</th><th>Class</th><th>Score</th><th>Status</th></tr></thead><tbody>
        @forelse ($students->sortByDesc(fn ($student) => (float) $student->score) as $student)<tr><td>{{ $student->fullName() }}</td><td>{{ $student->course?->title ?? 'Unassigned' }}</td><td><strong>{{ $student->score }}</strong></td><td><span class="status-pill status-active">{{ $student->status }}</span></td></tr>
        @empty <tr><td colspan="4" class="text-center text-muted py-5">No student results available.</td></tr> @endforelse
        </tbody></table></div></div></div></div>
    @elseif ($page === 'user-management')
        <div class="col-12"><div class="card admin-card"><div class="card-body"><div class="d-flex justify-content-between"><h4 class="card-title">Users and Roles</h4><button data-url="{{ route('create.user') }}" id="btn-open-create" data-modal-title="Add Teacher" class="btn btn-gradient-primary">Add Teacher</button></div><div class="table-responsive"><table class="table module-table"><thead><tr><th>User</th><th>Email</th><th>Role</th><th></th></tr></thead><tbody>
        @foreach ($teachers as $teacher)<tr><td>{{ $teacher->fullName() }}</td><td>{{ $teacher->email }}</td><td>{{ $teacher->getRoleNames()->join(', ') ?: 'User' }}</td><td><button data-url="{{ route('edit.user', $teacher->id) }}" id="btn-open-create" data-modal-title="Edit Teacher" class="btn btn-sm btn-outline-primary">Edit</button></td></tr>@endforeach
        </tbody></table></div></div></div></div>
    @elseif ($page === 'settings')
        <div class="col-12 settings-page">
            <form id="admin-settings-form">
                <section class="settings-card"><h4>School Information</h4><div class="settings-grid">
                    <label><span>School Name</span><input name="school_name" value="{{ config('app.name') }}"></label>
                    <label><span>Contact Email</span><input type="email" name="contact_email" value="{{ auth()->user()->email }}"></label>
                    <label><span>Phone Number</span><input name="phone" placeholder="+1 (555) 234-5678"></label>
                    <label><span>Timezone</span><select name="timezone"><option value="Asia/Phnom_Penh">Asia/Phnom Penh</option><option value="UTC">UTC</option><option value="America/Chicago">America/Chicago</option></select></label>
                    <label class="settings-span-2"><span>Address</span><input name="address" placeholder="School address"></label>
                </div></section>
                <section class="settings-card"><h4>Notification Preferences</h4>
                    @foreach ([['email_notifications', 'Email Notifications', 'Receive alerts and reports via email', true], ['sms_notifications', 'SMS Notifications', 'Get text messages for critical alerts', false], ['push_notifications', 'Push Notifications', 'Browser push notifications for real-time updates', true]] as [$name, $label, $help, $checked])
                        <label class="settings-toggle-row"><span><strong>{{ $label }}</strong><small>{{ $help }}</small></span><input type="checkbox" name="{{ $name }}" {{ $checked ? 'checked' : '' }}><i></i></label>
                    @endforeach
                </section>
                <section class="settings-card"><h4>Academic Year</h4><div class="settings-grid">
                    <label><span>Year Start</span><input type="date" name="year_start" value="{{ now()->startOfYear()->format('Y-m-d') }}"></label>
                    <label><span>Year End</span><input type="date" name="year_end" value="{{ now()->endOfYear()->format('Y-m-d') }}"></label>
                </div></section>
                <section class="settings-card settings-danger"><h4>Danger Zone</h4><p>These actions are disabled until secure recovery and confirmation flows are implemented.</p><div><button type="button" disabled>Reset All Data</button><button type="button" disabled>Delete School Account</button></div></section>
                <div class="settings-actions"><button class="btn student-add-button">Save Changes</button></div>
            </form>
        </div>
    @else
        <div class="col-lg-8"><div class="card admin-card"><div class="card-body"><h4 class="card-title">My Profile</h4><div class="d-flex align-items-center mt-4">@if(auth()->user()->profile)<img class="rounded-circle me-4" width="90" height="90" src="{{ asset('assets/images/teacher/' . auth()->user()->profile) }}" alt="">@else<span class="profile-initials profile-initials-large me-4">{{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}</span>@endif<div><h3>{{ auth()->user()->fullName() }}</h3><p class="text-muted mb-2">{{ auth()->user()->email }}</p><button data-url="{{ route('edit.user', auth()->id()) }}" id="btn-open-create" data-modal-title="Edit Profile" class="btn btn-gradient-primary">Edit Profile</button></div></div></div></div></div>
    @endif
@endsection
