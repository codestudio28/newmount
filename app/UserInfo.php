<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    public $table ='user_infos';
    public $primaryKey = 'id';
    public $timestamp = true;
    protected $fillable = [
        'lastname', 'firstname', 'middlename',
    ];

  
    public function scholarships(){
    	return $this->hasOne('App\Scholarship','user_id');
    }
    public function barangay(){
    	return $this->belongsTo('App\Barangay');
    }
}
