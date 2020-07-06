<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Misc extends Model
{
     public function client(){
    	return $this->belongsTo('App\Client');
    }
    public function property(){
    	return $this->belongsTo('App\Property');
    }
}
