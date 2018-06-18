@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit A Product</h2><br  />
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
    @endif
    <form method="post" action="{{action('ApiProviderController@update', $id)}}">
    {{csrf_field()}}
    {{ method_field('PUT')}}<!--funzione UPDATE del modello accetta solo richieste con metodo PUT-->
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" value="{{$provider->name}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="host">Host:</label>
                <input type="text" class="form-control" name="host" value="{{$provider->host}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="id_app">ID App:</label>
                <input type="text" class="form-control" name="id_app" value="{{$provider->id_app}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="secret_app">Secret App:</label>
                <input type="text" class="form-control" name="secret_app">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="isOn">Status:</label>
                <input type="radio" class="form-control" name="isOn" value="0" {{(!$provider->isOn) ? 'checked' : ''}}>Offline<br>
                <input type="radio" class="form-control" name="isOn" value="1" {{($provider->isOn) ? 'checked' : ''}}>Online<br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-success" style="margin-left:38px">Update Provider</button>
            </div>
        </div>
    </form>
</div>
    @endsection