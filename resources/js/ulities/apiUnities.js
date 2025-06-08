export function getStateLoggedIn() {
    return fetch('/login')
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText);
            }
            return response.json(); // gibt ein Promise zurück
        });
}

export function getArtikelAndShoppingCartByUser(user) {
    return fetch('/api/shoppingcart?ab_name=' + user).then(response => {
        if (!response.ok) {
            throw new Error(response.statusText);
        }
        return response.json();
    })
}

export function getUsersArtikel(userID) {
    return fetch(`/api/user/${userID}/articles`)
        .then(response => response.json()).catch(error => {
            return error.json();
        });
}

export function storeArtikelInDB(artikelName, user) {

    return fetch('/api/shoppingcart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ab_name: user, article_name: artikelName})
    }).then(response => {
        if (!response.ok) {
            throw new Error(response.statusText);
        }
        return response.json();
    })

}

export function sendMessageToServer(message, id = -1) {

    let tmp = message["msg"];

    let data = {
        msg: tmp,
        id: id,
    }

    fetch('/api/send-message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            console.log('Server-Antwort:', data)
        })
        .catch(err => console.error('Fehler beim Senden:', err));
}

export function listenToBroadcaster(callback) {
    Echo.channel('chat').listen('.new.message', (e) => {
        callback(e);
    });
}

/**
 * Normaler Callback, Promise würde nur einmal getriggert
 * @param callback Funk
 */
export function listenToBroadcasterWartung(callback) {
    Echo.channel('wartungsarbeiten').listen('.new.message', (e) => {
        callback(e);
    });
}

export function listenToBroadcasterArtikelverkauft(callback) {
    Echo.channel('chat')
        .listen('.artikelverkauft.message', (e) => {
            callback(e);
        })
        .listen('.angebote.message', (e) => {
            callback(e);
        });
}

export function sendToBroadcaster_AngeboteChanel(msg) {

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    if (!msg) {
        msg = {
            msg: "Baum"
        };
    }
    fetch("/send-angebot", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify(msg)
    }).then(resolve => {
        //Zu Antwort zu JSON formatieren
        resolve.json();
        //Wieder ein Promise Objekt erstellen
    }).then(data => {
        console.log("Antwort vom Server:", data);
    }).catch(error => {
        console.log("Fehler" + error)
    })
}

window.listenToBroadcaster = listenToBroadcaster;
window.sendMessageToServer = sendMessageToServer;
window.listenToBroadcasterWartung = listenToBroadcasterWartung;
window.listenToBroadcasterArtikelverkauft = listenToBroadcasterArtikelverkauft;
window.sendToBroadcaster_AngeboteChanel = sendToBroadcaster_AngeboteChanel;
