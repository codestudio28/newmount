<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
     public function buy(){
    	return $this->hasMany('App\Buy');
    }
     public function misc(){
    	return $this->hasMany('App\Misc');
    }
    public function equity(){
    	return $this->hasMany('App\Equity');
    }
    public function inhouse(){
    	return $this->hasMany('App\Inhouse');
    }
    public function transfer(){
        return $this->hasMany('App\Inhouse');
    }
    public function transfered(){
        return $this->hasMany('App\Transfer');
    }
}
