

const route = window.location.pathname;

console.log("route", route);

import { initialize} from "./warenkorb.js";
import {ajax} from "./3-ajax1-static.js";
import {artikeleingabe} from "./artikeleingabe.js";
import {mainPageJs} from "./mainPage.js";

if (route.startsWith('/articles')) {
    document.addEventListener('DOMContentLoaded', initialize);
}

if(route.startsWith('/3-ajax1-static')) {

    document.addEventListener('DOMContentLoaded', ajax);
}


if(route.startsWith('/newarticle')) {
    document.addEventListener('DOMContentLoaded', artikeleingabe);
}

if(route ==="/") {
    document.addEventListener('DOMContentLoaded', mainPageJs);
}
