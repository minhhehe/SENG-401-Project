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
    public function __construct() // FIXME uncomment - Richard
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
        return view('home');
    }

    /**

    */
    public function select() {
      $renderedModels = RenderedModel::all();
      return view('select', compact(['renderedModels']));
    }
}
