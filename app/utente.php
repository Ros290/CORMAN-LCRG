<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class utente extends Model
{
    protected $fillable = ['name','email','password'];

    public static function findUtente($login_email,$login_password){
        $array_utente = utente::all();
           foreach ($array_utente as $utente ){
               $email = $utente->email;
               $password =$utente->password;
               if(($email==$login_email)&&($password==$login_password)){
                   return true;
               }
           }
           return false;
    }
}
