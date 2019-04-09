<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $fillable = [
      'fname', 'lname', 'dob',
      'gender', 'address','phoneNum',
      'email', 'billingInfo', 'lastVehiclePurchased',
      'lastVehicleYear', 'lastInterior', 'lastExterior',
      'lastRim', 'lastGlass', 'desiredModel', 'desiredInterior',
      'desiredExterior', 'desiredRim', 'desiredGlass',
      'desiredPrice', 'paymentMethod'

  ];

  public function getName() {
    $name = DB::table('customer')
      ->select('fname', 'lname')
      ->where('id', '=', $this->id)
      ->get();
    return $name;
  }

  public function getLastColours() {
    $colours = DB::table('customer')
      ->select('lastInterior', 'lastExterior', 'lastRim', 'lastGlass' )
      ->where('id', '=', $this->id)
      ->get();
    return $colours;
  }

  public function getDesiredColours() {
    $colours = DB::table('customer')
      ->select('desiredInterior', 'desiredExterior', 'desiredRim', 'desiredGlass' )
      ->where('id', '=', $this->id)
      ->get();
    return $colours;
  }
}
