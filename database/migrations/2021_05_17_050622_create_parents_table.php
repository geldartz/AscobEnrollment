<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->string('type',100)->nullable();
            $table->string('name',100)->nullable();
            $table->string('status',100)->nullable();
            $table->string('contact',100)->nullable();
            $table->string('occupation',100)->nullable();
            $table->string('company',150)->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_tel',100)->nullable();
            $table->string('email',100)->nullable();
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
        Schema::dropIfExists('parents');
    }
}
