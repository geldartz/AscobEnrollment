<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('version', function () {
    return response()->json(['version' => config('app.version')]);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    Log::debug('User:' . serialize($request->user()));
    return $request->user();
});


Route::namespace('App\\Http\\Controllers\\API')->group(function () {
    Route::get('getschoolyear', 'SchoolYearController@getSchoolYears');
    Route::get('getcurrentschoolyear', 'SchoolYearController@getCurrentSchoolYear');
    
    Route::get('getsemester', 'SemesterController@getSemester');
    Route::get('getcurrentsemester', 'SemesterController@getCurrentSemester');
    Route::get('getdepartment', 'DepartmentController@getDepartments');
    Route::get('getcourse', 'CourseController@getCourses');
    Route::put('update={id}', 'FeeController@updateData');
    Route::get('getyearlevels/{id}', 'CourseController@getYearLevels');
    Route::get('getsubject/{sy_id}/{sem_id}/{cour_id}/{yl}', 'SubjectController@getSubjects');

    
    Route::apiResources([
        'user' => 'UserController',
        'schoolyear' => 'SchoolYearController',
        'semester' => 'SemesterController',
        'subject' => 'SubjectController',
        'course' => 'CourseController',
        'requirement' => 'RequirementController',
        'schedule' => 'ScheduleController',
        'enrollment' => 'EnrollmentController',

    ]);
});
