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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            
            // Student details
            $table->string('gr_no')->unique();
            $table->string('student_name')->nullable(false);
            $table->string('student_email')->nullable();
            $table->string('student_gender')->nullable(false);
            $table->string('student_phone')->nullable();
            $table->string('student_dob')->nullable(false);
            $table->string('student_address')->nullable(false);
            $table->string('student_nationality')->nullable(false);
            $table->string('student_religion')->nullable(false);
            $table->string('student_last_school_attend')->nullable();
            $table->string('student_admission_date')->nullable();
            $table->string('student_state')->nullable(false);
            $table->string('student_city')->nullable(false);
            $table->string('student_country')->nullable(false);
            $table->string('student_pic')->nullable(false);
            
            // Father details
            $table->string('father_name')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('father_office_address')->nullable();
            $table->string('father_contact')->nullable();
            
            // Mother details
            $table->string('mother_name')->nullable();
            $table->string('mother_contact')->nullable();
            
            // Guardian details
            $table->string('guardian_name')->nullable();
            $table->string('guardian_occupation')->nullable();
            $table->string('guardian_office_address')->nullable();
            $table->string('guardian_contact')->nullable();
            
            // Other details
            $table->integer('transport_id')->nullable()->default(0);
            $table->foreignId('__class_id')->constrained('__classes');
            $table->foreignId('__session_id')->constrained('__sessions');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('student_auth_id')->nullable();
            $table->string('status')->default('pending');
            
            $table->string('extra_note')->nullable();
            
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
        Schema::dropIfExists('admissions');
    }
};