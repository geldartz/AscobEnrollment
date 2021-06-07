<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sy = Semester::with('schoolyear')->paginate(5);
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
            'school_year_id' => 'required|integer',
            'semester' => 'required|string|max:100',
        ]);

        return Semester::create([
            'school_year_id' => $request['school_year_id'],
            'semester' => $request['semester'],
        ]);
      
    }
    public function getSemester(){
        $data = Semester::all();
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
        $data = Semester::where('school_year_id',$id)->get();
        return response()->json($data);
    }

    public function getCurrentSemester(){
        $data = Semester::where('status','1')->get();
        return response()->json($data);
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
        $sem = Semester::findOrFail($id);
        $this->validate($request,[
            'school_year_id' => 'required|integer',
            'semester' => 'required|string|max:100',
        ]);
        
       $sem->update($request->all());
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
