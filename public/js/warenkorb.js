

document.addEventListener('DOMContentLoaded', () => {

    const warenkorbLabel =document.createElement("label")
    warenkorbLabel.classList.add('warenkorb-label')
    warenkorbLabel.textContent = "Warenkorb";

    const warenkorb = document.createElement("ul")
    warenkorb.classList.add("warenkorb");

    warenkorb.appendChild(warenkorbLabel);

    let divs = document.getElementsByClassName('choice');

    for (let i = 0; i < divs.length; i++) {
        divs[i].addEventListener('click', (e) => {
            const insertWarenkorb = document.createElement('li');
            const label = document.createElement('label');
            const hiddenInput = divs[i].querySelector('input[name="id"]');
            label.textContent = hiddenInput.value;

            insertWarenkorb.appendChild(label);
            warenkorb.appendChild(insertWarenkorb);
        });
    }

    document.body.appendChild(warenkorb);  // Beispiel: hänge den Warenkorb ans Ende des Bodys


})
