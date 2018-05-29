<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Index Page</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
    <script>
        function myFunction() {
            var divMail = document.getElementById("myList");
            var lastChild = divMail.lastElementChild;
            var x = document.createElement("INPUT");
            x.setAttribute("type", "text");
            x.setAttribute("value","");
            var node = document.createElement("P");
            var t = document.createTextNode("Email ");
            var Email = document.getElementById("Email");
            var number = Email.innerHTML;
            number++;
            var node = document.createElement("P");
            node.setAttribute("id", "Email");
            var s = document.createTextNode(number);
            node.appendChild(t);
            node.appendChild(s);
            node.appendChild(x);
            divMail.appendChild(node);
        }
    </script>
</head>
<div class="container">
    <div>
        <button onclick="myFunction()" class = "btn btn-success">+ Aggiungi Mail</button>
    </div>

    <div id="myList" class="align-items-baseline">
        <p>Email <b id="Email">0 </b><input type="text" id="email0"></p>
    </div>
</div>
</body>
</html>
