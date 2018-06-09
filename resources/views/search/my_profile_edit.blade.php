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
    <p>Nome :
    <form method="post" action={{url('utente/'.$utente->id)}}>
    {{csrf_field()}}<!--da usare ogni volta che si definisce il tag FORM-->
        {{ method_field('PUT')}}
        <input type="text" name="nome" rows="1" cols=30">
         {{$utente->name}}
         </input></p>
    <p>E-Mail :
        <input type="text" name="email" rows="1" cols=30">
         {{$utente->email}}
        </input></p>
    <h1> Descrizione </h1>
        <!--
        Come ti accennai tempo fa, se sei interessato ad inviare una serie di dati da una pagina all'altra,
        ti basta riportare tali campi all'interno di un tag FORM. In questo modo, dovrai definire l'url di destinazione
        solo una volta

        l'unica cosa che devi fare, quindi, è quello di mettere allZZinterno di form gli altri campi.

        Dopo di che, assicurati che ciascun campo d'istentazione sia riconoscibile tramite un univoco nome.
        Questo perchè, quando passerai i dati al controller, essi saranno accessibili solo tramite il nome.
        Per esempio, quando sarai nel controller e vorrai ricavare il valore contenuto nella barra del nome

                <input type="text" name="idCampo1" [...]>

        Allora dovrai usare "idCampo1" per leggerlo nel controller
        -->
        <textarea type="text" name="testo" rows="15" cols=150">
         {{$utente->description}}
        </textarea>
        <button type="submit" class="btn btn-success" style="margin-left:38px">Salva Cambiamenti</button>
    </form></p>
    <a href="{{url('utente/'.$utente->id)}}" class="btn btn-success">Torna indietro</a>
</div>
</body>
</html>