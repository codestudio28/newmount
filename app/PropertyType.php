<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    public function property(){
    	return $this->hasMany('App\Property');
    } 
     public function listings(){
    	return $this->hasMany('App\Listings');
    }
}
