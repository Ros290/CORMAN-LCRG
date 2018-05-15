<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class utente extends Model
{
<<<<<<< HEAD
    protected $fillable = ['name','email','password','description'];
=======
    protected $fillable = ['name','email','password'];
    public function gruppi() {
        return $this->belongsToMany('App\Gruppo');
    }
>>>>>>> eea4dd8e34a9bb2725f340e8e1800d3272e9ac02
}
