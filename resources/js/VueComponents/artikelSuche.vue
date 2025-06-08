<template>

    <Warenkorb :artikel="warenkorbArtikel" @entferne-artikel="entferneArtikel"/>

    <div id="app">
        <form class="search-form">
            <label for="searchInput">Artikel suchen:</label>
            <input id="searchInput" type="text" v-model="searchTerm"/>
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
                <tr :class="'table__tr--angebot_' + artikel.id">
                    <td>
                        <div class="choice">
                            <label @click="artikelGeklickt(artikel.ab_name)">+</label>
                        </div>
                    </td>
                    <td>{{ artikel.ab_name }}</td>
                    <td>{{ artikel['ab_price'] }}</td>
                    <td>{{ artikel['ab_description'] }}</td>
                    <td>{{ artikel['created_at'] || "Fehlt" }}</td>
                    <td>{{ artikel['created_at'] || "Fehlt" }}</td>
                    <td>
                        <img :src="`/images/${artikel.id}.jpg`"
                             @error="onImgError" loading="lazy"/>

                    </td>
                    <td v-if="isArtikelFromUser(artikel.ab_name)" @click="broadCastAngebot(artikel.ab_name,artikel.id)"
                        class="table__pfeil--hover" title="Upgrade zum Angebot">
                        <span>&#8593;</span>
                    </td>
                </tr>
            </template>
            </tbody>

        </table>
    </div>
</template>

<script>

import {getUsersArtikel} from "../ulities/apiUnities.js";

let filterActivate = false;
import Warenkorb from "./warenkorb.vue";

export default {
    components: {
        Warenkorb
    },
    props: {
        userId: {
            type: Number,
            required: true
        }
    },

    data() {
        return {
            warenkorbArtikel: [],
            searchTerm: "",
            artikels: [],
            allData: [],
            articlesByUser: []

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

                        if (filterActivate) {
                            fristFive = response.slice(0, 5);
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
        isArtikelFromUser(artikelname) {
            console.log(this.articlesByUser)
            return this.articlesByUser.some(article => article.ab_name === artikelname);

        },
        broadCastAngebot(angebot, artikelId) {
            let tmp = "!!!! Neustes Angebot " + angebot + " !!!!" || "";
            sendToBroadcaster_AngeboteChanel({msg: tmp});

            const selector = `.table__tr--angebot_${artikelId}`;
            const trElement = document.querySelector(selector);

            if (trElement) {
                trElement.classList.add('feuer-rahmen');

            } else {
                console.warn(`Kein Element gefunden für Selector: ${selector}`);
            }
        }
    },
    //Reagiert wenn ich searchTerm ändert
    watch: {
        searchTerm(newSearch) {
            if (newSearch.length >= 3) {
                filterActivate = true;
                this.searchTerm = newSearch;
                this.fetchArtikels();
            }
            if (newSearch === "") {
                filterActivate = false;
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
        if (this.userId > 0) {
            getUsersArtikel(this.userId).then(response => {
                this.articlesByUser = response;
            }).catch(console.error);

            console.log("Benutzer ist eingeloggt.");
        }
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

<style scoped>
.search-form {
    margin-top: 50px;
    padding: 20px;
    display: flex;
    justify-self: left;
    flex-direction: column;
    width: 30%;
    background: #f9f9f9;
}

.search-form label, p {
    margin: 10px;
    font-weight: bold;
    font-family: 'Bebas Neue', cursive;
    color: #00ffd5;
    text-shadow: -1px -1px 0 #000,
    1px -1px 0 #000,
    -1px 1px 0 #000,
    1px 1px 0 #000;
}

th {
    color: #00ffd5;
    text-shadow: -1px -1px 0 #000,
    1px -1px 0 #000,
    -1px 1px 0 #000,
    1px 1px 0 #000;

}

.table__pfeil--hover:hover {
    cursor: pointer;
}

.feuer-rahmen {
    border: 3px solid red; /* oder ein „feuriger“ Effekt, z.B. Glühen */
    box-shadow: 0 0 8px 2px rgba(255, 69, 0, 0.8);
    transition: border 0.3s ease;
}

</style>
