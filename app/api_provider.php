<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class api_provider extends Model
{
    protected $fillable = ['name'];

    /**
     * Analizza il provider "attivo", qualora ce ne sia uno attivo, per poterne ricavare il Token
     * per poter effettuare le interrogazioni tramite API.
     * @return bool|mixed ritorna il Token del provider, se ce n'è uno "attivo". altrimenti FALSE
     */
    static public function getToken(){
        $provider = api_provider::where('isOn','1')->first();
        if ($provider)
            return $provider->remember_token;
        return false;
    }

    /**
     * Analizza il provider "attivo", qualora ce ne sia uno attivo, per poterne ricavare l'host
     * su cui poter indirizzare le interrogazioni tramite API.
     * @return bool|mixed ritorna l'host del provider, se ce n'è uno "attivo". altrimenti FALSE
     */
    static public function getHost(){
        $provider = api_provider::where('isOn','1')->first();
        if ($provider)
            return $provider->host;
        return false;
    }
}
