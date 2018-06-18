@extends('layouts.app')

@section('content')
<script>
    function showOrHide(fieldsTag)
    {
        if (document.getElementById(fieldsTag).style.display == 'none') {
            document.getElementById(fieldsTag).style.display = 'table-cell';
        }
        else document.getElementById(fieldsTag).style.display = 'none';
    }
</script>
<div class="container">
    <br />
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div><br />
    @endif
    @foreach($options as $option)
        <table class="table table-striped">
            <thead>
            <tr>
                <th>{{$option['name']}}</th>
                <th><a href="{{action('SearchOptionController@edit', $option['id'])}}" class="btn btn-warning">Edit</a></th>
                <th>
                    <form action="{{action('SearchOptionController@destroy', $option['id'])}}" method="post">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </th>
                <th>
                    <a onclick="javascript:showOrHide('{{'fields'.$loop->index}}')" class="btn btn-warning">Show/Hide Fields</a>
                </th>
            </tr>
            </thead>

            <tbody id="{{'fields'.$loop->index}}" style="display:none">
            @foreach ($fields = $option->fields->toArray() as $field)

                <tr>
                    <td>{{$field['name']}}</td>
                    <td><a href="{{action('FieldController@edit', $field['id'])}}" class="btn btn-warning">Edit Field</a></td>
                    <td>
                        <form action="{{action('FieldController@destroy', $field['id'])}}" method="post">
                            {{csrf_field()}}
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="btn btn-danger" type="submit">Delete Field</button>
                        </form>
                    </td>
                    <td><a href="{{url('subFields/create/'.$field['id'])}}" class="btn btn-success">Add new Sub-Field</a></td>
                </tr>


            @endforeach
            </tbody>
        </table>
    @endforeach
</div>
@endsection