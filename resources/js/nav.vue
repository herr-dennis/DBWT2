<template>

    <div class="nav">
        <ul class="nav__list">
            <li class="nav__item">
                <a href="/" class="nav__link">Home</a>
            </li>
            <li  class="nav__item">
                <a href="/newsite" class="nav__link">Neue Seite</a>
            </li>
            <li class="nav__item">
                <a class="nav__link">Kategorien</a>
                <ul id="subMenuKategorien" class="nav__submenu nav__submenu--kategorien">
                    <li class="nav__submenu-item" v-for="(cat, index) in categories" :key="index">
                        <a class="nav__submenu-link" href="#">{{ cat.title }}</a>
                    </li>
                </ul>
            </li>
            <li class="nav__item">
                <a class="nav__link">Verkaufen</a>
                <ul class="nav__submenu nav__submenu--verkaufen">
                    <li class="nav__submenu-item"><a class="nav__submenu-link" href="/newarticle">Artikel einstellen</a></li>
                    <li class="nav__submenu-item"><a class="nav__submenu-link" @click="switchToArtikelsuche" >Verkaufsübersicht</a></li>
                </ul>
            </li>
            <li class="nav__item">
                <a class="nav__link">Einloggen</a>
            </li>
        </ul>
    </div>



</template>

<script>

let categories = [];
export default {

    data(){
        return{
            categories
        }
    },

    methods:{
      fetchKategorien: function(callback)
          {
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
          },
        switchToArtikelsuche(){
            this.$root.$refs.siteBody.switchComponent('artikelsuche');
        },

    },

    mounted() {
        this.fetchKategorien((response) => {
            if (!response.error) {
                this.categories = response.map((cat) => ({
                    title: cat.ab_name
                }));
            } else {
                console.error(response.error);
            }
        });
     }

}
</script>
