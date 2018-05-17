<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gruppo extends Model
{
    protected $fillable = ['name','id_creator'];
    public function utenti() {
        return $this->belongsToMany('App\utente');
    }
}
