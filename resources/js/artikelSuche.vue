<template>
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
            <tbody>
            <template v-for="artikel in artikels" :key="artikel.id">
                <tr :id="'row-'+artikel.ab_name">
                    <td>
                        <div class="choice">
                            <input type="hidden" :value="artikel.ab_name" />
                            <label>+</label>
                        </div>
                    </td>
                    <td>{{ artikel.ab_name}}</td>
                    <td>{{ artikel['ab_price']}} </td>
                    <td>{{ artikel['ab_description']}}</td>
                    <td>{{ artikel['created_at']|| "Fehlt" }}</td>
                    <td>{{ artikel['created_at']|| "Fehlt" }}</td>
                    <td>
                        <img :src="`/images/${artikel.id}.jpg`"
                             @error="onImgError" />

                    </td>


                </tr>
            </template>
            </tbody>

        </table>
    </div>
</template>

<script>

let filterActivate =false;

export default {

    data() {
        return {
            searchTerm: "",
            artikels: [],
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
        }

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
