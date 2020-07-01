<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    public function proptype(){
    	return $this->belongsTo('App\PropertyType');
    }
    public function buy(){
    	return $this->hasMany('App\Buy');
    }
}
