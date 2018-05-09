<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchOption extends Model
{
    protected $fillable = ['name','root_path'];

    /**
     * Dal modello dell'opzione, ne ricava tutti i Campi ad esso associati
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fields(){
        return $this->hasMany('App\Field','id_option');
    }

}
