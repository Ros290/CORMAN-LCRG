@extends('layouts.app')

        <!DOCTYPE html>
<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

    <title>Iscrizione - Larabox :: an awesome temporary file upload service</title>

    <style type="text/css">
        .container{
            text-align: center;
        }

        .logo {
            margin:35px 0px;
        }
    </style>
</head>
<body>
<div class="container">
    <img class="logo" src="{{ asset('img/logo.png') }}" />
    <form action="{{ url('signup') }}" method="post">

    <hr/>
    <p><button type="submit" class="btn btn-lg btn-success">Opzioni_1!</button></p>
    <p><button type="submit" class="btn btn-lg btn-success">Opzioni_2!</button></p>
    <p><button type="submit" class="btn btn-lg btn-success">Opzioni_3!</button></p>
    <p><button type="submit" class="btn btn-lg btn-success">Opzioni_4!</button></p>


    </form>

</div>
</body>
</html>

@endsection