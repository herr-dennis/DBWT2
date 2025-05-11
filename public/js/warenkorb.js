/**
 * Baut den Warenkorb auf
 */
let user = null;
const warenkorb = document.createElement("ul")
let shoppingID = null;
let items;
let userInformation = null;
document.addEventListener('DOMContentLoaded', () => {

    //Erstellt die nötigen Elemente
    const warenkorbLabel =document.createElement("div")
    warenkorbLabel.classList.add('warenkorb-div')
    warenkorbLabel.textContent = "Warenkorb";


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
    loadWarenkorb();
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
            user = response.user;
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


    liItem.addEventListener("click", () => {
        if (row.style.display === 'none') {
            deleteItemNotLoadedItemsShoppingcart(articleName).then((response) => {
                console.log("Artikel erfolgreich gespeichert:", response);
            }).catch(error => {
                console.log(error);
            })
            row.style.display = '';
            liItem.remove();  // Entfernt das LI aus der UL
        }
    });
}
function bindLiForDisplayOnly(liItem, articleName) {
    const row_ = document.getElementById('row-' + articleName);
    //Speichert den Artikel in der Datenbank /Warenkorb
    liItem.addEventListener("click", () => {
        if (row_.style.display === 'none') {
            row_.style.display = '';
            deleteItem(articleName).then( response => {
                console.log(response.message);
            }).catch(error => {
                console.log(error);
            })
            liItem.remove();  // Entfernt das LI aus der UL
        }
    });
}


function loadWarenkorb() {
    getStateLoggedIn()
        .then(response => {
             user = response.user;
             userInformation = response;
            getArtikelAndShoppingcartByUser(user)
                .then(response => {
                    items = response;
                    shoppingID = items[0].id;
                    if (!items || !items.length) {
                        console.log("Warenkorb ist leer.");
                        return;
                    }

                 const parent = document.getElementById("warenkorbID");

                    for (let i = 0; i < items.length; i++) {

                        if(proofDuplicates(items[i].ab_name)){
                        hideArtikel(items[i].ab_name);
                        const liElement = document.createElement("li");
                        bindLiForDisplayOnly(liElement, items[i].ab_name);
                        liElement.id="loadedItemID_"+items[i].id;
                        const label = document.createElement("label");
                        label.textContent = items[i].ab_name; //

                        liElement.appendChild(label);
                        parent.appendChild(liElement);
                    }}

                   // warenkorb.appendChild(parent);
                })
                .catch(error => {
                    console.error("Fehler beim Abrufen der Artikel:", error);
                });
        })
        .catch(error => {
            console.error("Fehler beim Abrufen des Login-Status:", error);
        });
}


function getArtikelAndShoppingcartByUser(){

    return new Promise((resolve, reject) => {
        const xhr_get = new XMLHttpRequest();
        xhr_get.open("GET", "/api/shoppingcart?ab_name=" + user);
        xhr_get.setRequestHeader('Content-Type', 'application/json');

        xhr_get.onload = ( () =>{
            if(xhr_get.status===200){
                resolve(xhr_get.response);
                console.log(xhr_get.response)
            }
            else {
                reject(xhr_get.statusText);
            }
        });

        xhr_get .onerror =(()=>{
            reject("Netzwerkfehler");
        });

        xhr_get.responseType = "json";
        xhr_get.send();


    })

}

function getStateLoggedIn(){
    //Promise Objekt, um Callback-Hell zu verhindern.
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "/isloggedin", true);
        xhr.responseType = 'json';
        xhr.onload = () => {
            if (xhr.status === 200) {resolve(xhr.response)}
            else reject(xhr.statusText);
        };
        xhr.onerror = () => reject("Netzwerkfehler");
        xhr.send();
    });
}

function storeArtikelInDB(articleName ,user) {
    //Promise Objekt, um Callback-Hell zu verhindern.
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

//Items global, mit allen Daten, was im Warenkorb ist
function deleteItem(artikelname) {
    return new Promise((resolve, reject) => {
        let item;
        if(!item){
            item = items.find(i => i.ab_name === artikelname);

        }else {
            return reject("Fehler");
        }

        if (!item) {
            reject("Artikel nicht gefunden.");
            return;
        }

        const shoppingcartId = item.id;
        const artikelId = item.ab_article_id;

        const xhr_delete = new XMLHttpRequest();
        xhr_delete.open("DELETE", `api/shoppingcart/${shoppingcartId}/articles/${artikelId}`, true);
        xhr_delete.onload = () => {
            if (xhr_delete.status === 200) {
                resolve(xhr_delete.response);
            } else {
                reject(xhr_delete.response);
            }
        };
        xhr_delete.onerror = () => {
            reject("Netzwerkfehler beim Löschen");
        };
        xhr_delete.send();
    });
}


function deleteItemNotLoadedItemsShoppingcart(artikelname) {
    return new Promise((resolve, reject) => {
        getArtikelAndShoppingcartByUser().then((data) => {
            const artikel = data.find(i => i.ab_name === artikelname);
            if (!artikel) {
                reject("Artikel nicht gefunden");
                return;
            }

            const shoppingcartId = artikel.id;
            const artikelId = artikel.ab_article_id;

            const xhr_delete = new XMLHttpRequest();
            xhr_delete.open("DELETE", `api/shoppingcart/${shoppingcartId}/articles/${artikelId}`, true);
            xhr_delete.responseType = "json"; // ← JSON-Antwort automatisch parsen

            xhr_delete.onload = () => {
                if (xhr_delete.status === 200) {
                    resolve(xhr_delete.response); // ← ist jetzt ein Objekt
                } else {
                    reject(xhr_delete.response);
                }
            };

            xhr_delete.onerror = () => {
                reject("Netzwerkfehler beim Löschen");
            };

            xhr_delete.send();
        }).catch((error) => {
            reject("Fehler beim Laden der Artikel: " + error);
        });
    });
}
















function hideArtikel(articleName) {
    console.log(articleName);
        const row = document.getElementById('row-' + articleName);
        if (row) {
            row.style.display = 'none';
        }


}

