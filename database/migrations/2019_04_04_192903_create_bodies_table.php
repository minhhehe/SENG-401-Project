<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('renderedmodel_id');
            $table->string('body');
            $table->timestamps();
            $table->foreign('renderedmodel_id')->references('id')->on('renderedmodels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bodies');
    }
}
