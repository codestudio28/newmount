<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaiveMisc extends Model
{
     public function misc(){
    	return $this->belongsTo('App\Misc');
    }
}
