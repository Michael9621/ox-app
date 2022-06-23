<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['user_id', 'type'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
