<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Photo extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['img', 'user_id', 'slug'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function musers(){
        return $this->belongsToMany('App\User', 'photo_user', 'photo_test_id','user_test_id');
    }
}
