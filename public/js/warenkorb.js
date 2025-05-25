
document.addEventListener('DOMContentLoaded', function() {
    var container = document.createElement('div');
    container.id = 'warenkorb-container';
    container.innerHTML = '<h3>Warenkorb</h3>';
    var ul = document.createElement('ul');
    ul.id = 'warenkorbID';
    ul.classList.add('warenkorb');
    container.appendChild(ul);
    document.body.appendChild(container);

    var choices = document.getElementsByClassName('choice');
    for (var i = 0; i < choices.length; i++) {
        (function(div) {
            div.addEventListener('click', function() {
                var name = div.querySelector('input[name="id"]').value;
                if (!proofDuplicates(name)) return;
                hideRowByName(name);
                addItemToList(name, null);
            });
        })(choices[i]);
    }

    getStateLoggedIn().then(function(resp) {
        if (resp.auth_ === 'true') {
            loadWarenkorb(resp.user);
        }
    });
});

function addItemToList(text, articleId) {
    var ul = document.getElementById('warenkorbID');
    var li = document.createElement('li');
    li.textContent = text;
    if (articleId !== null) {
        li.setAttribute('data-article-id', articleId);
    }
    li.addEventListener('click', function() {
        var id = li.getAttribute('data-article-id');
        if (id) {
            deleteFromCart(id);
            showRow(id);
        }
        li.remove();
    });
    ul.appendChild(li);
    if (articleId === null) {
        storeArtikelInDB(text, li);
    }
}

function proofDuplicates(name) {
    var ul = document.getElementById('warenkorbID');
    for (var i = 0; i < ul.children.length; i++) {
        if (ul.children[i].textContent === name) return false;
    }
    return true;
}

function hideRowByName(name) {
    var rows = document.querySelectorAll('tr[id^="row-"]');
    for (var i = 0; i < rows.length; i++) {
        if (rows[i].cells[1].textContent.trim() === name) {
            rows[i].style.display = 'none';
            return;
        }
    }
}

function showRow(id) {
    var row = document.getElementById('row-' + id);
    if (row) row.style.display = '';
}

function getStateLoggedIn() {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/isloggedin', true);
        xhr.responseType = 'json';
        xhr.onload = function() {
            xhr.status === 200 ? resolve(xhr.response) : reject(xhr.statusText);
        };
        xhr.onerror = function() { reject('Netzwerkfehler'); };
        xhr.send();
    });
}

function storeArtikelInDB(articleName, li) {
    getStateLoggedIn().then(function(resp) {
        if (resp.auth_ !== 'true') return;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/shoppingcart', true);
        xhr.responseType = 'json';
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function() {
            if (xhr.status === 200) {
                var data = xhr.response;
                li.setAttribute('data-article-id', data.article_id || data.id);
            }
        };
        xhr.send(JSON.stringify({
            ab_name:      resp.user,
            article_name: articleName
        }));
    });
}

function loadWarenkorb(userName) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/shoppingcart?ab_name=' + encodeURIComponent(userName), true);
    xhr.responseType = 'json';
    xhr.onload = function() {
        if (xhr.status === 200) {
            xhr.response.forEach(function(item) {
                hideRowByName(item.ab_name);
                addItemToList(item.ab_name, item.id);
            });
        }
    };
    xhr.send();
}

function deleteFromCart(articleId) {
    var xhr = new XMLHttpRequest();
    xhr.open('DELETE', '/api/shoppingcart/1/articles/' + articleId, true);
    xhr.send();
}
