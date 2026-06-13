<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPageController extends Controller
{
    private const TITLES = [
        'student-add' => ['Add Student', 'Students', 'mdi-account-plus'],
        'student-attendance' => ['Student Attendance History', 'Students', 'mdi-history'],
        'teacher-classes' => ['Assign Classes', 'Teachers', 'mdi-account-switch'],
        'class-schedule' => ['Class Schedule', 'Classes', 'mdi-calendar-clock'],
        'class-students' => ['Assign Students', 'Classes', 'mdi-account-multiple-plus'],
        'attendance-take' => ['Take Attendance', 'Attendance', 'mdi-clipboard-check'],
        'attendance-records' => ['Attendance Records', 'Attendance', 'mdi-format-list-checks'],
        'attendance-reports' => ['Attendance Reports', 'Attendance', 'mdi-chart-bar'],
        'subject-list' => ['Subject List', 'Subjects', 'mdi-book-open-variant'],
        'subject-assign' => ['Assign Subjects', 'Subjects', 'mdi-book-plus'],
        'attendance-summary' => ['Attendance Summary', 'Reports', 'mdi-chart-donut'],
        'student-performance' => ['Student Performance', 'Reports', 'mdi-chart-line'],
        'user-management' => ['User Management', 'Settings', 'mdi-account-cog'],
        'settings' => ['Settings', 'Settings', 'mdi-cog'],
        'profile' => ['Profile', 'Settings', 'mdi-account-circle'],
    ];

    public function show(Request $request, string $page): View
    {
        [$title, $group, $icon] = self::TITLES[$page];
        $attendanceDate = $request->date('date')?->format('Y-m-d') ?? now()->format('Y-m-d');
        $courseId = $request->integer('course');
        $students = Student::with([
            'course',
            'attendances' => fn ($query) => $query->whereDate('attendance_date', $attendanceDate),
        ])
            ->when($courseId, fn ($query) => $query->where('course_id', $courseId))
            ->orderBy('first_name')
            ->get();
        $courses = Course::with(['user', 'students'])
            ->when($page === 'subject-list' && $request->filled('search'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->string('search')->trim()->toString() . '%');
            })
            ->orderBy('title')
            ->get();
        $teachers = User::with('courses')->orderBy('first_name')->get();
        $attendances = Attendance::with(['student', 'course'])->latest('attendance_date')->get();
        $dayAttendances = Attendance::whereDate('attendance_date', $attendanceDate)
            ->when($courseId, fn ($query) => $query->where('course_id', $courseId))
            ->get();
        $reportMonths = collect(range(5, 0))->map(fn ($offset) => now()->subMonths($offset)->format('Y-m'));
        $monthlyAttendance = $reportMonths->map(function ($month) use ($attendances) {
            $records = $attendances->filter(fn ($record) => $record->attendance_date->format('Y-m') === $month);
            return [
                'label' => \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M'),
                'present' => $records->where('status', 'present')->count(),
                'missed' => $records->whereIn('status', ['absent', 'late'])->count(),
            ];
        });
        $coursePerformance = $courses->map(function ($course) use ($attendances) {
            $records = $attendances->where('course_id', $course->id);
            return [
                'label' => $course->title,
                'score' => round($course->students->avg(fn ($student) => (float) $student->score) ?? 0, 1),
                'attendance' => $records->count()
                    ? round($records->whereIn('status', ['present', 'late'])->count() / $records->count() * 100, 1)
                    : 0,
            ];
        })->take(6)->values();

        return view('admin.page', compact(
            'page', 'title', 'group', 'icon', 'students', 'courses', 'teachers', 'attendances',
            'attendanceDate', 'courseId', 'dayAttendances', 'monthlyAttendance', 'coursePerformance'
        ));
    }
}
