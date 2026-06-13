<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Student::query()
            ->with(['course', 'user'])
            ->withCount([
                'attendances',
                'attendances as attended_count' => fn ($query) => $query->whereIn('status', ['present', 'late']),
            ]);

        if ($search = $request->string('search')->trim()->toString()) {
            $query->where(function ($query) use ($search) {
                $query->where(Student::FIRST_NAME, 'like', '%' . $search . '%')
                    ->orWhere(Student::LAST_NAME, 'like', '%' . $search . '%')
                    ->orWhere(Student::ID, 'like', '%' . $search . '%')
                    ->orWhereHas('user', fn ($user) => $user->where('email', 'like', '%' . $search . '%'));
            });
        }

        if ($request->get('filter') === 'active') {
            $query->whereRaw('LOWER(status) = ?', ['active']);
        } elseif ($request->get('filter') === 'at-risk') {
            $query->whereRaw('LOWER(status) IN (?, ?)', ['inactive', 'at risk']);
        }

        $students = $query->orderBy(Student::FIRST_NAME)->paginate(8)->withQueryString();

        return view('student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::get(['id', 'title'])->all();
        $nextStudentId = 'STU-' . str_pad((Student::max(Student::ID) ?? 0) + 1, 4, '0', STR_PAD_LEFT);

        return view('student.create', compact('courses', 'nextStudentId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "first_name" => ['required', 'min:2', 'max:10'],
            "last_name" => ['required', 'min:2', 'max:10'],
            "gender" => ['required', 'min:4', 'max:6'],
            "status" => ['required'],
            "course_id" => ['required'],
            'email' => ['required', 'email', Rule::unique(User::TABLE_NAME, User::EMAIL)],
            'username' => ['required', 'alpha_dash', 'min:4', 'max:20', Rule::unique(User::TABLE_NAME, User::USERNAME)],

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = implode(", ", $errors->all());
            if ($request->expectsJson()) {
                return response()->json(['message' => $message, 'errors' => $errors], 422);
            }
            return back()->with("Error", $message);
        }

        // Generate credentials for the student account: Student12345 for all
        $generatedPassword = 'Student12345';

        $studentUser = User::create([
            User::FIRST_NAME => $request->first_name,
            User::LAST_NAME  => $request->last_name,
            User::GENDER     => $request->gender,
            User::PROFILE    => $request->profile_name ?? '',
            User::EMAIL      => $request->email,
            User::USERNAME   => $request->username,
            User::PASSWORD   => $generatedPassword,
            User::CREATED_BY => Auth::id() ?? 0,
        ]);

        // Ensure the student role exists before assigning it
        $studentRole = Role::firstOrCreate(['name' => 'student']);
        $studentUser->assignRole($studentRole);

        Student::create([
            Student::FIRST_NAME => $request->first_name,
            Student::LAST_NAME  => $request->last_name,
            Student::GENDER     => $request->gender,
            Student::SCORE      => 0,
            Student::STATUS     => $request->status,
            Student::COURSE_ID  => $request->course_id,
            Student::USER_ID    => $studentUser->id,
        ]);

        $successMessage = sprintf(
            'Student created. Username: %s | Password: %s',
            $studentUser->username,
            $generatedPassword
        );

        if ($request->expectsJson()) {
            return response()->json(['message' => $successMessage, 'redirect' => route('index.student')]);
        }

        return back()->with('Success', $successMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $courses = Course::get(['id', 'title'])->all();
        $student = Student::find($id);
        return view('student.update', compact('student','courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);
        if($student) {
            $validator = Validator::make($request->all(), [
            "first_name" => ['required', 'min:2', 'max:10'],
            "last_name" => ['required', 'min:2', 'max:10'],
            "gender" => ['required', 'min:4', 'max:6'],
            "score" => ['required', 'max:3'],
            "status" => ['required'],
            "course_id" => ['required'],
            'email' => ['required', 'email', Rule::unique(User::TABLE_NAME, User::EMAIL)->ignore($student->user_id)],
            'username' => ['required', 'alpha_dash', 'min:4', 'max:20', Rule::unique(User::TABLE_NAME, User::USERNAME)->ignore($student->user_id)],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = implode(", ", $errors->all());
            if ($request->expectsJson()) {
                return response()->json(['message' => $message, 'errors' => $errors], 422);
            }
            return back()->with("Error", $message);
        }

        // Update student record
            Student::where(Student::ID, $id)->update([
                Student::FIRST_NAME => $request->first_name,
                Student::LAST_NAME  => $request->last_name,
                Student::GENDER     => $request->gender,
                Student::SCORE      => $request->score,
                Student::STATUS     => $request->status,
                Student::COURSE_ID  => $request->course_id,
                Student::USER_ID    => $student->user_id,
            ]);

            // Update linked user record
            if ($student->user_id) {
                User::where(User::ID, $student->user_id)->update([
                    User::FIRST_NAME => $request->first_name,
                    User::LAST_NAME  => $request->last_name,
                    User::GENDER     => $request->gender,
                    User::EMAIL      => $request->email,
                    User::USERNAME   => $request->username,
                ]);
            }

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Student updated successfully.', 'redirect' => route('index.student')]);
            }

            return redirect()->route('index.student')->with('Success', 'Student Updated');
        } else {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Student not found.'], 404);
            }
            return redirect()->route('index.student')->with('Error', 'Student not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->can('remove students')) {
            return response()->json(['message' => 'Permission denied.'], 403);
        }

        $student = Student::find($request->remove_id);
        if ($student) {
            DB::transaction(function () use ($student) {
                $user = $student->user;
                $student->delete();
                $user?->delete();
            });

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Student deleted successfully.']);
            }

            return redirect()->back()->with('Success', 'Student deleted successfully.');
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Student not found.'], 404);
        }

        return redirect()->back()->with('Error', 'Student not found.');
    }
}
