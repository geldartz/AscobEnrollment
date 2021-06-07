<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerSemValidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'school_year_id',
        'semester_id',
        'course_id',
        'year_level',
        'type_student',
   ];
}
