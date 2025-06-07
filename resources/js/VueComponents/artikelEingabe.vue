
<template>

     <p class="defaultContainer" >Möchten Sie ihren Artikel bei uns verkaufen? Wir können Sie ihren Artikel einstellen</p>
    <form class="form" id="formEingabe">
        <label for="inputArtikel">Name des Artikels</label>
        <input id="inputArtikel" type="text" name="inputEingabe" autocomplete="off" />

        <label for="inputPreis">Preis des Artikels</label>
        <input id="inputPreis" type="number" name="inputPreis" autocomplete="off" />

        <label for="inputBeschreibung">Ihre Beschreibung</label>
        <textarea id="inputBeschreibung" rows="5" cols="30"></textarea>

        <input type="submit" id="submitBtn" value="Einpflegen" />
    </form>
    <label id="alertText"></label>
</template>

<script>
export default {
    mounted() {
        const priceInput = document.getElementById('inputPreis');
        const btn = document.getElementById('submitBtn');
        const inputArtikel = document.getElementById('inputArtikel');
        const inputPreis = document.getElementById('inputPreis');
        const inputBeschreibungId = document.getElementById('inputBeschreibung');
        const alertText = document.getElementById('alertText');

        let valid = true;

        if (inputArtikel === null || inputPreis === null || inputBeschreibungId === null) {
            valid = false;
        } else {
            priceInput.addEventListener('change', function (event) {
                let price = event.target.value;

                if (price < 1) {
                    alert('Preis nicht akzeptiert!');
                    btn.disabled = true;
                } else {
                    btn.disabled = false;
                }
            });

            if (btn) {

                btn.addEventListener('click', (event) => {
                    event.preventDefault();

                    if (inputArtikel.value.trim() === '') {
                        alert('Name eingeben!');
                        inputArtikel.classList = 'alert';
                        valid = false;
                    }
                    if (inputPreis.value.trim() === '') {
                        alert('Preis nicht gültig');
                        inputPreis.classList = 'alert';
                        valid = false;
                    }

                    if (valid) {
                        sendForm();
                        document.getElementById('formEingabe').reset();
                        inputArtikel.classList.remove('alert');
                        inputPreis.classList.remove('alert');

                    }
                });
            }

            function sendForm() {
                //const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let data = getValuesFromForm();

                let xhr = new XMLHttpRequest();
                xhr.open('POST', '/api/articles', true);
                xhr.responseType = 'json';
                //xhr.setRequestHeader('X-CSRF-TOKEN', token);
                xhr.setRequestHeader('Content-Type', 'application/json');

                xhr.send(JSON.stringify(data));

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            console.log('✅ Erfolg:', xhr.response.message);
                            alertText.textContent = xhr.response.message;
                            alertText.classList = 'msg';
                        } else {
                            console.error('❌ Fehler:', xhr.response.error);
                        }
                    }
                };

                xhr.onerror = function () {
                    console.error('Ein Netzwerkfehler ist aufgetreten oder der Server ist nicht erreichbar.');
                };
            }

            function getValuesFromForm() {
                return {
                    name: inputArtikel.value,
                    preis: inputPreis.value,
                    beschreibung: inputBeschreibungId.value,
                };
            }
        }
    },
};
</script>
<style>


.form {
    padding: 20px;
    background: #e1dfdf;
    display: flex;
    flex-direction: column;
    width: 70%;
    margin: 30px;
    max-width: 400px;
}

.form label {
    border-radius: 10%;
    font-weight: bold;
    padding: 15px;
    background: rgba(255, 255, 255, 0.9);
    margin-bottom: 10px;
}

.form input,
textarea {
    width: 100%;
    max-width: 400px;
    margin: 10px 0;
    padding: 8px;
    box-sizing: border-box;
}
</style>
