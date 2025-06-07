<template>

    <Warenkorb :artikel="warenkorbArtikel" @entferne-artikel="entferneArtikel" />

    <div id="app">
        <form class="search-form">
            <label for="searchInput">Artikel suchen:</label>
            <input id="searchInput" type="text" v-model="searchTerm" />
            <p>Du suchst nach: {{ searchTerm }}</p>
        </form>

        <table class="table" border="1">
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Preis</th>
                <th>Beschreibung</th>
                <th>Ersteller-ID</th>
                <th>Erstelldatum</th>
                <th>Bild</th>
            </tr>
            </thead>
            <tbody class="table__content">
            <template v-for="artikel in artikels" :key="artikel.id">
                <tr>
                    <td>
                        <div class="choice">
                            <label  @click="artikelGeklickt(artikel.ab_name)"  >+</label>
                        </div>
                    </td>
                    <td>{{ artikel.ab_name}}</td>
                    <td>{{ artikel['ab_price']}} </td>
                    <td>{{ artikel['ab_description']}}</td>
                    <td>{{ artikel['created_at']|| "Fehlt" }}</td>
                    <td>{{ artikel['created_at']|| "Fehlt" }}</td>
                    <td>
                        <img :src="`/images/${artikel.id}.jpg`"
                             @error="onImgError" loading="lazy" />

                    </td>

                </tr>
            </template>
            </tbody>

        </table>
    </div>
</template>

<script>

let filterActivate =false;
import Warenkorb from "./warenkorb.vue";
export default {
    components:{
         Warenkorb
    },

    data() {
        return {
            warenkorbArtikel: [],
            searchTerm: "",
            artikels: [],
            allData: []
        };
    },
    methods: {
        fetchArtikels() {
            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.open("GET", "api/articles?search=" + this.searchTerm);
                xhr.setRequestHeader("Accept", "application/json");
                xhr.responseType = "json";
                let fristFive = null;
                xhr.onload = () => {
                    if (xhr.status === 200) {
                        const response = typeof xhr.response === "string"
                            ? JSON.parse(xhr.response)
                            : xhr.response;

                        if(filterActivate) {
                            fristFive = response.slice(0,5);
                        }

                        this.artikels = fristFive || response;
                        this.allData = response;
                        this.artikels.sort((a, b) => a.id - b.id);
                        this.allData.sort((a, b) => a.id - b.id);
                      console.log(response);
                        resolve();
                    } else {
                        reject(new Error("Fehler beim Laden: " + xhr.status));
                    }
                };

                xhr.onerror = () => reject(new Error("Ein Verbindungsfehler ist aufgetreten."));

                xhr.send();
            });

        },
        onImgError(event) {
            event.target.src = '/images/see-no-evil-3444212_640.jpg';
        },
        entferneArtikel(id) {
            this.warenkorbArtikel = this.warenkorbArtikel = this.warenkorbArtikel.filter(a => a !== id);
            // In allData das passende Objekt finden
            const artikelObjekt = this.allData.find(a => a.ab_name === id);

            // Zurück zu artikels hinzufügen (wenn nicht schon drin)
            if (artikelObjekt && !this.artikels.some(a => a.id === artikelObjekt.id)) {
                this.artikels.push(artikelObjekt);
                this.artikels.sort((a, b) => a.id - b.id);
            }

        },
        artikelGeklickt(artikel) {
            this.warenkorbArtikel.push(artikel);// oder das ganze Objekt
        },

    },
   //Reagiert wenn ich searchTerm ändert
    watch: {
        searchTerm(newSearch) {
            if(newSearch.length >= 3) {
                filterActivate =true;
                this.searchTerm = newSearch;
                this.fetchArtikels();
            }
            if(newSearch===""){
                filterActivate=false;
                this.fetchArtikels();
            }
        },
        warenkorbArtikel: {
            handler(newVal) {
                this.artikels = this.artikels.filter(a => {
                    return !newVal.includes(a.ab_name);
                });

            },
            deep: true // wichtig, um Änderungen innerhalbdes Arrays zu erkennen
        }
    },
    //Wenn die Komponente gemouted ist, dann erst Daten laden!
    mounted() {
        this.fetchArtikels()
            .then(() => {
                console.log("Daten sind geladen und this.artikels gesetzt.");
            })
            .catch((err) => {
                console.error(err);
            });

    }
};

</script>

<style  scoped>
.search-form{
    margin-top: 50px;
    padding: 20px;
    display: flex;
    justify-self: left;
    flex-direction:column;
    width: 30%;
    background: #f9f9f9;
}
.search-form label ,p {
    margin: 10px;
    font-weight: bold;
    font-family: 'Bebas Neue', cursive;
    color: #00ffd5;
    text-shadow: -1px -1px 0 #000,
    1px -1px 0 #000,
    -1px 1px 0 #000,
    1px 1px 0 #000;
}
th{
    color: #00ffd5;
    text-shadow: -1px -1px 0 #000,
    1px -1px 0 #000,
    -1px 1px 0 #000,
    1px 1px 0 #000;

}

</style>
