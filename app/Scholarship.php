<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    public $table ='scholarships';
    public $primaryKey = 'id';
    public $timestamp = true;

    public function userinfo(){
    	return $this->belongsTo('App\UserInfo');
    }
    public function schoolyear(){
    	return $this->belongsTo('App\SchoolYear','school_year_id');
    }
}
