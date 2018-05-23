<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name','id_creator'];
    public function utenti() {
        return $this->belongsToMany('App\User');
    }
}
