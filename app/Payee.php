<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payee extends Model
{
     public function voucher(){
    	return $this->hasMany('App\Voucher');
    } 
}
