export function createNav() {
    document.addEventListener("DOMContentLoaded", () => {

        class Menu {

            constructor() {
                this.categories = [];
                this.menuItems = [];
            }

            init() {
                this.getKategories((response) => {
                    if (!response.error) {
                        this.categories = response.map(cat => ({
                            title: cat.ab_name
                        }));
                        this.createPattern();
                        this.buildMenu();
                        this.createMenu(this.menuItems);
                    } else {
                        console.error("Fehler beim Laden der Kategorien:", response.error);
                    }
                });
            }

            createPattern() {
                this.menuItems = [
                    {title: 'Home'},
                    {
                        title: 'Kategorien',
                        children: this.categories
                    },
                    {title: 'Verkaufen'},
                    {
                        title: 'Unternehmen',
                        children: [
                            {title: 'Philosophie'},
                            {title: 'Karriere'}
                        ]
                    },
                    {title: 'Einloggen'}
                ];

                console.log("Menü gebaut mit:", this.menuItems);
            }

            buildMenu() {
                const navMenu = document.getElementById('navMenu');
                navMenu.innerHTML = '';
                const menu = this.createMenu(this.menuItems);
                navMenu.appendChild(menu);

                const menuItem = document.getElementById("menuItem_Unternehmen");
                const menuItemKategorien = document.getElementById('menuItem_Kategorien');

                if (menuItem) {
                    const submenus = document.getElementsByClassName("submenu_Unternehmen");
                    menuItem.addEventListener('mouseenter', function (event) {
                        event.stopPropagation();
                        for (let submenu of submenus) {
                            submenu.classList.toggle('active');
                        }
                    });
                    menuItem.addEventListener('mouseleave', () => {
                        for (let submenu of submenus) {
                            submenu.classList.remove('active');
                        }
                    });
                }

                if (menuItemKategorien) {

                    const submenus = document.querySelectorAll(".menu-container.submenu_Kategorien");

                    menuItemKategorien.addEventListener('mouseenter', function (event) {
                        event.stopPropagation();
                        for (let submenu of submenus) {
                            submenu.classList.toggle('active');
                        }
                    });
                    menuItemKategorien.addEventListener('mouseleave', () => {
                        for (let submenu of submenus) {
                            submenu.classList.remove('active');
                        }
                    });
                }
            }

            createMenu(items) {
                const container = document.createElement('div');
                container.className = 'menu-container';

                // Mobile Button
                const btn = document.createElement("button");
                btn.className = "menu-toggle-btn";
                btn.innerHTML = "☰";
                container.appendChild(btn);

                // Hauptliste
                const ul = document.createElement('ul');
                ul.className = "main-menu";

                items.forEach(item => {
                    const li = document.createElement('li');

                    // Spezielles ID für "Unternehmen"
                    if (item.title === 'Unternehmen') {
                        li.id = 'menuItem_Unternehmen';
                    }
                    if (item.title === 'Kategorien') {
                        li.id = 'menuItem_Kategorien';
                    }


                    const aTag = document.createElement('a');
                    aTag.textContent = item.title;
                    if (item.title === 'Kategorien') {
                        aTag.href = "";
                    } else {
                        aTag.href = "/";
                    }
                    //Logik für der Einloggen, ruft auth() auf für die Überprüfung
                    if (item.title === "Einloggen") {
                        //Klassischer Fall der Arrow-Funktion.
                        // Ohne => wäre this.auth nicht möglich.
                        // Dann sonst da sonst der Callback als Objekt referenziert wird.
                        aTag.addEventListener("click", (event) => {
                            event.preventDefault();
                            this.auth(function (response) {
                                if (response.error) {
                                    console.error("Fehler beim Login:", response.error);
                                } else {
                                    console.log("Eingeloggt als:", response.user);
                                }
                            });

                        });

                        this.auth(function (response) {
                            console.log("Aufruf auth ");
                            if (response.auth_ === "true") {
                                aTag.textContent = "Eingeloggt als " + response.user;
                            }
                        })


                    }
                    li.appendChild(aTag);

                    // Rekursiv: wenn Kinder vorhanden, Submenü erstellen
                    if (item.children) {
                        const unterMenu = this.createMenu(item.children);
                        // Spezielles ID für "Unternehmen"
                        if (item.title === 'Unternehmen') {
                            unterMenu.classList.add('submenu_Unternehmen');
                        }
                        if (item.title === 'Kategorien') {
                            unterMenu.classList.add('submenu_Kategorien');
                        }

                        li.appendChild(unterMenu);
                    }

                    ul.appendChild(li);
                });

                container.appendChild(ul);

                // Mobile Ansicht Toggle für Sichtbarkeit
                btn.addEventListener("click", () => {
                    ul.classList.toggle("visible");
                });

                return container;
            }

            getKategories(callback) {
                const xhr_kate = new XMLHttpRequest();
                xhr_kate.open("GET", "/getCategories", true);
                xhr_kate.responseType = 'json';
                xhr_kate.setRequestHeader("Content-Type", "application/json");

                xhr_kate.onreadystatechange = function () {
                    if (xhr_kate.readyState === 4) {
                        if (xhr_kate.status === 200) {
                            callback(xhr_kate.response);
                        } else {
                            callback({error: xhr_kate.statusText});
                        }
                    }
                };

                xhr_kate.onerror = function () {
                    callback({error: "Netzwerkfehler"});
                };

                xhr_kate.send();
            }

            auth(callback) {
                const xhr_auth = new XMLHttpRequest();
                xhr_auth.open("GET", "/login", true);
                xhr_auth.responseType = 'json';
                xhr_auth.setRequestHeader("Content-Type", "application/json");

                //Klassischer Fall der Arrow-Funktion.
                // Ohne => wäre this.showAdmin() nicht möglich.
                // Dann sonst da sonst der Callback als Objekt referenziert wird.
                xhr_auth.onreadystatechange = () => {
                    if (xhr_auth.readyState === 4) {
                        if (xhr_auth.status === 200) {
                            callback(xhr_auth.response);
                            this.showAdmin();
                        } else {
                            console.log("Fehler beim Login:", xhr_auth.response);
                            callback({error: xhr_auth.statusText});
                        }
                    }
                };

                xhr_auth.onerror = function () {
                    callback({error: "Netzwerkfehler"});
                };

                xhr_auth.send();
            }


            showAdmin() {
                const adminBtn = document.getElementById("adminBtn");

                if (adminBtn) {
                    adminBtn.style.display = "block";
                }


            }

        }


        const nav = new Menu();
        nav.init();
    });
}
