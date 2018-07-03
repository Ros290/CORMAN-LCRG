@extends('layouts.app')

@section('content')
<div class="container">
    <br />
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div><br />
    @endif
    <table class="table table-condensed" style="border-collapse:collapse;">
        @foreach($options as $option)
            <tbody>
            <tr data-toggle="collapse" data-target="{{"#fields".$loop->index}}" class="accordion-toggle">
                <td>
                    <b>{{$option['name']}}</b>
                </td>
                <td>
                    <a href="{{action('SearchOptionController@edit', $option['id'])}}" class="btn btn-warning">Edit</a>
                </td>
                <td>
                    <form action="{{action('SearchOptionController@destroy', $option['id'])}}" method="post">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <tr>
                <td colspan="12" class="hiddenRow">
                    <div id="{{"fields".$loop->index}}" class="accordian-body collapse">
                        <table class="table table-striped">
                            <tbody>
                                @foreach ($fields = $option->fields->toArray() as $field)
                                    <tr>
                                        <td>{{$field['name']}}</td>
                                        <td><a href="{{action('FieldController@edit', $field['id'])}}" class="btn btn-warning">Edit Field</a></td>
                                        <td>
                                            <form action="{{action('FieldController@destroy', $field['id'])}}" method="post">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button class="btn btn-danger" type="submit">Delete Field</button>
                                            </form>
                                        </td>
                                        <td><a href="{{url('subFields/create/'.$field['id'])}}" class="btn btn-success">Add new Sub-Field</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            </tbody>
        @endforeach
    </table>
</div>
@endsection