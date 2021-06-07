<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_year_id',
        'semester_id',
        'course_id',
        'year_level',
        'subject_id',
        'days',
        'room',
        'time',
   ];

   public function subject(){
    return $this->belongsTo(Subject::class,'subject_id');
}


}
