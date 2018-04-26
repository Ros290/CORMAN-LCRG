<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = ['name','query_path','values','id_option'];
    protected $visible = ['id','name'];
}
