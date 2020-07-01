<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
   public function scholarships(){
    	return $this->hasMany('App\Scholarship');
    }
}
