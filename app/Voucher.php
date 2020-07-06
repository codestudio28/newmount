<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
     public function payee(){
    	return $this->belongsTo('App\Payee');
    }
     public function prepared(){
    	return $this->belongsTo('App\Admin','prepared_admin_id');
    }
     public function noted(){
    	return $this->belongsTo('App\Admin','noted_admin_id');
    }
    public function approved(){
    	return $this->belongsTo('App\Admin','approved_admin_id');
    }
     public function explain(){
    	return $this->hasMany('App\Explanation');
    } 
}
