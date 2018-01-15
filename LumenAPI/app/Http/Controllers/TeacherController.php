<?php

namespace App\Http\Controllers;

use App\Teacher;

use Illuminate\Http\Request;

class TeacherController extends Controller
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
        $teachers = Teacher::all();
        return $this->createSuccessResponse($teachers, 200);
    }

    public function show($id){
        $teacher = Teacher::find($id);
        if($teacher){
            return $this->createSuccessResponse($teacher, 200);
        }

        return $this->createErrorResponse("The teacher with id {$id}, does not exists", 404);
    }   

    public function store(Request $request){
        
        $this->validateRequest($request);

        $teacher = Teacher::create($request->all());
        return $this->createSuccessResponse("The teacher with id {$teacher->id} has been created", 201);
    }

    public function update(Request $request, $teacher_id){

        // obtain the teacher
        $teacher = Teacher::find($teacher_id);

        // verify the teacher exists
        if ($teacher) {

            // validate the request
            $this->validateRequest($request);

            $teacher->name = $request->get('name');
            $teacher->phone = $request->get('phone');
            $teacher->address = $request->get('address');
            $teacher->profession = $request->get('profession');

            $teacher->save();

            return $this->createSuccessResponse("The teacher with id {$teacher->id} has been updated", 201);
        }

        // return error if teacher does not exist
        return $this->createErrorResponse("The teacher with the specified id does not exists.", 404);
    }

    public function destroy($teacher_id){

        $teacher = Teacher::find($teacher_id);

        if ($teacher) {

            // get and check if the teacher has any courses
            $courses = $teacher->courses;
            if (sizeof($courses) > 0 ) {
                return $this->createErrorResponse("You can't remove a teacher with active courses. Please remove those courses first", 409);
            }


            $teacher->delete();

            return $this->createSuccessResponse("The teacher with id {$teacher->id} has been deleted", 201);
        }

        // return error if teacher does not exist
        return $this->createErrorResponse("The teacher with the specified id does not exists.", 404);
    }

    function validateRequest($request){
        $rules = [
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'profession' => 'required|in:engineering,math,physics'
        ];

        $this->validate($request, $rules);
    }


}
