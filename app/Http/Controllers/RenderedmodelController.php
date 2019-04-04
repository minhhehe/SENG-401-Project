<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RenderedModel;
use App\Body;
use App\Interior;

class RenderedModelController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function index()
  {
      //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      // Unused - Richard
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      // Unused - Richard
  }

  /**
   * Display the specified resource.
   *
   * @param string $filename
   * @return \Illuminate\Http\Response
   */

   // * @param  int  $id // FIXME restore to this in docs
  public function show($id)
  {
      $renderedModel = RenderedModel::find($id);
      $bodies = $renderedModel->bodies()->get();
      $interiors = $renderedModel->interiors()->get();
      return view('render_model', compact([
        'renderedModel', 'bodies', 'interiors'
      ]));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      // Unused
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
      // Unused
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      // Unused
  }
}
