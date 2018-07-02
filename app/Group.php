<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name','id_creator'];
    public function utenti() {
        return $this->belongsToMany('App\User');
    }

    public static function findEmail($email_admin){
        $array_admin = User::all();
        foreach ($array_admin as $utente ){
            $email = $utente->email;
            if($email==$email_admin){
                return true;
            }
        }
        return false;
    }

        public static function findGroup($name_group){
            $name_group = Group::all();
            foreach ($name_group as $gruppo ){
                $nome = $gruppo->name;
                if($nome==$name_group){
                    return true;
                }
            }
            return false;
        }


   /* public static function find($group){
        $group = Group::all();
        foreach ($group as $gruppo){
            $nome = $gruppo->id;
            if($nome==$group->id_creator){
                return $nome;
            }
        }
        return false;
    }*/
}
