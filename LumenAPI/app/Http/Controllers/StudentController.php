<?php

namespace App\Http\Controllers;

use App\Student;

use Illuminate\Http\Request;

class StudentController extends Controller
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
        $students = Student::all();
        return $this->createSuccessResponse($students, 200);
    }

    public function show($id){
        $student = Student::find($id);
        if($student){
            return $this->createSuccessResponse($student, 200);
        }

        return $this->createErrorResponse("The student with id {$id}, does not exists", 404);
    }   

    public function store(Request $request){

        $this->validateRequest($request);

        $student = Student::create($request->all());
        return $this->createSuccessResponse("The student with id {$student->id} has been created", 201);
    }

    public function update(Request $request, $student_id){

        // obtain the student
        $student = Student::find($student_id);

        // verify the student exists
        if ($student) {

            // validate the request
            $this->validateRequest($request);

            $student->name = $request->get('name');
            $student->phone = $request->get('phone');
            $student->address = $request->get('address');
            $student->career = $request->get('career');

            $student->save();

            return $this->createSuccessResponse("The student with id {$student->id} has been updated", 201);
        }

        // return error if student does not exist
        return $this->createErrorResponse("The student with the specified id does not exists.", 404);
    }

    public function destroy($student_id){

        $student = Student::find($student_id);

        if ($student) {
            $student->courses()->detach();
            $student->delete();

            return $this->createSuccessResponse("The student with id {$student->id} has been deleted", 201);
        }

        // return error if student does not exist
        return $this->createErrorResponse("The student with the specified id does not exists.", 404);
    }


    function validateRequest($request){
        $rules = [
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'career' => 'required|in:engineering,math,physics'
        ];

        $this->validate($request, $rules);
    }

}
