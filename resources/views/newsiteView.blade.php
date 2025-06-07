@extends("layouts.defaultLayout")

@section("header")
@endsection

@section("main-content")

    <div id="app" >
        <site-header></site-header>
        <navi-header></navi-header>
        <maintenance></maintenance>
        <site-body ref="siteBody"></site-body>
        <site-footer></site-footer>
    </div>

@endsection


