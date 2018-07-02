@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit A Group</h2><br  />
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
    @endif

</div>
    @endsection