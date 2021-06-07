<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Subject::with('course')->paginate(10);
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
            'school_year_id' => 'required',
            'semester_id' => 'required',
            'course_id' => 'required',
            'year_level' => 'required',
        ]);
      
        foreach ($request->get('subject') as $item) {
            $stud = Subject::create([
                'school_year_id'=>$request->get('school_year_id'),
                'semester_id'=>$request->get('semester_id'),
                'course_id'=>$request->get('course_id'),
                'year_level'=>$request->get('year_level'),

                'short_name'=>$item['short_name'],
                'name'=>$item['name'],
                'units'=>$item['units'],
                'class'=>$item['class'],
            ]);
        }
    }

    public function getSubjects($sy_id,$sem_id,$cour_id,$yl){
        $data = Subject::where('school_year_id',$sy_id)->where('semester_id',$sem_id)->where('course_id',$cour_id)->where('year_level',$yl)->get();
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
        $data = Subject::where('id',$id)->get('units');
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
        $data = Subject::findOrFail($id);

        foreach ($request->get('subject') as $item) {
            $data->short_name = $item['short_name'];
            $data->name = $item['name'];
            $data->units = $item['units'];
            $data->class = $item['class'];
        }
        // $data->update();

        $arr = [];
        if($data->update()){
            $arr = ['msg' => 'added'];
        }else{
            $arr = ['msg' => 'failed'];
        }
        return response()->json($arr);
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
