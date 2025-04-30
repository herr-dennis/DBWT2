document.addEventListener('DOMContentLoaded', () => {


    fetch('/getCategories')
        .then(response => response.json())
        .then(data => {

            // Mapping der Kategorien
            const categories = data.map(cat => ({ title: cat.ab_name }));

            // Menüstruktur
            const menuItems = [
                { title: 'Home' },
                {
                    title: 'Kategorien',
                    children: categories
                },
                { title: 'Verkaufen' },
                {
                    title: 'Unternehmen',
                    children: [
                        { title: 'Philosophie' },
                        { title: 'Karriere' }
                    ]
                }
            ];

            // Menü in das DOM einfügen
            const navMenu = document.getElementById('navMenu');
            navMenu.innerHTML = '';  // altes Menü löschen
            const menu = createMenu(menuItems);
            navMenu.appendChild(menu);

            // Event-Listener für das "Unternehmen"-Menü setzen
            const menuItem = document.getElementById("menuItem_Unternehmen");
            const menuItemKategorien = document.getElementById('menuItem_Kategorien');
            if(menuItem) {
                const submenus = document.getElementsByClassName("submenu_Unternehmen");
                menuItem.addEventListener('mouseenter', function(event) {
                    event.stopPropagation();
                    for (let submenu of submenus) {
                        submenu.classList.toggle('active');  // Sichtbarkeit umschalten
                    }
                });
                menuItem.addEventListener('mouseleave', () => {
                    for (let submenu of submenus) {
                        submenu.classList.remove('active');
                    }
                });
            }

            if(menuItemKategorien) {
                const submenus = document.getElementsByClassName("submenu_kategorien");
                menuItemKategorien.addEventListener('mouseenter', function(event) {
                    event.stopPropagation();  // Verhindert Klickpropagation
                    for (let submenu of submenus) {
                        submenu.classList.toggle('active');  // Sichtbarkeit umschalten
                    }
                });
                menuItemKategorien.addEventListener('mouseleave', () => {
                    for (let submenu of submenus) {
                        submenu.classList.remove('active');
                    }
                });

            }

        });

    //Bau-Funktion
    function createMenu(items) {
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
            if(item.title === 'Unternehmen'){
                li.id = 'menuItem_Unternehmen';
            }
            if(item.title === 'Kategorien'){
                li.id = 'menuItem_Kategorien';
            }

            const aTag = document.createElement('a');
            aTag.textContent = item.title;
            if(item.title === 'Kategorien'){
                aTag.href = "";
            }
            else {
                aTag.href = "/";
            }
            li.appendChild(aTag);
            // Rekursiv: wenn Kinder vorhanden, Submenü erstellen
            if (item.children) {
                const unterMenu = createMenu(item.children);
                // Spezielles ID für "Unternehmen"
                if(item.title === 'Unternehmen'){
                    unterMenu.classList.add('submenu_Unternehmen');
                }
                if(item.title === 'Kategorien'){
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

});
