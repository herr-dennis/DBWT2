@extends("layouts.defaultLayout")



@section("main-content")

    <script>

        document.addEventListener("DOMContentLoaded", function () {
            const msgEle = document.getElementById("msg");
            const angekommenLabel = document.getElementById("angekommen");
            const alertLabel = document.getElementById("alert")

            listenToBroadcaster((msg) => {
                console.log("Neue Nachricht:", msg); // Kontrolliere, was wirklich ankommt

                let id = msg.id;
                let clientID = 9412;

                if(id===clientID){
                    alertLabel.textContent="VOLLEN ZUGRIFF"
                }


                if (msgEle) {
                    msgEle.textContent = msg.message;
                }

                if (angekommenLabel) {
                    angekommenLabel.textContent = "Angekommen ID:"+ String(msg.id);
                }
            });





        function load(){

                let maxPoints = 5;
                let currentPoint =0;
                const loadBalken = document.getElementById("load");
                setInterval(()=>{
                    loadBalken.append(".")
                    if(currentPoint===maxPoints){
                        loadBalken.textContent="."
                        currentPoint=0;
                    }
                    currentPoint++;
                },1000)

            }
            load();
        })

    </script>

    <h1>Websocket Verbindung  <span id="load" ></span></h1>
     <p>Ihre Client ID lauter : 9412</p>
     <p id="angekommen">Angekommen ID :</p>
      <p id="msg"></p>
    <p style="color: green; font-size: 40px" id="alert"></p>

@endsection

