<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Verifica la presenza o meno di un utente associato ai dati passati come parametri
     * @param $login_email indirizzo email dell'utente da convalidare
     * @param $login_password password dell'utente da convalidare
     * @return bool ritora true se i campi sono associabili ad un utente, altrimenti false
     */
    public static function findUser($login_email,$login_password){
        $array_utente = User::all();
        foreach ($array_utente as $utente ){
            $email = $utente->email;
            $password =$utente->password;
            if(($email==$login_email)&&($password==$login_password)){
                return true;
            }
        }
        return false;
    }

    /**
     * Ritorna una collezione di modelli "Group" associati al modello in analisi
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups() {
        return $this->belongsToMany('App\Group');
    }
}
