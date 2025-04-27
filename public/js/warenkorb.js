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
            //Logik für das Entfernen des Artikel aus dem Warenkorb
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

    liItem.addEventListener("click", () => {
        if (row.style.display === 'none') {
            row.style.display = '';
            liItem.remove();  // Entfernt das LI aus der UL
        }
    });
}


function hideArtikel(articleName) {
    console.log(articleName);
        const row = document.getElementById('row-' + articleName);
        if (row) {
            row.style.display = 'none';
        }
}

