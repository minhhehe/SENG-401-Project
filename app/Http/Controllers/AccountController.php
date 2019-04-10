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
    public function update(Request $request)
    {

      $data = request()->all([
          'dob',
          'gender',
      ]);

      Auth()->user()->update($data);



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
