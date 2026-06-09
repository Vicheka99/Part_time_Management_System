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
            $page = max(1, (int) $request->input('page', 1));
            $total = ($page - 1) * 5;

            $query = User::query();

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where(User::FIRST_NAME, 'like', '%' . $search . '%')
                        ->orWhere(User::LAST_NAME, 'like', '%' . $search . '%')
                        ->orWhere(User::EMAIL, 'like', '%' . $search . '%');
                });
            }

            $total_pages = ceil($query->count(User::ID) / 5);

            $teachers = $query
                ->offset($total)
                ->limit(5)
                ->get();
            return view('teacher.index', compact('teachers', 'total_pages'));
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
            return back()->with("Error", $message);
        }

        // dd($validate->fails(), $validate->errors());
        $user = User::create([
            User::FIRST_NAME => $request->first_name,
            User::LAST_NAME  => $request->last_name,
            User::GENDER     => $request->gender,
            User::PROFILE    => $request->profile_name,
            User::EMAIL      => $request->email,
            User::PASSWORD   => $request->password,
            User::CREATED_BY => 1,
        ]);

        $user->assignRole('employee');
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
            return back()->with("Error", $message);
        }

        $user = User::find($id);
        if ($user) {
            $user = User::where('id', $user->id)->update([
                User::FIRST_NAME => $request->first_name,
                User::LAST_NAME  => $request->last_name,
                User::GENDER     => $request->gender,
                User::PROFILE    => $request->profile_name,
                User::EMAIL      => $request->email,
            ]);
        }

        return back()->with('Success', 'Teacher Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $user = User::find($request->id);
        if ($user) {
            User::where('id', $request->id)->delete();
            $search = $request->search;
            $page = $request->page;
            $total = ($page - 1) * 5;
            if ($search) {
                $teachers = User::where(User::FIRST_NAME, 'like', '%' . $search . '%')
                    ->orWhere(User::LAST_NAME, 'like', '%' . $search . '%')
                    ->offset($total)
                    ->limit(5)
                    ->get();
                $total_pages = User::where(User::FIRST_NAME, 'like', '%' . $search . '%')
                    ->orWhere(User::LAST_NAME, 'like', '%' . $search . '%')
                    ->count(User::ID);

                $total_pages = ceil($total_pages /  5);
            } else {
                $teachers = User::offset($total)->limit(5)->get();
                $total_pages = ceil(User::count(User::ID) / 5);
            }

            return response()->json(["message" => "Teacher Remove Successfully", "status" => 200, 'data' => $teachers, 'total_page'=>$total_pages]);
        } else {
            return response()->json(["message" => "Teacher Not Found", "status" => 404]);
        }

        return response()->json('remove', 'teacher remove successfully');
    }
}
