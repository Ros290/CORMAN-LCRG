<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Index Page</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
    <script>
        function myFunction() {
            var node = document.createElement("OL");
            var textnode = document.createTextNode("Email");
            node.appendChild(textnode);
            document.getElementById("myList").appendChild(node);

        }
    </script>
</head>
<div class="container">

    <div>
        <td>Email</td>
        <td><input type="text" id="1" value= "" /></td>
        <button onclick="myFunction()">+</button>
    </div>
    <div id="myList">

       </div>
   </div>
   </body>
   </html>
