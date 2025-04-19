var data = {
    'produkte': [
        { name: 'Ritterburg', preis: 59.99, kategorie: 1, anzahl: 3 },
        { name: 'Gartenschlau 10m', preis: 6.50, kategorie: 2, anzahl: 5 },
        { name: 'Robomaster' ,preis: 199.99, kategorie: 1, anzahl: 2 },
        { name: 'Pool 250x400', preis: 250, kategorie: 2, anzahl: 8 },
        { name: 'Rasenmähroboter', preis: 380.95, kategorie: 2, anzahl: 4 },
        { name: 'Prinzessinnenschloss', preis: 59.99, kategorie: 1, anzahl: 5 }
    ],
    'kategorien': [
        { id: 1, name: 'Spielzeug' },
        { id: 2, name: 'Garten' }
    ]
};

/**
 * Note: Man könnte auch direkt das Objekt data übergeben!
 * Dann würde man in der Funktion, das Produktarray deklarieren und dann darauf arbeiten
 */

function getMaxPreis(produkteArray) {
    if (!produkteArray || !Array.isArray(produkteArray) || produkteArray.length === 0) {
        console.log("Keine gültige Produktliste!");
        return -1;
    }

    let maxPreis = -1;
    let name = "";

    for (let i = 0; i < produkteArray.length; i++) {
        if (produkteArray[i].preis > maxPreis) {
            maxPreis = produkteArray[i].preis;
            name = produkteArray[i].name;
        }
    }

    return {
        name: name,
        preis: maxPreis
    };
}


function getMinPreisProdukt(produkteArray) {
    if (!produkteArray || !Array.isArray(produkteArray) || produkteArray.length === 0) {
        console.log("Keine gültige Produktliste!");
        return -1;
    }

    let ob;
    let min_preis =  Infinity;
    produkteArray.forEach((item) =>{
        if(item.preis < min_preis) {
            min_preis = item.preis;
            ob = item;
        }

    })

return ob;

}


function getPreisSum(produkteArray){
    if (!produkteArray || !Array.isArray(produkteArray) || produkteArray.length === 0) {
        console.log("Keine gültige Produktliste!");
        return -1;
    }
    let sum =0;
    produkteArray.forEach((item) =>{
        sum += item.preis;
    })

    return sum;
}

function getGesamtWert(produkteArray){
    if (!produkteArray || !Array.isArray(produkteArray) || produkteArray.length === 0) {
        console.log("Keine gültige Produktliste!");
        return -1;
    }
    let sum = 0;

    produkteArray.forEach((item) =>{
        sum += item.preis* item.anzahl;
    })

    return sum;

}

function getAnzahlProdukteOfKategorie(data, kategorie){

    let produkteArray = data.produkte;
    if (!produkteArray || !Array.isArray(produkteArray) || produkteArray.length === 0) {
        console.log("Keine gültige Produktliste!");
        return -1;
    }

    let anzahlKategorie= 0   ;
    produkteArray.forEach((item) =>{
        if(item.kategorie === kategorie){
            anzahlKategorie++;
        }
    })


 return anzahlKategorie;
}



let p_max = getMaxPreis(data.produkte);
let p_min= getMinPreisProdukt(data.produkte);
let sum = getPreisSum(data.produkte);
let gesamtSum =getGesamtWert(data.produkte);
let anzahlKate = getAnzahlProdukteOfKategorie(data, 2);
console.log("Preis max ist :" + JSON.stringify(p_max));
console.log("Preis min ist :"+ JSON.stringify(p_min));
console.log("Summe"+sum);
console.log("Gesamtsumme:"+gesamtSum);
console.log("Anzahl einer Kategorie(2):"+anzahlKate)
