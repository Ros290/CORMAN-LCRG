<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $utente = $this->validate(request(),[
            'password' => 'required',
            'email' => 'required|email'
        ]);
        if(User::findUser($utente['email'],$utente['password']))
            return back()->with('success','Accesso effettuato');
        else
            return back()->withErrors('errors','Utente non trovato');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('registrazione');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $utente = $this->validate(request(),[
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|email'
        ]);
        User::create($utente);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $utente = User::find($id);
        if(!empty($utente))
            return view('search.my_profile',compact('utente'));
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Ricava dal database il modello Utente con id = $id e lo associa alla variabile $utente
        $utente = User::find($id);
        //Se è vuoto, vuol dire che nel database non esiste alcun utente con id = $id, quindi mostrerà il messaggio
        //di errore 404. Altrimenti ritorna la pagina desiderata, passandogli la variabile $utente.
        if(!empty($utente))
            return view('search.my_profile_edit',compact('utente'));
        else
            abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //verifico che il campo "descrizione", ricavato dalla pagina quale ha richiamato il metodo, sia stato inserito
        //o meno (nullable)
        $this->validate(request(),[
            'testo' => 'nullable'
        ]);
        //Ricava dal database il modello Utente con id = $id e lo associa alla variabile $utente
        $utente = User::find($id);
        //dal modello utente, inserisco la descrizione (salvato nella variabile 'testo') all'interno del campo "description"
        $utente->description = $request->get('testo');
        //salvo le modifiche effettuate sul modello Utente
        $utente->save();
        //ritorno alla pagina precedente
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
