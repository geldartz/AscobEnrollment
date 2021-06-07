<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Course::paginate(5);
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

        $this->validate($request,[
            'name' => 'required|string|max:100|unique:courses',
            'abbr' => 'required|string|max:50',
            'year_levels' => 'required|integer',
            
        ]);
        return Course::create([
            'name' => $request['name'],
            'abbr' => $request['abbr'],
            'year_levels' => $request['year_levels'],
        ]);
    }

    public function getCourses(){
        $data = Course::all();
        return response()->json($data);
    }
    public function getYearLevels($id){
        $data = Course::select('year_levels')->where('id',$id)->first();
        return response()->json($data->year_levels);
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
        $course = Course::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|string|max:100',
            'abbr' => 'required|string|max:50',
            'year_levels' => 'required|integer',
        ]);
        
       $course->update($request->all());
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
