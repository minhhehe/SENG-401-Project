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
        //$this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    }

    /**

    */
    public function select() {



        $renderedModels = RenderedModel::all();
        $defaultBackgrounds = [
            'http://localhost:8000/storage/default1.jpg',
            'http://localhost:8000/storage/default2.jpg',
            'http://localhost:8000/storage/default3.jpg',
            'http://localhost:8000/storage/default4.jpg',
            'http://localhost:8000/storage/default5.jpg',
            'http://localhost:8000/storage/default6.jpg',
        ];
        return view('select', compact(['renderedModels', 'defaultBackgrounds']));
    }
}
