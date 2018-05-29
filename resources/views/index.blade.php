<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laravel 5.5 CRUD Tutorial With Example From Scratch </title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
<div class="row">
    <div class="form-group col-md-4">
        <a href="{{action('SearchOptionController@create')}}" class="btn btn-success">Create Options/Fields</a><br>
        <a href="{{action('SearchOptionController@index')}}" class="btn btn-success">Show/Delete Options/Fields</a><br>
        <a href="{{action('ApiProviderController@index')}}" class="btn btn-success">Manage Providers</a><br>
        @foreach($options as $option)
            <a href="{{url('search/'.$option->id)}}" class="btn btn-success">Search {{$option->name}}</a><br>
@endforeach
</body>
</html>