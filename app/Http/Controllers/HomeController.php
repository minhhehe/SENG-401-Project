<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RenderedModel;


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
        $user = auth()->user();
        return view('home'), compact(['user']);
    }

    /**

    */
    public function select() {

      $role = auth()->user()->role;
      $renderedModels = RenderedModel::all();
      if($role == 'customer'){

        //TODO rename select view to homeCustomer
        return view('select', compact(['renderedModels']));
      }
      elseif ($role == 'salesperson') {

        // TODO configure other roles and views
      }
    }
}
