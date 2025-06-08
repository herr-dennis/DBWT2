<template>


    <template v-if="currentComponent === 'startseite'">
        <!-- STARTSEITE-INHALT -->



        <h1 class="defaultH2" >Abalo</h1>

    <div class="topcase">
        <p class="topcase__p">Neueste Artikel:</p>
        <div class="topcase__content">
            <p>{{ currentNameDisplay+" "+currentPrice+"€" }}</p>
            <img :src="currentImageSrc" @error="onImgError"  alt="Bild_SiteBody_Topcase"/>
        </div>


        <div class="textcontainer" >
            <h1 class="textcontainer__h1" >Lorem ipsum dolor sit amet consectetuer adipiscing
                elit</h1>

            <p  class="textcontainer__p">Lorem ipsum dolor sit amet, consectetuer adipiscing
                elit. Aenean commodo ligula eget dolor. Aenean massa
                <strong>strong</strong>. Cum sociis natoque penatibus
                et magnis dis parturient montes, nascetur ridiculus<br>
                mus. Donec quam felis, ultricies nec, pellentesque
                eu, pretium quis, sem. Nulla consequat massa quis<br>
                enim. Donec pede justo, fringilla vel, aliquet nec,<br>
                vulputate eget, arcu. In enim justo, rhoncus ut,
                imperdiet a, venenatis vitae, justo. Nullam dictum
                felis eu pede <a class="external ext" href="#">link</a>
                mollis pretium. Integer tincidunt. Cras dapibus.
                Vivamus elementum semper nisi. Aenean vulputate
                eleifend tellus. Aenean leo ligula, porttitor eu,
                consequat vitae, eleifend ac, enim. Aliquam lorem ante, <br>
                dapibus in, viverra quis, feugiat a, tellus. Phasellus
                viverra nulla ut metus varius laoreet. Quisque rutrum.
                Aenean imperdiet. Etiam ultricies nisi vel augue.
                et magnis dis parturient montes, nascetur ridiculus
                mus. Donec quam felis, ultricies nec, pellentesque<br>
                eu, pretium quis, sem. Nulla consequat massa quis
                enim. Donec pede justo, fringilla vel, aliquet nec,<br><br>
                vulputate eget, arcu. In enim justo, rhoncus ut,
                imperdiet a, venenatis vitae, justo. Nullam dictum
                felis eu pede <a class="external ext" href="#">link</a>
                mollis pretium. Integer tincidunt. Cras dapibus.
                Vivamus elementum semper nisi. Aenean vulputate
                eleifend tellus. Aenean leo ligula, porttitor eu,
                consequat vitae, eleifend ac, enim. Aliquam lorem ante,<br><br>
                dapibus in, viverra quis, feugiat a, tellus. Phasellus
                viverra nulla ut metus varius laoreet. Quisque rutrum.
                Aenean imperdiet. Etiam ultricies nisi vel augue.
                Curabitur ullamcorper ultricies nisi.</p>

            <h1 class="textcontainer__h1" >Lorem ipsum dolor sit amet consectetuer adipiscing
                elit</h1>
        </div>
    </div>

          <calendar-box></calendar-box>

</template>
    <!-- :is="XX" rendert die Componente die drin steht. -->
    <component v-else :is="currentComponent" :user-id="userID" />


</template>

<script>
import { fetchArtikel } from "../fetchArtikel.js";
import Impressum from './impressum.vue';
import ArtikelSuche from "./artikelSuche.vue";
import CalendarBox from './calender.vue';
import {getStateLoggedIn} from "../ulities/apiUnities.js";
export default {

    components: {
        impressum: Impressum,
        artikelsuche: ArtikelSuche,
        calendarBox: CalendarBox,
    },

    data() {
        return {
            newArticles: [],
            currentArtikel: null,
            currentNameDisplay: "Loading",
            currentPrice : 0,
            currentImageSrc: "/images/see-no-evil-3444212_640.jpg",
            currentComponent: 'startseite',
            userID : -1
        };
    },

    methods: {
        onImgError(event) {
            event.target.src = "/images/see-no-evil-3444212_640.jpg";
        },

        nextArtikel() {
            if (this.newArticles.length === 0) {
                this.currentNameDisplay = "Keine Artikel gefunden";
                this.currentImageSrc = "/images/see-no-evil-3444212_640.jpg";
                return;
            }

            const randomIndex = Math.floor(Math.random() * this.newArticles.length);
            this.currentArtikel = this.newArticles[randomIndex];

            this.currentNameDisplay = this.currentArtikel.ab_name || "Kein Name";
            this.currentPrice =this.currentArtikel.ab_price || "--"

            this.currentImageSrc = `/images/${this.currentArtikel.id}.jpg`;
        },

        switchComponent(name) {
            this.currentComponent = name;
        },
    },

    mounted() {

        getStateLoggedIn("visitor").then(resolve=>{
            if(resolve){
                this.userID=resolve["id"];
            }
        })

        fetchArtikel("")
            .then((response) => {
                this.newArticles = response;

                setInterval(() => {
                    this.nextArtikel();
                }, 2000);
            })
            .catch(console.error);
    }
};
</script>


<style scoped>

.defaultH2{
    font-weight: bold;
    font-size: 50px;
    color: #00ffd5;
    text-shadow:
        -1px -1px 0 #000,
        1px -1px 0 #000,
        -1px  1px 0 #000,
        1px  1px 0 #000;

}

.topcase__p {
    text-align: center;
    font-size: 2rem;
    font-weight: 700;
    color: #00ffd5;
    text-shadow: 0 0 8px #00ffd5aa;
    margin-bottom: 1rem;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.topcase__content {
    padding: 20px;
    border: 2px solid #00ffd5;
    border-radius: 12px;
    max-width: 250px;
    margin: 0 auto;
    background-color: #4a5568;
    box-shadow: 0 0 10px #00ffd533;
    transition: box-shadow 0.3s ease-in-out;

    &:hover {
        box-shadow: 0 0 25px #00ffd5ee;
    }

    p {
        text-align: center;
        color: #00ffd5;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 12px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        text-shadow: 0 0 6px #00ffd5cc;
    }

    img {
        display: block;
        margin: 0 auto;
        width: 200px;
        height: 200px;
        border-radius: 10px;
        border: 1.5px solid #00ffd5;
        box-shadow: 0 0 12px #00ffd5bb;
        object-fit: cover;
        transition: transform 0.4s ease;

        &:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px #00ffd5ee;
        }
    }
}


.textcontainer {
    width: 100%;
    margin: 20px;
    text-align: center;
    border: 2px solid #00ffd5;
    background-color: #4a5568;
}

/* Selektor für das p-Element innerhalb der .textcontainer */
.textcontainer__p {
    color: #f0f0f0;
}

/* Optional: Stil für die H1-Titel */
.textcontainer__h1 {
    color: #00ffd5;
    font-size: 1.8rem;
    text-shadow: 0 0 5px #00ffd5aa;
    margin-top: 20px;
}



</style>
