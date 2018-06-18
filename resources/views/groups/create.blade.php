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

    //Route::resource('photos', 'PhotoController');

    function myFunction2() {

        var listGroup = document.getElementById("myGroup");
        var newGroup = document.createElement("INPUT");
        newGroup.setAttribute("type","text");
        newGroup.setAttribute("id","gruppo");
        newGroup.setAttribute("value","nome_gruppo");
        var d = document.createElement("P");
        d.appendChild(newGroup);
        listGroup.appendChild(d);


        var newAdmin = document.createElement("INPUT");
        newAdmin.setAttribute("type","text");
        newAdmin.setAttribute("id","admin");
        newAdmin.setAttribute("value","email_admin");
        d.appendChild(newAdmin);
        listGroup.appendChild(d);

    }

</script>
<div class="container">
    <div>
        <button onclick="myFunction()" class = "btn btn-success">+ Aggiungi Mail</button>
    </div>

    <div id="myList" class="align-items-baseline">
        <p><input type="text" id="email0" value="email 0"></p>
    </div>

    <div>
        <button onclick="myFunction2()" class = "btn btn-success">+ Crea Gruppo</button>
    </div>

    <div id="myGroup" class="align-items-baseline"></div>

</div>
    @endsection