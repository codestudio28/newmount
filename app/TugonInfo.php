<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TugonInfo extends Model
{
    

    public function userinfo(){
    	return $this->belongsTo('App\UserInfo');
    }
}
