
    document.addEventListener("DOMContentLoaded", function () {
        // Banner nur anzeigen, wenn noch keine Entscheidung getroffen wurde
        /* if (!localStorage.getItem("cookiesAccepted")) {
             document.getElementById("cookie-banner").style.display = "block";
         }*/

        if (!document.cookie.includes("technicalCookiesAccepted")) {
            const check = document.getElementById("cookie-banner");
            if (check) {
                check.style.display = "block";
            }
        }
    });

    const acceptBtn = document.getElementById("acceptCookies");

    if (acceptBtn !== null) {
        acceptBtn.addEventListener("click", function () {
            acceptCookies();
        });
    }

    const technicalBtn = document.getElementById("acceptTechnicalCookies");

    if (technicalBtn) {
        technicalBtn.addEventListener("click", acceptTechnicalCookies);
    }


// Alle Cookies akzeptieren
    function acceptCookies() {
        //Lokal im Browser
        localStorage.setItem("cookiesAccepted", "all");
        //Cookie für Backend-Verarbeitung -> Cookie  technicalCookiesAccepted, wert true , path=/; auf allen Pfade
        document.cookie = "technicalCookiesAccepted=true; path=/;";
        document.getElementById("cookie-banner").style.display = "none";
    }

// Nur technische Cookies akzeptieren
    function acceptTechnicalCookies() {
        //Lokal im Browser
        localStorage.setItem("cookiesAccepted", "technical");
        //Cookie für Backend-Verarbeitung -> Cookie  technicalCookiesAccepted, wert true , path=/; auf allen Pfade
        document.cookie = "technicalCookiesAccepted=true; path=/;";
        document.getElementById("cookie-banner").style.display = "none";
    }
