<!DOCTYPE html>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
    <meta charset="utf-8">
    <title>CORMAN </title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <style>
        .description {
            position:absolute;
            border:1px solid #000;
            background: #ffffff;
        }
    </style>
    <script>
        function showOrHide(idField){
            var checkBox = document.getElementById('cbf' + idField);
            var inputField = document.getElementById('if' + idField);
            if(checkBox.checked === true){
                inputField.style.display = 'table-cell';
            }
            else inputField.style.display = 'none';
        }
        //TODO: implementare funzione per mostrare popup e caricare modifica modello Fields

        function carmillOn(idCarmilla){
            var carmilla = document.getElementById(idCarmilla);
            carmilla.style.display = 'block';
            /*
            var div = x.lastElementChild;
            div.display = 'table-cell';
            */
        }

        function carmillOff(idCarmilla){
            var carmilla = document.getElementById(idCarmilla);
            carmilla.style.display = 'none';
            /*
            var div = x.lastElementChild.lastElementChild;
            div.display = 'none';
            */
        }

        /*
        $(".tiptext").mouseover(function() {
            $(this).children(".description").show();
        }).mouseout(function() {
            $(this).children(".description").hide();
        });
        */

    </script>
</head>
<body>
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
        {{ csrf_field() }}
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
                        <td>
                            <div onmouseover="javascript:carmillOn({{"carmilla".$loop->parent->index}})" onmouseout="javascript:carmillOff({{"carmilla".$loop->parent->index}})">
                                {{$value_table}}
                            <div class="description" id="{{"carmilla".$loop->parent->index}}" style="display:none">
                                @foreach($element_array['popup'] as $field_popup => $value_popup)
                                    <p>{{$field_popup.' : '.$value_popup}}</p>
                                @endforeach
                            </div>
                            </div>
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
</body>
</html>