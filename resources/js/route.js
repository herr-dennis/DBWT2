import {createApp} from "vue";
const route = window.location.pathname.replace(/\/$/, '');
import { ajax } from "./Aufgaben/3-ajax1-static.js";
import { mainPageJs } from "./mainPage.js";
import { createAppM4_Vue_1 } from "./Aufgaben/4-vue1-helloworld.js";
import artikelListe from './VueComponents/artikelSuche.vue';
import artikelEingabe from "./VueComponents/artikelEingabe.vue";
import NaviHeader from "./VueComponents/nav.vue";
import SiteHeader from "./VueComponents/siteheader.vue"
import SiteBody from "./VueComponents/sitebody.vue";
import SiteFooter from "./VueComponents/sitefooter.vue";
import Impressum from "./VueComponents/impressum.vue";
import Maintenance from "./VueComponents/maintenance.vue";


// Seiten ohne Navigation
const excludedRoutes = ['/M4_Vue', '/login', '/register'];

if (!excludedRoutes.includes(route)) {
    const navApp = createApp({
        components: { NaviHeader },
    });
    navApp.mount("#nav-app");
    //createNav();
}
//Meta-Instanz zum laden verschiedener JS-Funktionen.
document.addEventListener('DOMContentLoaded', () => {
    if (route.startsWith('/articles')) {
        const app = createApp(artikelListe);
        app.mount('#app');
        //Warenkorb
        //initialize();
    }

    if(route.startsWith('/newarticle')) {
        const app = createApp(artikelEingabe);
        app.mount('#app');
    }

    if (route.startsWith('/3-ajax1-static')) {
        //ajax();
    }

    if (route.startsWith('/M4_Vue')) {
        createAppM4_Vue_1();
    }

    if (route.startsWith("/newsite")) {
        const app = createApp({
            components: { SiteHeader , NaviHeader , SiteBody , SiteFooter, Impressum , Maintenance},
        });
        app.mount("#app");
    }


    if (route.startsWith('/newarticle')) {
        //artikeleingabe();
    }

    if (route === "/") {
        mainPageJs();
    }
});
