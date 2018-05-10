<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class utente extends Model
{
    protected $fillable = ['name','email','password'];
}
