
export function fetchArtikel(searchTerm) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "api/articles?search=" + searchTerm);
        xhr.setRequestHeader("Accept", "application/json");
        xhr.responseType = "json";

        xhr.onload = () => {
            if (xhr.status === 200) {
                resolve(xhr.response);
            } else {
                reject(new Error("Fehler beim Laden: " + xhr.status));
            }
        };
        xhr.onerror = () => reject(new Error("Ein Verbindungsfehler ist aufgetreten."));
        xhr.send();
    });
}
