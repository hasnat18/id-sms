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
        Schema::create('student_attendences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_id')->constrained();
            $table->foreignId('__class_id')->constrained();
            $table->foreignId('__session_id')->constrained();
            $table->foreignId('student_id')->constrained();
            $table->string('attendence');
            $table->string('added_at');
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
        Schema::dropIfExists('student_attendences');
    }
};
