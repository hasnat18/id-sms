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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_id')->constrained();
            $table->foreignId('__session_id')->constrained();
            $table->foreignId('student_id')->constrained();
            $table->integer('user_id')->default(0);
            $table->string('month_of')->nullable();
            $table->date('due_date');
            $table->date('paid_at')->nullable();
            $table->date('issued_at')->nullable();
            $table->decimal('arrears')->default(0);
            $table->decimal('total')->default(0);
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('fees');
    }
};
