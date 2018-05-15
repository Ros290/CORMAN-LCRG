<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class utente extends Model
{
    protected $fillable = ['name','email','password'];
    public function gruppi() {
        return $this->belongsToMany('App\Gruppo');
    }
}
