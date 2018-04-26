<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchOption extends Model
{
    protected $fillable = ['name','root_path'];

    public function fields()
    {
        return $this->hasMany('App\Field','id_option');
    }

}
