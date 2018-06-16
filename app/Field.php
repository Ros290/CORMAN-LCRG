<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = ['name','attr_url','attr_json','on_popup','values','id_option'];
    protected $visible = ['id','name'];
}
