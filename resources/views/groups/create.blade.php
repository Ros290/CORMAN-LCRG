<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CORMAN </title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
    <script>
        function incrementa() {
            var node = document.createElement("LI");
            var textnode = document.createTextNode("Email");
            node.appendChild(textnode);
            document.getElementById("myList").appendChild(node);
        }
    </script>
</head>

<body>
<div class="container">
    <h2>Create A Product</h2><br  />
</div>
<form method="get" action "{{url('group\create')}}">
<ul id="myList">
</ul>
<table>
    <tr>
        <td>Inserire l'email dell'utente da aggiungere al gruppo. </td>
    <tr>
    <tr>
    <tr>
    <tr>
        <td>Email</td>
        <td><input type="text" id="numero" value= "" /></td>
        <td> <input type="submit" value="+" onclick="incrementa()" />
        </td>
    </tr>
</table>

</body>
</html>

