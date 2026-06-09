<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    public function index()
    {
        $totalTeachers = User::count();
        $totalCourses = Course::count();
        $totalStudents = Student::count();
        $isAdmin = in_array('admin', auth()->user()->getRoleNames()->toArray());

        return view('index', compact('totalTeachers', 'totalCourses', 'totalStudents', 'isAdmin'));
    }

    /**
     * upload file that request from ajax
     * @param $request, request file when submit
     * @return string, file upload
     */
    public function uploadFile(Request $request)
    {
        $vailidated = $request->validate([
            'profile' => 'required|file|image|mimes:png,jpg,png,webp|max:2048',
        ]);

        $profile = $request->file('profile');

        $profileName = date('d-m-y-H-i-s').'-'. $profile->getClientOriginalName();
        $path = 'assets/images/teacher';
        $profile->move($path, $profileName);

        return response()->json($profileName);
    }

    public function migrate() {
        Artisan::call('migrate');

        return back()->with('Success','All the new table create');
    }
}
