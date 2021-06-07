<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerSemValidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('per_sem_validates', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->string('school_year_id');
            $table->string('semester_id');
            $table->integer('course_id');
            $table->integer('year_level');
            $table->integer('type_student');
            $table->integer('errolled')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('per_sem_validates');
    }
}
