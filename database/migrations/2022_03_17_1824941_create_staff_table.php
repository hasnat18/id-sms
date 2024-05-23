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
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->string('dob');
            $table->text('address');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('joining_date');
            $table->decimal('salary', 8, 2)->default(0);
            $table->text('extra_note')->nullable();
            $table->boolean('is_bus_incharge')->nullable()->default(0);
            $table->integer('transport_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('added_by');
            $table->string('id_proof')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('staff');
    }
};
