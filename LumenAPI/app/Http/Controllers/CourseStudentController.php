<?php

namespace App\Http\Controllers;

use App\Course;
use App\Student;

class CourseStudentController extends Controller
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

    public function index($course_id){

        $course = Course::find($course_id);

        if($course){
            $students = $course->students;

            return $this->createSuccessResponse($students, 200);
        }

        return $this->createErrorResponse('We couldn\'t find a course with the given id.',404);
    }

    public function store($course_id, $student_id){

        $course = Course::find($course_id);

        // check if course exists
        if ($course) {
            $student = Student::find($student_id);

            // check if student exists
            if ($student) {

                // check if student already is IN this course
                if ($course->students()->find($student->id)) {
                    return $this->createErrorResponse("The student with id {$student->id} already exists in the course with id {$course->id}", 409);
                }
                // add student to the students list for this course
                $course->students()->attach($student->id);

                return $this->createSuccessResponse("The student with id {$student_id}, was added to the course with id {$course_id}",200);
            }//End if student

            return $this->createErrorResponse("The student with id {$student_id}, does not exist.", 404);

        }//End if course

        return $this->createErrorResponse("The course with id {$course_id}, does not exist.", 404);
    }

    public function destroy($course_id, $student_id){

        $course = Course::find($course_id);

        // check if course exists
        if ($course) {
            $student = Student::find($student_id);

            // check if student exists
            if ($student) {

                // check if student does not exist IN this course
                if (!$course->students()->find($student->id)) {
                    return $this->createErrorResponse("The student with id {$student->id} does not exist in the course with id {$course->id}", 404);
                }
                // remove student from the students list for this course
                $course->students()->detach($student->id);

                return $this->createSuccessResponse("The student with id {$student_id}, was removed from the course with id {$course_id}",200);
            }//End if student

            return $this->createErrorResponse("The student with id {$student_id}, does not exist.", 404);

        }//End if course

        return $this->createErrorResponse("The course with id {$course_id}, does not exist.", 404);
    }    

}
