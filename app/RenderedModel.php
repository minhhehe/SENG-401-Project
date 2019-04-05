<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RenderedModel extends Model
{
    //
    protected $fillable = ['file_name'];

    public function bodies() {
      return $this->hasMany('App\Body');
    }

    public function interiors() {
      return $this->hasMany('App\Interior');
    }

}
