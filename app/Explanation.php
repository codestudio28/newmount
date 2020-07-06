<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Explanation extends Model
{
   public function voucher(){
    	return $this->belongsTo('App\Voucher');
    }
}
