<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStolenCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stolen_cars', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('registration_number')->index();
            $table->string('color')->index();
            $table->string('vin', 17)->index();
            $table->unsignedSmallInteger('year')->index();
            $table->foreignId('make_id')->constrained('makes');
            $table->foreignId('model_id')->constrained('models');
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
        Schema::dropIfExists('stolen_cars');
    }
}
