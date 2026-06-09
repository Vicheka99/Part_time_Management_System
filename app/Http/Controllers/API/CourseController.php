<?php

namespace App\Http\Controllers\API;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    function index(){
        $course = Course::all();
        return $course;
    }
}
