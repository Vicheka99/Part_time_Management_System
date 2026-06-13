<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $user = Auth::user();
        if (Auth::user()->hasPermissionTo('view users')) {
            $search = trim((string) $request->search);
            $query = User::query()
                ->whereHas('roles', fn ($role) => $role->where('name', 'employee'))
                ->with('courses')
                ->withCount([
                    'courses',
                    'courses as students_count' => fn ($query) => $query->join('students', 'courses.id', '=', 'students.course_id'),
                ]);

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where(User::FIRST_NAME, 'like', '%' . $search . '%')
                        ->orWhere(User::LAST_NAME, 'like', '%' . $search . '%')
                        ->orWhere(User::EMAIL, 'like', '%' . $search . '%');
                });
            }

            $teachers = $query->orderBy(User::FIRST_NAME)->paginate(6)->withQueryString();

            return view('teacher.index', compact('teachers'));
        } else {
            // about(401);
            return back()->with('Error', 'Permission Denied');
        }
        //     return view('teacher.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->can('create users')) {
            return view('teacher.create');
        } else {
            return back()->with('Error', 'Permission Denied');
        }
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
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            "password" => ['required', 'min:8'],

        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = implode(", ", $errors->all());
            if ($request->expectsJson()) {
                return response()->json(['message' => $message, 'errors' => $errors], 422);
            }
            return back()->with("Error", $message);
        }

        // dd($validate->fails(), $validate->errors());
        $user = User::create([
            User::FIRST_NAME => $request->first_name,
            User::LAST_NAME  => $request->last_name,
            User::GENDER     => $request->gender,
            User::PROFILE    => $request->profile_name ?: null,
            User::EMAIL      => $request->email,
            User::PASSWORD   => $request->password,
            User::CREATED_BY => 1,
        ]);

        $user->assignRole('employee');
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Teacher created successfully.', 'redirect' => route('index.user')]);
        }

        return back()->with('Success', 'Teacher Create Successfully');
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
        $user = User::find($id);

        return view('teacher.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            "first_name" => ['required', 'min:2', 'max:10'],
            "last_name" => ['required', 'min:2', 'max:10'],
            "gender" => ['required', 'min:4', 'max:6'],
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = implode(", ", $errors->all());
            if ($request->expectsJson()) {
                return response()->json(['message' => $message, 'errors' => $errors], 422);
            }
            return back()->with("Error", $message);
        }

        $user = User::find($id);
        if ($user) {
            $user = User::where('id', $user->id)->update([
                User::FIRST_NAME => $request->first_name,
                User::LAST_NAME  => $request->last_name,
                User::GENDER     => $request->gender,
                User::PROFILE    => $request->filled('profile_name') ? $request->profile_name : $user->profile,
                User::EMAIL      => $request->email,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Teacher updated successfully.', 'redirect' => route('index.user')]);
        }

        return back()->with('Success', 'Teacher Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->can('remove users')) {
            return response()->json(['message' => 'Permission denied.'], 403);
        }

        $user = User::find($request->id);
        if ($user) {
            if ($user->id === Auth::id()) {
                return response()->json(['message' => 'You cannot delete your own account.'], 422);
            }

            if ($user->courses()->exists()) {
                return response()->json(['message' => 'Reassign this teacher\'s classes before deleting the account.'], 422);
            }

            $user->delete();

            return response()->json(['message' => 'Teacher deleted successfully.']);
        }

        return response()->json(['message' => 'Teacher not found.'], 404);
    }
}
