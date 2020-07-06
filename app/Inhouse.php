<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inhouse extends Model
{
    public function property(){
    	return $this->belongsTo('App\Property');
    }
    public function client(){
    	return $this->belongsTo('App\Client');
    }
     public function paymentscheme(){
    	return $this->belongsTo('App\PaymentScheme');
    }
}
