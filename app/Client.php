<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
     public function buy(){
    	return $this->hasMany('App\Buy');
    }
}
