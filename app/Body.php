<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Body extends Model
{
    //
    public function renderedmodel() {
      return $this->belongsTo('App\RenderedModel');
    }

}
