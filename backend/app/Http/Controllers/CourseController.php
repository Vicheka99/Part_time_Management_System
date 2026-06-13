<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Constants\PermissionConstant;
use PHPUnit\Framework\Constraint\Count;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd(Auth::user()->getRoleNames()->toArray()); // get role as array
        if (!Auth::user()->can(PermissionConstant::VIEW_COURSE)) {
            return back()->with('Error', 'Permission Denied');
        }
        $query = Course::query()->with('user')->withCount('students');

        if ($search = $request->string('search')->trim()->toString()) {
            $query->where(function ($query) use ($search) {
                $query->where(Course::TITLE, 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($user) use ($search) {
                        $user->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%');
                    });
            });
        }

        $courses = $query->orderByDesc(Course::ID)->paginate(6)->withQueryString();

        return view('course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->can(PermissionConstant::CREATE_COURSE)) {
            return back()->with('Error', 'Permission Denied');
        }
        $teachers = User::get(['id', 'first_name', 'last_name', 'gender'])->all();
        return view('course.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'price' => 'required',
            'start_date' => 'required',
            'teacher_id' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->messages();
            $messsage = implode(", ", $errors->all());
            if ($request->expectsJson()) {
                return response()->json(['message' => $messsage, 'errors' => $errors], 422);
            }
            return back()->with("Error", $messsage);
        }

        Course::create([
            Course::TITLE => $request->title,
            Course::PRICE => $request->price,
            Course::START_DATE => $request->start_date,
            Course::END_DATE => $request->end_date,
            Course::USER_ID => $request->teacher_id,
            Course::DESCRIPTION => '',
        ]);
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Class created successfully.', 'redirect' => route('index.course')]);
        }

        return back()->with('Success', 'Class created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!Auth::user()->can(PermissionConstant::EDIT_COURSE)) {
            return back()->with('Error', 'Permission Denied');
        }
        $teachers = User::get(['id', 'first_name', 'last_name', 'gender'])->all();
        $course = Course::find($id);
        return view('course.update', compact('teachers', 'course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!Auth::user()->can(PermissionConstant::EDIT_COURSE)) {
            return back()->with('Error', 'Permission Denied');
        }
        $course = Course::find($id);
        if ($course) {
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'price' => 'required',
                'start_date' => 'required',
                'teacher_id' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->messages();
                $messsage = implode(", ", $errors->all());
                if ($request->expectsJson()) {
                    return response()->json(['message' => $messsage, 'errors' => $errors], 422);
                }
                return back()->with("Error", $messsage);
            }

            Course::where(Course::ID, $id)->update([
                Course::TITLE => $request->title,
                Course::PRICE => $request->price,
                Course::START_DATE => $request->start_date,
                Course::END_DATE => $request->end_date,
                Course::USER_ID => $request->teacher_id,
            ]);
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Class updated successfully.', 'redirect' => route('index.course')]);
            }

            return redirect()->route('index.course')->with('Success', 'Class updated successfully.');
        } else {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Class not found.'], 404);
            }
            return redirect()->route('index.course')->with('Error', 'Class not found.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->can(PermissionConstant::REMOVE_COURSE)) {
            return response()->json(['message' => 'Permission denied.'], 403);
        }

        $course = Course::find($request->remove_id);
        if ($course) {
            if ($course->students()->exists()) {
                return response()->json([
                    'message' => 'Reassign or delete the students in this class before deleting it.',
                ], 422);
            }

            $course->delete();

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Class deleted successfully.']);
            }

            return redirect()->back()->with('Success', 'Class deleted successfully.');
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Class not found.'], 404);
        }

        return redirect()->back()->with('Error', 'Class not found.');
    }
}
