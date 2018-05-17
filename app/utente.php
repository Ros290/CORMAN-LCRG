<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class utente extends Model
{
<<<<<<< HEAD
    protected $fillable = ['name','email','password','description'];
=======
    protected $fillable = ['name','email','password'];
<<<<<<< HEAD

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
=======
    public function gruppi() {
        return $this->belongsToMany('App\Gruppo');
    }
>>>>>>> eea4dd8e34a9bb2725f340e8e1800d3272e9ac02
>>>>>>> 0c2b393ad0cce3001c5b3e5360bce99b9c1bc129
}
