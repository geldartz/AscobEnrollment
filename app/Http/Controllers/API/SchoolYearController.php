<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolYear;
use App\Models\Semester;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sy = SchoolYear::latest()->paginate(5);
        $response = [
            'pagination' => [
                'total' => $sy->total(),
                'per_page' => $sy->perPage(),
                'current_page' => $sy->currentPage(),
                'last_page' => $sy->lastPage(),
                'from' => $sy->firstItem(),
                'to' => $sy->lastItem()
            ],
            'data' => $sy
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
        $this->validate($request,[
                'school_year' => 'required',
                'semester' => 'required',
        ]);
        
        $val_sy = SchoolYear::where('status','1')->get();
        $val_sem = Semester::where('status','1')->get();
        if($val_sy->isEmpty() && $val_sem->isEmpty()){

            $sy = SchoolYear::findOrFail($request->get('school_year'));
            $sy->status = '1';
            $sy->update();

            $sem = Semester::findOrFail($request->get('semester'));
            $sem->status = '1';
            $sem->update();
        }else{
            $set_sy_default = SchoolYear::where('status','1')->update(['status'=> '0']);
            $set_sem_default = Semester::where('status','1')->update(['status'=> '0']);

            if($set_sy_default && $set_sem_default){
                $sy = SchoolYear::findOrFail($request->get('school_year'));
                $sy->status = '1';
                $sy->update();
    
                $sem = Semester::findOrFail($request->get('semester'));
                $sem->status = '1';
                $sem->update();
            }
    
        }

      
    }

    public function getSchoolYears(){
        $data = SchoolYear::all();
        return response()->json($data);
    }

    public function getCurrentSchoolYear(){
        $data = SchoolYear::where('status','1')->get();
        return response()->json($data);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
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
        dd($request->all());
    //     $sy = SchoolYear::findOrFail($id);
    //     $this->validate($request,[
    //         'school_year' => 'required|string|max:191|unique:school_years,school_year,'.$sy->id,
    //     ]);
    //    $sy->update($request->all());
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
