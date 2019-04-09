<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $fillable = [

      'user_id',
      'billingInfo', 'lastVehiclePurchased',
      'lastVehicleYear', 'lastInterior', 'lastExterior',
      'lastRim', 'lastGlass', 'desiredModel', 'desiredInterior',
      'desiredExterior', 'desiredRim', 'desiredGlass',
      'desiredPrice', 'paymentMethod'

  ];


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
