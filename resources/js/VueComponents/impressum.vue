<script >

    export default{

    }


</script>

<template>

    <section class="impressum">
        <h1 class="impressum__title">Impressum – Abalo Shop™</h1>

        <div class="impressum__block">
            <p class="impressum__text">
                <strong>Abalo Shop GmbH & Spaß</strong><br />
                CEO für kreative Kaffeepausen: Prof. Dr. Horst-Waldemar Schnitzelkraut
            </p>

            <p class="impressum__text">
                <strong>Adresse:</strong><br />
                Kartonstraße 42<br />
                Im Gewerbepark „Zum rostigen Router“<br />
                12345 Netzhausen, Deutschland
            </p>

            <p class="impressum__text">
                <strong>Kontakt:</strong><br />
                📞 +49 (0)1234 567890<br />
                📠 Fax: Gibt's nur im Museum<br />
                📧 <a href="mailto:support@abalo-floh.fun" class="impressum__link">support@abalo-floh.fun</a>
            </p>

            <p class="impressum__text">
                <strong>Handelsregister:</strong><br />
                HRB 0815, Amtsgericht FakeCity
            </p>

            <p class="impressum__text">
                <strong>USt-ID:</strong><br />
                DE999999999 nach §27a UStG
            </p>

            <p class="impressum__text">
                <strong>Inhaltlich verantwortlich:</strong><br />
                Tante Helga vom Kundenservice (meistens im Pausenraum)
            </p>

            <p class="impressum__text impressum__text--italic">
                ⚠️ Haftungsausschluss: Wir haften nicht für verlorene Zeit, spontane Kaufgelüste
                oder Bluetooth-Toaster mit eigenen Meinungen.
            </p>
        </div>
    </section>


</template>

<style scoped>
.impressum {
    padding: 2rem;
    background-color: #1a1a1a;
    color: #00ffd5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    border: 2px dashed #00ffd5;
    border-radius: 12px;
    max-width: 800px;
    margin: 2rem auto;
    box-shadow: 0 0 20px #00ffd588;
}

.impressum__title {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 1.5rem;
    text-shadow: 0 0 6px #00ffd5cc;
}

.impressum__block {
    line-height: 1.6;
}

.impressum__text {
    margin-bottom: 1rem;
}

.impressum__text--italic {
    font-style: italic;
    color: #f5f5f5;
}

.impressum__link {
    color: #00ffd5;
    text-decoration: underline;
}

.impressum__link:hover {
    text-decoration: none;
    color: #ffffff;
}

</style>
