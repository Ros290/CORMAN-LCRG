@extends('layouts.app')

@section('content')
<script>
    function fieldValue(){
        var php_var = "{{$field->values}}";
        var id = (php_var == 1) ? "ifYes" : "ifNo";
        var radio_btn = document.getElementById(id);
        radio_btn.setAttribute("checked","checked");
    }
    window.onLoad = fieldValue;
</script>
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
    <form method="post" action="{{action('FieldController@update', $id)}}">
    {{csrf_field()}}
    {{ method_field('PUT')}}<!--funzione UPDATE del modello accetta solo richieste con metodo PUT-->
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" value="{{$field->name}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="name">Option:</label>
                <select class="form-control" name="id_option">
                    @foreach ($options = App\SearchOption::all() as $option)
                        <option value={{$option['id']}} {{($option['id'] == $field->id_option) ? 'selected' : ''}}>{{$option['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="query">Parameter on URL request:</label>
                <input type="text" class="form-control" name="attr_url" value="{{$field->attr_url}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="query">Parameter on JSON</label>
                <input type="text" class="form-control" name="attr_json" value="{{$field->attr_json}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="values">Values?:</label>
                <input type="radio" id="ifYes" class="form-control" name="values"  value="0" {{(!$field->values) ? 'checked' : ''}}>No<br>
                <input type="radio" id="ifNo" class="form-control" name="values" value="1" {{($field->values) ? 'checked' : ''}}>Yes
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="on_popup">On Popup Window?:</label>
                <input type="radio" class="form-control" name="on_popup" value="0" {{(!$field->on_popup) ? 'checked' : ''}}>No<br>
                <input type="radio" class="form-control" name="on_popup" value="1" {{($field->on_popup) ? 'checked' : ''}}>Yes
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-success" style="margin-left:38px">Update Field</button>
            </div>
        </div>
    </form>
</div>
    @endsection