@extends('layouts.app')

@section('content')

<script>

    function myFunction() {
        /*Aggiungere crea nuovo grupppo*/

        /*
        associo a "listMail" il div all'interno di cui definirò i nuovi campi email
         */
        var listMail = document.getElementById("myList");
        /*
        essendo ogni elemento di "listMail" composto nel formato :

        <p>
            <input type=..>
        </p>

        pertanto il primo "lastElementChild" mi restituirà il riferimento all'ultimo
        tag "P" definito all'interno di div. Dato che non ci interessa, ricavo
        a sua volta l'ultimo (nonchè l'unico) elemento presente all'interno di "P"
        quale è, appunto, il riferimento al tag "INPUT"
         */
        var lastMail = listMail.lastElementChild.lastElementChild;
        /*
        Dato che abbiamo scelto di definire gli identificativi di ciascun campo
        nel formato "email<#numero>", allora ricaviamo l'id dell'ultimo tag
        "INPUT" ricavato e incrementiamo la parte intera dell'id.
         */
        var idNewMail = parseInt(lastMail.getAttribute("id").substr(5)) + 1;
        /*
        Definisco un nuovo tago "INPUT", con l'id incrementato, dopo di che lo "appendo"
        agli altri elementi già presenti del tag "div"
         */
        var newMail = document.createElement("INPUT");
        newMail.setAttribute("type","text");
        newMail.setAttribute("id","email" + idNewMail);
        newMail.setAttribute("value","email " + idNewMail);
        var p = document.createElement("P");
        p.appendChild(newMail);
        listMail.appendChild(p);

    }

</script>
<div class="container">

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
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
    @endif
    <!--
    <div>
        <button onclick="myFunction()" class = "btn btn-success">+ Aggiungi Mail</button>
    </div>
    -->

    <!--
    <div id="myList" class="align-items-baseline">
        <p><input type="text" id="email0" value="email 0"></p>
    </div>
    -->

    <form method="post" action="{{url('gruppo')}}">
        {{csrf_field()}}

    <div class="row">
        <div class="col-md-4"></div>
        <div class="form-group col-md-4">
            <label for="email_admin">Email Admin:</label>
            <input type="text" class="form-control" name="email_admin">
        </div>
    </div>

    <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="name_group">Name Group:</label>
                <input type="text" class="form-control" name="name_group">
            </div>
    </div>

    <div class="row">
        <div class="col-md-4"></div>
        <div class="form-group col-md-4">
            <button type="submit" class="btn btn-success" style="margin-left:38px">OK</button>
        </div>
    </div>
    </form>
</div>
    @endsection