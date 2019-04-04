<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInteriorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interiors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rendered_model_id');
            $table->string('interior');
            $table->timestamps();
            $table->foreign('rendered_model_id')->references('id')->on('rendered_models');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interiors');
    }
}
