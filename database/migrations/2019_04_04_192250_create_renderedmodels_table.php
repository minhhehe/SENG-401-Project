<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenderedModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rendered_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_name');
            $table->string('picture');
            $table->timestamps();
            // $table->string('description'); // handled in add_description_to_rendered_model
            $table->float('camera_x');
            $table->float('camera_y');
            $table->float('camera_z');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rendered_models');
    }
}
