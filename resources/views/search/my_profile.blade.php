<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Il mio profilo </title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
<div class="container">
    <h1> Il mio profilo </h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
@endif
          <p>Nome : {{$utente->name}}</p><br>
          <p>E-Mail : {{$utente->email}}</p><br>
    <h1> Descrizione </h1>
    <textarea name="descrizione" rows="15" cols=150">
        </textarea>
    <form action=http://www.html.it target=”_blank”>
        <input type=”submit”value=”visita HTML.it”>
    </form>
</div>
</body>
</html>