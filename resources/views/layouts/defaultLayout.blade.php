@extends("banner.bannerView")
    <!DOCTYPE html>
<html>
<head>

    @vite(['resources/css/app.css'])
    @vite(["resources/js/app.js"])

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="description" content="@yield("beschreibung")">
    @section("head")
    @show

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
