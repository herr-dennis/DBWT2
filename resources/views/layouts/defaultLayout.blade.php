
@extends("banner.bannerView")
<html>

<head>

    {{--Wichtig für den Cache, somit wird immer die neustes CSS-Datei geladen.--}}
    <link href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/nav.css') }}?v={{ filemtime(public_path('css/nav.css')) }}" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="description" content="@yield("beschreibung")">
    <script src="{{ asset('js/nav.js') }}"></script>

</head>
<body>
<header>
    <nav id="navMenu"> </nav>
</header>

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
