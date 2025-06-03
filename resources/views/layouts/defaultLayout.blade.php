@extends("banner.bannerView")
    <!DOCTYPE html>
<html>
<head>

    @vite(['resources/css/app.scss'])
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
        @section("header")


        <div id="nav-app">
           <navi-header></navi-header>

        </div>

        @show

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
