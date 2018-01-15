<?php

namespace App\Http\Controllers;

use App\Course;

class CourseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(){
        $courses = Course::all();
        return $this->createSuccessResponse($courses, 200);
    }

    public function show($id){
        return __METHOD__;
    }   

}
