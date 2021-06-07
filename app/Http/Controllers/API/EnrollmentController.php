<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Parents;
use App\Models\EducationalBackground;
use App\Models\PerSemValidate;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Student::latest()->paginate(5);
        $response = [
            'pagination' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem()
            ],
            'data' => $data
        ];
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $user = new User;
        $user->name = $request->get('first_name').' '.$request->get('last_name');
        $user->email = $request->get('email');
        $user->type = 'user';
        $user->password = Hash::make('ascob');
        $user->save();

        $student_id = $user->id;

        $student = new Student;
        $student->student_id = $student_id;
        $student->first_name = $request->get('first_name');
        $student->last_name = $request->get('last_name');
        $student->middle_name = $request->get('middle_name');
        $student->status = $request->get('status');
        $student->gender = $request->get('gender');
        $student->contact = $request->get('contact');
        $student->citizenship = $request->get('citizenship');
        $student->religion = $request->get('religion');
        $student->birthday = $request->get('birthday');
        $student->address = $request->get('address');
        $student->save();

        $father = new Parents;
        $father->student_id = $student_id;
        $father->type = $request->get('father_type');
        $father->name = $request->get('father_name');
        $father->status = $request->get('father_status');
        $father->contact = $request->get('father_contact');
        $father->occupation = $request->get('father_occupation');
        $father->company = $request->get('father_company');
        $father->company_address = $request->get('father_company_address');
        $father->company_tel = $request->get('father_tel');
        $father->email = $request->get('father_email');
        $father->save();

        $mother = new Parents;
        $mother->student_id = $student_id;
        $mother->type = $request->get('mother_type');
        $mother->name = $request->get('mother_name');
        $mother->status = $request->get('mother_status');
        $mother->contact = $request->get('mother_contact');
        $mother->occupation = $request->get('mother_occupation');
        $mother->company = $request->get('mother_company');
        $mother->company_address = $request->get('mother_company_address');
        $mother->company_tel = $request->get('mother_tel');
        $mother->email = $request->get('mother_email');
        $mother->save();

        $guardian = new Parents;
        $guardian->student_id = $student_id;
        $guardian->type = $request->get('guardian_type');
        $guardian->name = $request->get('guardian_name');
        $guardian->status = $request->get('guardian_relationship');
        $guardian->contact = $request->get('guardian_contact');
        $guardian->occupation = $request->get('guardian_occupation');
        $guardian->company = $request->get('guardian_company');
        $guardian->company_address = $request->get('guardian_company_address');
        $guardian->company_tel = $request->get('guardian_tel');
        $guardian->email = $request->get('guardian_email');
        $guardian->save();

        $val = new PerSemValidate;
        $val->student_id = $student_id;
        $val->school_year_id = $request->get('school_year_id');
        $val->semester_id = $request->get('semester_id');
        $val->course_id = $request->get('course_id');
        $val->year_level = $request->get('year_level');
        $val->type_student = $request->get('type_student');
        $val->save();

        foreach ($request->get('schoolsAttended') as $item) {
            $stud = EducationalBackground::create([
                'student_id' => $student_id,
                'school_name'=>$item['school_name'],
                'school_address'=>$item['school_address'],
                'school_year'=>$item['school_year'],
                'level'=>$item['level'],
            ]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
