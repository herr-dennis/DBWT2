/**
 * Baut den Warenkorb auf
 */
document.addEventListener('DOMContentLoaded', () => {

    //Erstellt die nötigen Elemente
    const warenkorbLabel =document.createElement("div")
    warenkorbLabel.classList.add('warenkorb-div')
    warenkorbLabel.textContent = "Warenkorb";

    const warenkorb = document.createElement("ul")
    warenkorb.classList.add("warenkorb");
    warenkorb.id = "warenkorbID";
    // "Hängt das Warenkorb Label an das Warenkorbmenü
    warenkorb.appendChild(warenkorbLabel);

    // Choice ist ein Container mit dem Input der Artikelinformationen, die in der View erzeugt wurde
    let divs = document.getElementsByClassName('choice');

    //Laufen über alle Choice-Container, dort befindet sich ein hidden-input Feld drin, mit den Daten
    for (let i = 0; i < divs.length; i++) {

        //Zu jeden Choice-Container wird ein EventListener eingefügt
        divs[i].addEventListener('click', (e) => {

             // Holt den Aktuellen Choice-Container
            const hiddenInput = divs[i].querySelector('input[name="id"]');

            //Prüft auf Dups..
            if(proofDuplicates(hiddenInput.value)){
            hideArtikel(hiddenInput.value);
            const insertWarenkorb = document.createElement('li');

            //Logik für das Entfernen des Artikels aus dem Warenkorb
            addEventListenerByLi(insertWarenkorb, hiddenInput.value);
            const label = document.createElement('label');
            label.textContent = hiddenInput.value;
            insertWarenkorb.appendChild(label);
            warenkorb.appendChild(insertWarenkorb);}
        });
    }

    document.body.appendChild(warenkorb);  //hänge den Warenkorb ans Ende des Bodys

})
function proofDuplicates(InsertItem) {
    const warenkorb = document.getElementById("warenkorbID");

    for (let i = 0; i < warenkorb.children.length; i++) {
        if (warenkorb.children[i].textContent === InsertItem) {
            return false; // Schon vorhanden!
        }
    }
    return true; // Noch nicht drin!
}

function addEventListenerByLi(liItem, articleName) {
    const row = document.getElementById('row-' + articleName);


    //Prüft ob User eingeloggt und holt ein Warenkorb
    getStateLoggedIn()
        .then(response => {
            console.log("Erfolgreich eingeloggt:", response);
            let user = response.user;
            let loggedIn = response.auth_;

            if (user && loggedIn === "true") {
                storeArtikelInDB(articleName ,user)
                    .then(response => {
                        console.log("Artikel erfolgreich gespeichert:", response);
                    })
                    .catch(error => {
                        console.error("Fehler beim Speichern des Artikels:", error.error);
                    });
            }

        })
        .catch(error => {
            console.error("Fehler beim Abrufen des Login-Status:", error);
        });



    //Speichert den Artikel in der Datenbank /Warenkorb


    liItem.addEventListener("click", () => {
        if (row.style.display === 'none') {
            row.style.display = '';
            liItem.remove();  // Entfernt das LI aus der UL
        }
    });
}



function getWarenkorbByUser(){

}

//Promise um Callback-Hell zu vermeiden!

function getStateLoggedIn(){
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "/isloggedin", true);
        xhr.responseType = 'json';
        xhr.onload = () => {
            if (xhr.status === 200) resolve(xhr.response);
            else reject(xhr.statusText);
        };
        xhr.onerror = () => reject("Netzwerkfehler");
        xhr.send();
    });
}

function storeArtikelInDB(articleName ,user) {
    return new Promise((resolve, reject) => {
        const xhr_waren_post = new XMLHttpRequest();
        xhr_waren_post.open("POST", "/api/shoppingcart", true);
        xhr_waren_post.responseType = 'json';

        xhr_waren_post.onload = () => {
            if (xhr_waren_post.status === 200) {
                resolve(xhr_waren_post.response); // Erfolg
            } else {
                console.log(xhr_waren_post.response);
                reject(`Fehlerstatus: ${xhr_waren_post.response}`); // Fehlerstatus
            }
        };

        xhr_waren_post.onerror = () => {
            reject("Netzwerkfehler"); // Netzwerkfehler
        };
        xhr_waren_post.setRequestHeader('Content-Type', 'application/json');
        xhr_waren_post.send(JSON.stringify({
            ab_name: user,
            article_name: articleName
        }));
    });
}


function hideArtikel(articleName) {
    console.log(articleName);
        const row = document.getElementById('row-' + articleName);
        if (row) {
            row.style.display = 'none';
        }
}

