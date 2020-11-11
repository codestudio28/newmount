<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaiveEquity extends Model
{
    public function equity(){
    	return $this->belongsTo('App\Equity');
    }
}
