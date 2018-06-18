@extends('layouts.app')

@section('content')
<script>
    function showOrHide(idField){
        var checkBox = document.getElementById('cbf' + idField);
        var inputField = document.getElementById('if' + idField);
        if(checkBox.checked === true){
            inputField.style.display = 'table-cell';
        }
        else inputField.style.display = 'none';
    }

    function carmillOn(idCarmilla){
        var carmilla = document.getElementById(idCarmilla);
        carmilla.style.display = 'block';
    }

    function carmillOff(idCarmilla){
        var carmilla = document.getElementById(idCarmilla);
        carmilla.style.display = 'none';
    }

</script>
<div class="container">
    <h2>Search {{$option['name']}}</h2><br/>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
    @endif
    <div class ="row" id="checkBoxTag">
        <div class="form-group col-md-4">
            @foreach($attributes as $attribute)
                <input type="checkbox" id="cbf{{$attribute['id']}}" onClick="javascript:showOrHide({{$attribute['id']}})">{{$attribute['name']}}<br>
            @endforeach
        </div>
    </div>
    <form method="post" action="{{url('result/'.$option['id'])}}">
        @csrf
        <div class="row" id="fieldsTag">
            @foreach($attributes as $attribute)
                <div class="form-group col-md-4" id="if{{$attribute['id']}}" style="display:none">
                    <label for={{$attribute['id']}}>{{$attribute['name']}}:</label>
                    <input type="text" class="form-control" name={{$attribute['id']}}>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-success" style="margin-left:38px">Search</button>
            </div>
        </div>
    </form>
    @if(\Session::has('jsonAPI'))
        <table class="table table-striped">
            <thead>
            <tr>
                @foreach((\Session::get('jsonAPI'))[0]['table'] as $field => $value )
                    <th>{{$field}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach(\Session::get('jsonAPI') as $element_array)
                <tr>
                    @foreach($element_array['table'] as $value_table)
                        <td onMouseOver="javascript:carmillOn('{{"carmilla".$loop->parent->index}}')" onmouseout="javascript:carmillOff('{{"carmilla".$loop->parent->index}}')">
                                {{$value_table}}
                            <div class="description" id="{{"carmilla".$loop->parent->index}}" style="display:none">
                                <table class="table">
                                <tbody>
                                @foreach($element_array['popup'] as $field_popup => $value_popup)
                                    <tr>
                                        <th>{{$field_popup}}</th>
                                        <td>{{$value_popup}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                </table>
                            </div>
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection