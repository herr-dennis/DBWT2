import './bootstrap';

import './Aufgaben/3-ajax1-static.js';
import './Aufgaben/artikeleingabe.js';
import './cookieCheck.js';
import './Aufgaben/warenkorb.js';
import './Aufgaben/data.js';
import './mainPage.js';
import './Aufgaben/navObject.js';
import './route.js';
import './Aufgaben/4-vue1-helloworld.js';
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
import './ulities/apiUnities.js'

window.Pusher = Pusher

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
})
