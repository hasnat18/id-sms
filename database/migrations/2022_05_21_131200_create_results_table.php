<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->integer('admission_id');
            $table->integer('student_id');
            $table->integer('class_id');
            $table->integer('session_id');
            $table->string('exam_type');
            $table->string('total_marks');
            $table->string('obtained_marks');
            $table->string('percentage');
            $table->string('grade');
            $table->string('status');
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
        Schema::dropIfExists('results');
    }
};
