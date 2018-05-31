<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Modifica il mio profilo </title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
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
    <p>Nome : <textarea name="testo" rows="1" cols=30">
         {{$utente->name}}
        </textarea>
        <a href="{{url('utente/'.$utente->id)}}" class="btn btn-success">Salva cambiamenti</a></p><br>
    <p>E-Mail : <textarea name="testo" rows="1" cols=30">
         {{$utente->email}}
        </textarea>
        <a href="{{url('utente/'.$utente->id)}}" class="btn btn-success">Salva cambiamenti</a></p><br>
    <h1> Descrizione </h1>
    <form method="post" action={{url('utente/'.$utente->id)}}>
        {{csrf_field()}}
        {{ method_field('PUT')}}
        <textarea name="testo" rows="15" cols=150">
         {{$utente->description}}
        </textarea>
        <a href="{{url('utente/'.$utente->id)}}" class="btn btn-success">Salva cambiamenti</a>
    </form>
</div>
</body>
</html>