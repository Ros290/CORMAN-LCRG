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

</div>
</body>
</html>