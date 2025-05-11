document.addEventListener('DOMContentLoaded', function() {
    const form = document.createElement("form");
    const input = document.createElement("input");
    const submit = document.createElement("input", );
    const labelForm = document.createElement("label");
    const textArea = document.createElement("textarea");
    const priceInput = document.createElement("input");


    form.setAttribute("method", "POST");
    form.setAttribute("action", "articles");
    form.setAttribute("name", "formeNewArticle");
    form.classList.add("form");

    labelForm.textContent = "Neuen Artikel einfügen"

    input.setAttribute("type", "text");
    input.placeholder = "Artikelname";
    input.setAttribute("name", "name");

    priceInput.setAttribute("type", "number");
    priceInput.setAttribute( "name","price");


    submit.setAttribute("value", "Speichern");
    submit.setAttribute("type", "submit");

    textArea.textContent = "Beschreibung";
    textArea.setAttribute("name", "beschreibung");
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
    mainTag.appendChild(form);


    priceInput.addEventListener("change", function(event) {
        let price = event.target.value;

        if(price < 0){
            alert("Preis nicht akzeptiert!")
            submit.disabled=true;
        }else{
            submit.disabled=false;
        }

    })
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
        console.log(form)
        if(valid) {
            // Wenn alle Felder ok sind
            form.submit();  // Formular absenden
        }
    });

});
