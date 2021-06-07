<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_year_id',
        'semester'
   ];

   public function schoolyear(){
        return $this->belongsTo(SchoolYear::class,'school_year_id');
    }
}
