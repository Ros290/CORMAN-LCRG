@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifica Nome Gruppo</h2><br  />
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
    @endif

    <form method="get" action="{{url('gruppo/'.$group->id)}}">
        @csrf
        {{ method_field('PUT')}}
    <div class="row">
    <div class="col-md-4"></div>
    <div class="form-group col-md-4">
        <label for="name_group">Name Group:</label>
        <input type="text" class="form-control" name="name_group">
    </div>
    </div>
    </form>
</div>
    @endsection