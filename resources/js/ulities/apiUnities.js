 export function apiUnities(user) {
    return fetch('/isloggedin')
        .then(response => {
            if (!response.ok) {
                throw new Error(response.statusText);
            }
            return response.json(); // gibt ein Promise zurück
        });
}


 export function getArtikelAndShoppingCartByUser(user) {
    return fetch('/api/shoppingcart?ab_name=' + user).then(response =>{
              if (!response.ok) {
                  throw new Error(response.statusText);
              }
              return response.json();
    })
}

export function storeArtikelInDB(artikelName, user){

    return fetch('/api/shoppingcart',{
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ ab_name: user,  article_name: artikelName })
    }).then(response =>{
        if (!response.ok) {
            throw new Error(response.statusText);
        }
        return response.json();
    })

}
