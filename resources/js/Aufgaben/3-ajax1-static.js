import {im} from "mathjs";


let loading = true;
    let stopUpdate = false;
    const btn = document.getElementById("fetchBtn");
    const resetBtn= document.getElementById("clearBtn");
    const updateBtn = document.getElementById("updateBtn");
    const stopUpdateBtn = document.getElementById("stopBtn");
     let its  = 1;
    import {abs , add}  from "mathjs";


export function  ajax(){

    stopUpdateBtn.addEventListener("click", function() {
        stopUpdate = true;
    })

    updateBtn.addEventListener("click", function (){
        stopUpdate = false;
        startPeriodicLoading();
    })

    btn.addEventListener("click", () => {
        load();
    });
    resetBtn.addEventListener("click", () => {
     reset();
    })

    /**
     * Funktion, um Daten vom Server zu laden.
     */
    function load() {

        let xhr = new XMLHttpRequest();
        let baseUlr =  location.protocol +"//"+ location.host;
        console.log(baseUlr);

        //Statement der Anfrage aufbauen.
        xhr.open("GET", baseUlr + "/"+"static/message.json");

        //Warten auf Antwort
        xhr.onreadystatechange = function () {
            //4 Antwort verfügbar
            if(xhr.readyState ===4){
                ladeBalken();
                if(xhr.status === 200){
                    const text = document.getElementById("msg");
                    text.innerText = "Status:"+xhr.statusText+" Nachricht: "+ xhr.responseText+"Its: "+its;
                    loading = false;

                }else{
                    console.error(xhr.statusText);
                }

            }

        };

        xhr.onerror = function () {
            console.error(xhr.statusText);
        };
        //Hier wird die Anfrage abgesendet
        xhr.send();

    }

    /**
     * Animation des Ladebalkens
     */
    function ladeBalken(){
        let n = 0;
        const msgElement = document.getElementById("msg");

        //setIntervall eine JS-Funktion die alle X den Code wiederholt
        const interval = setInterval(() => {
            if (!loading) {
                //clearInterval beendet das Interall
                clearInterval(interval);
                return;
            }

            //repeat eine JS-Funktion, die einfach den String x-mal wiederholt
            msgElement.textContent = "Load" + ".".repeat(abs(n % 3) +1);
            n++;
        }, 500); // alle 0,5 Sekunden ein Punkt mehr
    }


    /**
     * Setzt das HTML-Element <p id=text > wieder zurück.
     * Startet den Ladebalken
     */
    function reset(){
        const msgElement = document.getElementById("msg");
        msgElement.textContent = "";
        loading =true;
        ladeBalken();
    }





    function updateJson(){
        let xhr_ = new XMLHttpRequest();
        let baseUlr =  location.protocol +"//"+ location.host;
        console.log(baseUlr);
        xhr_.open("GET", baseUlr + "/updateJson");

        its = add(its,1);

        //Statement der Anfrage aufbauen.
        xhr_.onreadystatechange = function () {
            //4 Antwort verfügbar
            if(xhr_.readyState ===4){
                ladeBalken();
                if(xhr_.status === 200){
                   console.log("Json-Update!")

                }else{
                    console.error(xhr_.statusText);
                }
            }
        };

        xhr_.onerror = function () {
            console.error(xhr_.statusText);
        };
        //Hier wird die Anfrage abgesendet
        xhr_.send();
    };

    /**
     * Führt alle 3 Sekunden eine neue Anfrage aus (zyklisches Nachladen)
     */
    function startPeriodicLoading() {
        // alle 3 Sekunden einmal load() aufrufen
     let  interval =  setInterval(() => {
            if(stopUpdate){
                clearInterval(interval);
                return;
            }
            updateJson();
            reset();  // damit ladeBalken animiert
            load();   // lädt den neuen Text vom Server
        }, 3000);
    };

    ladeBalken();


    }
