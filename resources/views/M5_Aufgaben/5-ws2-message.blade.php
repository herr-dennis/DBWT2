@extends("layouts.defaultLayout")


@section("main-content")

<script>

    document.addEventListener("DOMContentLoaded", function (){

        const sendBnt = document.getElementById("sendBtn")
        const inputIDTag = document.getElementById("inputId")

        sendBnt.addEventListener("click", function (){
            let input = document.getElementById("input");
            let inputText = input.value;
            let inputId = inputIDTag.value;
            let msg = "Client meldet sich mit: "+location.hostname+"  --- "+inputText;

            let data = {
                msg: msg
            };
            sendMessageToServer(data , inputId);
        })

    })
</script>

          <h1 style="color: #00ffd5" >Schnittstelle zum Broadcaster</h1>
         <div style="display: flex; flex-direction: column; margin-top: 30px; height: 200px"    >
             <button   id="sendBtn" style="padding: 10px">Sende an den Server</button>
             <label style="padding: 10px" >Ihre Nachricht</label>
             <input id="input" type="text" value="Nachricht">
             <label>Welche ID (Client) soll diese Nachricht empfangen?</label>
             <input id="inputId" type="number" value="9412">
         </div>


@endsection

