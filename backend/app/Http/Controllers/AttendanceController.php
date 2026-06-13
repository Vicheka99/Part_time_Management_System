<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'attendance_date' => ['required', 'date'],
            'attendance' => ['required', 'array'],
            'attendance.*' => ['required', 'in:present,absent,late,excused'],
        ]);

        foreach ($validated['attendance'] as $studentId => $status) {
            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'attendance_date' => $validated['attendance_date']],
                [
                    'course_id' => $request->input("course.$studentId"),
                    'status' => $status,
                    'marked_by' => auth()->id(),
                ]
            );
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Attendance saved successfully.']);
        }

        return back()->with('Success', 'Attendance saved successfully.');
    }
}
