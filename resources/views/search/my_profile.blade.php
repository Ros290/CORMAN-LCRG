@extends('layouts.app')

@section('content')
<div class="container">
    <h1> Il mio profilo </h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br/>
    @endif
    <p>Nome : {{$utente->name}}</p><br>
    <p>E-Mail : {{$utente->email}}</p><br>
    <h1> Descrizione </h1>
    <form method="post" action={{url('utente/'.$utente->id)}}>
        {{csrf_field()}}
        {{ method_field('PUT')}}
    <textarea name="testo" rows="15" cols=150">
         {{$utente->description}}
        </textarea>
        <button type="submit" class="btn btn-success" style="margin-left:38px">Salva Descrizione</button>
    </form>
    <a href="{{url('utente/'.$utente->id.'/edit')}}" class="btn btn-success">Modifica</a>
    <a href="{{url('utente/'.$utente->id.'/view_user')}}" class="btn btn-success">Visalizza utenti</a>
</div>
    @endsection