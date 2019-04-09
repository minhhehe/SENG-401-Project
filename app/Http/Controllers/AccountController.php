<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RenderedModel;
use App\Customer;
use App\User;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
     {
         $this->middleware('auth');
     }
    public function index()
    {
      $user_id = Auth()->user()->id;
      $customer =  DB::table('customers')->where('user_id', $user_id)->first();
      $user = auth()->user();
      return view('home', ['customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {

      $data = request()->all([
          'address',
          'day_phone_number',
          'email',
      ]);

      Auth()->user()->update($data);
      $user_id = Auth()->user()->id;
      $customer =  Customer::where('user_id', $user_id)->first();

      $customer->billingInfo = request('billingInfo');
      $customer->lastVehiclePurchased = request('lastVehiclePurchased');
      $customer->lastVehicleYear = request('lastVehicleYear');
      $customer->lastExterior = request('lastExterior');
      $customer->desiredModel = request('desiredModel');
      $customer->desiredExterior = request('desiredExterior');
      $customer->desiredPrice = request('desiredPrice');


      $customer->save();

      return redirect('/home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
