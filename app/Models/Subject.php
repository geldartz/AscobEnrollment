<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'short_name',
        'school_year_id',
        'semester_id',
        'course_id',
        'year_level',
        'units',
        'class',
   ];

    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }

}
