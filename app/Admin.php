<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
      public function voucher(){
    	return $this->hasMany('App\Voucher');
    } 
     public function logs(){
    	return $this->hasMany('App\Log');
    } 
}
