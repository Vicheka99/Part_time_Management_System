<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $search = $request->search;
            $page = $request->page;
            $total = ($page - 1) * 5;
            if ($search) {
                $students = Student::where(Student::FIRST_NAME, 'like', '%' . $search . '%')
                    ->orWhere(Student::LAST_NAME, 'like', '%' . $search . '%')
                    ->offset($total)
                    ->limit(5)
                    ->get();
                $total_pages = Student::where(Student::FIRST_NAME, 'like', '%' . $search . '%')
                    ->orWhere(Student::LAST_NAME, 'like', '%' . $search . '%')
                    ->count(Student::ID);

                $total_pages = ceil($total_pages /  5);
            } else {
                $students = Student::offset($total)->limit(5)->get();
                $total_pages = ceil(Student::count(Student::ID) / 5);
            }
            return view('student.index', compact('students', 'total_pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $courses = Course::get(['id', 'title'])->all();
        return view('student.create', compact('courses'));
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
            "score" => ['required', 'max:3'],
            "status" => ['required'],
            "course_id" => ['required'],
            'email' => ['required', 'email', Rule::unique(User::TABLE_NAME, User::EMAIL)],
            'username' => ['required', 'alpha_dash', 'min:4', 'max:20', Rule::unique(User::TABLE_NAME, User::USERNAME)],

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = implode(", ", $errors->all());
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
            Student::SCORE      => $request->score,
            Student::STATUS     => $request->status,
            Student::COURSE_ID  => $request->course_id,
            Student::USER_ID    => $studentUser->id,
        ]);

        $successMessage = sprintf(
            'Student created. Username: %s | Password: %s',
            $studentUser->username,
            $generatedPassword
        );

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

            return redirect()->route('index.student')->with('Success', 'Student Updated');
        } else {
            return redirect()->route('index.student')->with('Error', 'Student not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $student = Student::find($request->remove_id);
        if ($student) {
            Student::where(Student::ID, $request->remove_id)->delete();
            return redirect()->back()->with('Success', 'Student Deleted');
        } else {
            return redirect()->back()->with('Error', 'Student not found');
        }
    }
}
