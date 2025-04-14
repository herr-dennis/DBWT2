@extends("layouts.defaultLayout")
@section("title", "Home")
@section("main-content")
<h2>Home....</h2>

    <button onclick="onClickBtn()" >TestData</button>

    <script>
        function onClickBtn(){
            window.location.href="/TestData";
        }
    </script>
@endsection


