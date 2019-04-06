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
            $table->bigIncrements('id'); //20digits
            $table->string('fname'); //name
            $table->string('lname'); //name
            $table->date('dob');//DOB
            $table->string('gender');//Gender
            $table->string('address');//Address
            $table->string('phoneNum')//Phone Number
            $table->string('email')->unique();;//Email
            $table->string('billingInfo')//Billing info
            $table->string('lastVehiclePurchased')//Last vehicle purchaced
            $table->date('lastVehicleYear');//Last Vehicle year
            $table->string('lastInterior')//Last vehicle interior Colour
            $table->string('lastExterior')//Last vehicle exterior Colour
            $table->string('lastRim')//Last vehicle rim Colour
            $table->string('lastGlass')//Last vehicle glass Colour
            $table->string('desiredModel')//Desired model
            $table->string('desiredInterior')//desired interior colour
            $table->string('desiredExterior')//desired exterior colour
            $table->string('desiredRim')//Desired Rim colour
            $table->string('desiredGlass')//Desired Glass Colour
            $table->string('desiredPrice')//Desired Price Range
            $table->string('paymentMethod')//Desired Payment Method
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
        Schema::dropIfExists('customers');
    }
}
