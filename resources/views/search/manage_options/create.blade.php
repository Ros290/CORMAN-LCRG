<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CORMAN </title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
<div class="container">
    <h2>Create A Product</h2><br  />
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
    @endif
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div><br />
    @endif
    <form method="post" action="{{url('options')}}">
        {{csrf_field()}}
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="price">Path API Mendeley:</label>
                <input type="text" class="form-control" name="root_path">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-success" style="margin-left:38px">Add Option</button>
            </div>
        </div>
    </form>
    <form method="post" action="{{url('fields')}}">
        {{csrf_field()}}
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="name">Option:</label>
                <select class="form-control" name="id_option">
                    @foreach ($options as $option)
                        <option value={{$option['id']}}>{{$option['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="query">Query API Mendeley:</label>
                <input type="text" class="form-control" name="query_path">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="values">Values?:</label>
                <input type="radio" class="form-control" name="values" value="1">Yes<br>
                <input type="radio" class="form-control" name="values" value="0" checked>No
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <button type="submit" class="btn btn-success" style="margin-left:38px">Add Field</button>
            </div>
        </div>
    </form>
</div>
</div>
</body>
</html>