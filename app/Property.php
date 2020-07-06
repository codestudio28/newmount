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
     public function misc(){
    	return $this->hasMany('App\Misc');
    }
    public function equity(){
    	return $this->hasMany('App\Equity');
    }
}
