<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Schedule::with('subject')->paginate(10);
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
           
            $val = Schedule::where('school_year_id',$request->get('school_year_id'))->where('semester_id',$request->get('semester_id'))
            ->where('course_id',$request->get('course_id'))->where('year_level',$request->get('year_level'))->where('subject_id',$item['name'])->first();

           if(!$val){
                $stud = Schedule::create([
                    'school_year_id'=>$request->get('school_year_id'),
                    'semester_id'=>$request->get('semester_id'),
                    'course_id'=>$request->get('course_id'),
                    'year_level'=>$request->get('year_level'),

                    'subject_id'=>$item['name'],
                    'days'=>$item['days'],
                    'room'=>$item['room'],
                    'time'=>$item['time'],
                ]);
             
           }
            
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
