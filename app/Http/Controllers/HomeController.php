<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RenderedModel;
use App\Customer;
use App\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $customer =  DB::table('customers')->where('user_id', $user_id)->first();
        $user = auth()->user();
        return $customer;
      //  return view('home', ['customer' => $customer]);
    }

    /**

    */
    public function select() {


       $user_id = Auth()->user()->id;
       $customer =  DB::table('customers')->where('user_id', $user_id)->first();

        if (!$customer){
          $customer = new Customer();
          $customer->user_id = $user_id;
          $customer->save();
        }

      $role = auth()->user()->role;
      $renderedModels = RenderedModel::all();

      return view('select', compact(['renderedModels']));


        // TODO configure other roles and views

    }
}
