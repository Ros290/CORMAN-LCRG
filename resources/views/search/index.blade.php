<!DOCTYPE html>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
    <meta charset="utf-8">
    <title>CORMAN </title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script>
        function showOrHide(idField){
            var checkBox = document.getElementById('cbf' + idField);
            var inputField = document.getElementById('if' + idField);
            if(checkBox.checked === true){
                inputField.style.display = 'table-cell';
            }
            else inputField.style.display = 'none';
        }
    </script>
</head>
<body>
<div class="container">
    <h2>Search {{$option['name']}}</h2><br/>
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
        //TI
        <?php
        $result = \Session::get('jsonAPI');
        $json = json_decode($result, true);
        if (is_array($json)) {
            foreach ($json as $result){
                echo '<p>';
                foreach($attributes as $attribute)
                    echo $result[$attribute['attr_json']];
                echo ';</p>';
            }
        }

        ?>
    @endif
</div>
</body>
</html>