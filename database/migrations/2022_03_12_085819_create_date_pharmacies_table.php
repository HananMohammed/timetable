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
        Schema::create('date_pharmacies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('date_id');
            $table->foreign('date_id')->references('id')->on('dates')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('pharmacy_id');
            $table->foreign('pharmacy_id')->references('id')->on('pharmacies')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->time('time_from');
            $table->time('time_to');
            $table->string('from_slot', 10);
            $table->string('to_slot', 10);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('date_pharmacies');
    }
};
