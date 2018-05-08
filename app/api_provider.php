<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class api_provider extends Model
{
    protected $fillable = ['name'];

    static public function getToken(){
        $provider = api_provider::where('isOn','1')->first();
        if ($provider)
            return $provider->remember_token;
        return false;
    }

    static public function getHost(){
        $provider = api_provider::where('isOn','1')->first();
        if ($provider)
            return $provider->host;
        return false;
    }
}
