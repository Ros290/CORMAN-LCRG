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
    <form method="post" action={{url('utente/'.$utente->id)}}>
        {{csrf_field()}}
        {{ method_field('PUT')}}
    <p>Nome :
            {{$utente->name}}
    </p>
    <p>E-Mail :
        {{$utente->email}}
    </p>
        <!-- TODO: non mostrare Descrizione se è vuoto-->
        @if (isset($description))
            <h1> Descrizione </h1>
        <p> {{$utente->description}}</p>
    </form>
    @endif
    <a href="{{url('utente/'.$utente->id.'/edit')}}" class="btn btn-success">Modifica</a>
    <a href="{{url('utente/'.$utente->id.'/users_view')}}" class="btn btn-success">Visalizza utenti</a>
</div>
    @endsection