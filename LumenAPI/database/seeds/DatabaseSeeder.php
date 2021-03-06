<?php

use Illuminate\Database\Seeder;

use App\Teacher;
use App\Student;
use App\Course;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS=0');

    	// check if data exist and drop if so
    	Teacher::truncate();
    	Student::truncate();
    	Course::truncate();
    	DB::table('course_student')->truncate();

    	// create data
    	factory(Teacher::class, 50)->create();
    	factory(Student::class, 500)->create();
    	factory(Course::class, 40)->create()->each(function($course){
    		$course->students()->attach(array_rand(range(1,500), 40));
    	});
        // $this->call('UsersTableSeeder');
    }
}
