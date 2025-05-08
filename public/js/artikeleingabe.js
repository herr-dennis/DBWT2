document.addEventListener('DOMContentLoaded', function() {
    const form = document.createElement("form");
    const input = document.createElement("input");
    const submit = document.createElement("input", );
    const labelForm = document.createElement("label");
    const textArea = document.createElement("textarea");
    const priceInput = document.createElement("input");
    const alertText = document.createElement("p");


    //Conf. Form..
    form.setAttribute("method", "POST");
    form.setAttribute("action", "articles");
    form.setAttribute("name", "formeNewArticle");
    form.classList.add("form");
    labelForm.textContent = "Neuen Artikel einfügen"

    //Conf InputText Artikel
    input.setAttribute("type", "text");
    input.placeholder = "Artikelname";
    input.setAttribute("name", "name");
    input.id="inputArtikel";

    //Conf InputNumber Preis
    priceInput.setAttribute("type", "number");
    priceInput.setAttribute( "name","price");
    priceInput.id="inputPreis";

    //Conf SubmitBtn
    submit.setAttribute("value", "Speichern");
    submit.setAttribute("type", "submit");
    submit.id = "btnSubmit";

    //Conf textArea Beschreibung
    textArea.textContent = "Beschreibung";
    textArea.setAttribute("name", "beschreibung");
    textArea.id = "textArea";

    //Conf alertText
    alertText.id = "alterText";

    //Csrf Verwaltung. @csrf geht nicht mit Javascript
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = token;

    form.appendChild(csrfInput);

    const mainTag = document.querySelector("main");
    form.append(labelForm);
    form.appendChild(input);
    form.appendChild(priceInput);
    form.appendChild(textArea)
    form.appendChild(submit);
    form.appendChild(alertText);
    mainTag.appendChild(form);

    // Eventlistener für die Überprüfung des Preises
    priceInput.addEventListener("change", function(event) {
        let price = event.target.value;

        if(price <1){
            alert("Preis nicht akzeptiert!")
            submit.disabled=true;
        }else{
            submit.disabled=false;
        }
    });

    // Eventlisternen für der Absenden der Daten
    submit.addEventListener("click", function(event) {
        event.preventDefault();  // Verhindert, dass das Formular abgeschickt wird, wenn Fehler da sind

        let valid = true;


        if(input.value.trim() === ""){
            alert("Name eingeben!");
            input.classList = "alert";
            valid = false;
        }

        if(priceInput.value.trim() === ""){
            alert("Preis eingeben!");
            priceInput.classList = "alert";
            valid = false;
        }

        if(valid) {
            sendForm();

        }
    });


    function sendForm(value){
        //Holt das Token aus der View
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        //Holt die Daten aus dem Formular
        let data = getValuesFromForm();
        //Erstellt ein XML Objekt
        let xhr = new XMLHttpRequest();

        xhr.open("POST", "/api/articles", true);
        //Stellt den Antwort-Typ auf Json!!
        xhr.responseType = 'json';
        //Setzt der Token in den HTTP Header
        xhr.setRequestHeader("X-CSRF-TOKEN", token);
        //Setzt die Information als HTML Tag, dass es JSON ist
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.send(JSON.stringify(data));

        // onredystatechange, wenn ist der Status ändert
        xhr.onreadystatechange = function () {

            if (xhr.readyState === 4) {
                //Unser Kontroller sendet den HTML Status
                if (xhr.status === 200 ) {
                    console.log("✅ Erfolg:", xhr.response.message);
                    alertText.textContent=xhr.response.message;
                    alertText.classList= "msg";
                } else {
                    console.error("❌ Fehler:", xhr.response.error);
                }
            }
            //Wird nur aufgerufen, wenn es ein Netzwerkfehler gibt. Keine Internetverbindung usw...
            xhr.onerror = function () {
                console.error("Ein Netzwerkfehler ist aufgetreten oder der Server ist nicht erreichbar.");
            };

        };
    }

    /**
     * Entnimmt die Daten aus dem Formular.
     * Zur Vorbereitung für AJAX
     * @returns {string[]}
     */
    function getValuesFromForm(){

        let artikelName = document.getElementById("inputArtikel");
        let artikelPreis = document.getElementById("inputPreis");
        let artikelBeschreibung = document.getElementById("textArea");
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        //CSRF muss in den Header, deswegen nicht im Data-Body!
        let data = {
            name: artikelName.value,
            preis: artikelPreis.value,
            beschreibung: artikelBeschreibung.value,
        };

         return data;

    }



});
