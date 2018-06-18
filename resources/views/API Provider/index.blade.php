@extends('layouts.app')

@section('content')
<div class="container">
    <br />
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div><br />
    @endif
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name App</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody >
        @foreach($providers as $provider)
            <tr>
                {{csrf_field()}}
                <td>{{$provider['name']}}</td>
                @switch($provider['isOn'])
                    @case(1)
                    <td>Online</td>
                    @break
                    @case(0)
                    <td>Offline</td>
                    @break
                @endswitch

                <td><a href="{{action('ApiProviderController@edit', $provider['id'])}}" class="btn btn-warning">Show/Edit</a></td>
                <td>
                    <form action="{{action('ApiProviderController@destroy', $provider['id'])}}" method="post">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        <tr>
            <td><a href="{{url('providers/create/')}}" class="btn btn-success">Define new API Provider</a></td>
        </tr>
        </tbody>
    </table>
</div>
    @endsection