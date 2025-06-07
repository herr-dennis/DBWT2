@extends("layouts.defaultLayout")



@section("main-content")

    <script>

        document.addEventListener("DOMContentLoaded", function (){
            const msgEle = document.getElementById("msg");

            listenToBroadcaster((msg) => {
                console.log("Neue Nachricht:", msg);
                msgEle.textContent = msg;
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
        function checkWebSocketServer(url, timeout = 5000) {
            return new Promise((resolve, reject) => {
                let isResolved = false;

                const socket = new WebSocket(url);

                socket.onopen = () => {
                    isResolved = true;
                    socket.close();
                    resolve(true);
                };

                socket.onerror = () => {
                    if (!isResolved) {
                        isResolved = true;
                        reject(false); // Server ist offline oder nicht erreichbar
                    }
                };

                // Falls es zu lange dauert → Timeout
                setTimeout(() => {
                    if (!isResolved) {
                        isResolved = true;
                        socket.close();
                        reject(false); // Timeout → wahrscheinlich offline
                    }
                }, timeout);
            });
        }

    </script>

     <h1>Websocket Verbindung <span id="load" ></span></h1>
    <p id="msg"></p>

@endsection
