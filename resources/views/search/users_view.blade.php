@extends('layouts.app')

@section('content')
<div class="container">
    <h1> Modifica il mio profilo </h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br/>
@endif
    <div class="container">
        <p>@foreach ($utente->all() as $utente)
               {









            @endforeach
        </p>

    </div>
    <a href="{{url('utente/'.$utente->id)}}" class="btn btn-success">Torna al tuo profilo</a>
</div>
    @endsection