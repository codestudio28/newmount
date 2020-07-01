<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
     public function clients(){
    	return $this->hasMany('App\Clients');
    }
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
