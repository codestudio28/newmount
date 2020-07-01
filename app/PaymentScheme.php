<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentScheme extends Model
{
     public function buy(){
    	return $this->hasMany('App\Buy');
    }
}
