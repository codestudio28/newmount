<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    public function oldclient(){
    	return $this->belongsTo('App\Client','oldclient_id');
    }
}
