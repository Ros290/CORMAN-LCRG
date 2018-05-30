<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Index Page</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
    <script>
        function myFunction() {
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
</head>
<div class="container">
    <div>
        <button onclick="myFunction()" class = "btn btn-success">+ Aggiungi Mail</button>
    </div>

    <div id="myList" class="align-items-baseline">
        <p><input type="text" id="email0" value="email 0"></p>
    </div>
</div>
</body>
</html>
