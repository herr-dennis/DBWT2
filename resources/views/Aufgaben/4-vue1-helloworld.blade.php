<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Hello Vue</title>
    @vite('resources/js/app.js')
</head>
<body>
<div id="app">
    <p>@{{ msg }}</p>
</div>
<div id="tab">
    <ul>
        <li v-for="auto in autos" :key="auto.name">
            @{{ auto.name }} – @{{ auto.price }} €
        </li>
    </ul>
    <button v-on:click="addItem()" >Add</button>
</div>


</body>
</html>
