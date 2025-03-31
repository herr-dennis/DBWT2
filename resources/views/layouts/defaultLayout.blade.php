<html>
<head>

    {{--Wichtig für den Cache, somit wird immer die neustes CSS-Datei geladen.--}}
    <link href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="description" content="@yield("beschreibung")">

</head>
<body>
<main>
    @section("main-content")
    @show
</main>
<footer>
    @section("footer")
    @show
</footer>
</body>
</html>
