@extends("layouts.defaultLayout")

@section("main-content")

    <script src="{{asset("js/3-ajax1-static.js")}}" ></script>

    <h2 class="h1Tag">Anfrage stellen...</h2>


    <div class="btnContainer" >
        <button class="btn" id="fetchBtn" >Los! Ich will die Daten</button>
        <button class="btn" id="clearBtn" > Reset </button>
        <button class="btn" id="updateBtn" >Update 3sec</button>
        <button class="btn" id="stopBtn" >Stoppe Update (3sec)</button>
    </div>


     <p class="loadBalken" id="msg" >Load</p>


@endsection
