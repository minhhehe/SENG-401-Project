<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {

            $table->bigIncrements('customer_id'); //20digit customer_id
            $table->bigInteger('user_id')->unsigned() ;
            $table->foreign('user_id')->references('id')->on('users'); //foreign id to user_table
          //  $table->integer('last_edited_by')->nullable();
          //  $table->foreign('last_edited_by')->references('staff_id')->on('staff');

            //$table->string('fname'); //name
            //$table->string('lname'); //name
            //$table->date('dob');//DOB
            //$table->string('gender');//Gended
            $table->string('billingInfo')->nullable(); //Billing info
            $table->string('lastVehiclePurchased')->nullable();  //Last vehicle purchaced
            $table->date('lastVehicleYear')->nullable(); //Last Vehicle year
            $table->string('lastInterior')->nullable();  //Last vehicle interior Colour
            $table->string('lastExterior')->nullable();  //Last vehicle exterior Colour
            $table->string('lastRim')->nullable();  //Last vehicle rim Colour
            $table->string('lastGlass')->nullable();  //Last vehicle glass Colour
            $table->string('desiredModel')->nullable();  //Desired model
            $table->string('desiredInterior')->nullable();  //desired interior colour
            $table->string('desiredExterior')->nullable();  //desired exterior colour
            $table->string('desiredRim')->nullable();  //Desired Rim colour
            $table->string('desiredGlass')->nullable();  //Desired Glass Colour
            $table->string('desiredPrice')->nullable();  //Desired Price Range
            $table->string('paymentMethod')->nullable();  //Desired Payment Method
            $table->timestamps();
        });
        //20 digit customer id
        DB:statement("ALTER TABLE customers AUTO_INCREMENT
          = 10000000000000000000;");
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
