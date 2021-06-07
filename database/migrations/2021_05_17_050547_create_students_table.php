<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->string('first_name',100);
            $table->string('middle_name',100);
            $table->string('last_name',100);
            $table->string('status',100);
            $table->string('gender',20);
            $table->string('contact',100);
            $table->string('citizenship',50)->nullable();
            $table->string('religion',50)->nullable();
            $table->string('birthday',50);
            $table->string('address')->nullable();
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
        Schema::dropIfExists('students');
    }
}
