<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'type',
        'name',
        'status',
        'contact',
        'occupation',
        'company',
        'company_address',
        'company_tel',
        'email',
   ];
}
