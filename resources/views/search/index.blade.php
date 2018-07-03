@extends('layouts.app')

@section('content')
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
                    <input data-toggle="collapse" type="checkbox"  data-target="{{"#".$attribute['id']}}">{{$attribute['name']}}<br>
                @endforeach
            </div>
        </div>
        <form method="post" action="{{url('result/'.$option['id'])}}">
            @csrf
            <div class="row" id="fieldsTag">
                @foreach($attributes as $attribute)
                    <div class="form-group col-md-4 accordian-body collapse" id="{{$attribute['id']}}">
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
            <table class="table table-condensed" style="border-collapse:collapse;">
                <thead>
                <tr>
                    @foreach((\Session::get('jsonAPI'))[0]['table'] as $field => $value )
                        <th>{{$field}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach(\Session::get('jsonAPI') as $element_array)
                    <tr data-toggle="collapse" data-target="{{"#carmilla".$loop->index}}" class="accordion-toggle">
                        @foreach($element_array['table'] as $value_table)
                            <td>
                                {{$value_table}}
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td colspan="12" class="hiddenRow">
                            <div id="{{"carmilla".$loop->index}}" class="accordian-body collapse">
                                <table class="table table-striped">
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
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection