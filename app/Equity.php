<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equity extends Model
{
     public function client(){
    	return $this->belongsTo('App\Client');
    }
    public function property(){
    	return $this->belongsTo('App\Property');
    }
    public function waivemisc(){
    	return $this->hasMany('App\WaiveEquity','collect_id');
    }
}
