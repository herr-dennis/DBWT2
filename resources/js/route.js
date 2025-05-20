const route = window.location.pathname.replace(/\/$/, '');

console.log("route", route);

import { initialize } from "./warenkorb.js";
import { ajax } from "./3-ajax1-static.js";
import { artikeleingabe } from "./artikeleingabe.js";
import { mainPageJs } from "./mainPage.js";
import { createAppM4_Vue_1 } from "./Aufgaben/4-vue1-helloworld.js";
import { createNav } from "./navObject.js";

// Seiten ohne Navigation
const excludedRoutes = ['/M4_Vue', '/login', '/register'];

if (!excludedRoutes.includes(route)) {
    createNav();
}
//Meta-Instanz zum laden verschiedener JS-Funktionen.
document.addEventListener('DOMContentLoaded', () => {
    if (route.startsWith('/articles')) {
        initialize();
    }

    if (route.startsWith('/3-ajax1-static')) {
        ajax();
    }

    if (route.startsWith('/M4_Vue')) {
        createAppM4_Vue_1();
    }

    if (route.startsWith('/newarticle')) {
        artikeleingabe();
    }

    if (route === "/") {
        mainPageJs();
    }
});
