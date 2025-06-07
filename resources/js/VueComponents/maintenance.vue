<script setup>
import {onMounted, ref} from "vue";
import {getStateLoggedIn, listenToBroadcasterWartung} from "../ulities/apiUnities.js";


   const msg = ref("");
   let userLoggedIn =false;

         onMounted(()=>{
             //Prüft ob der User eingeloggt ist
             getStateLoggedIn("visitor").then(resolve=>{
                 if(resolve){
                     userLoggedIn=true;
                     msg.value="Sie sind eingeloggt"
                     listenToBroadcasterWartung((e)=>{
                         console.log("Meldung in maintenance"+resolve);
                         msg.value = e.message;
                     });
                 }
             }).catch(error=>{
                 userLoggedIn=false;
                 msg.value="Sie sind nicht eingeloggt"
                 console.log("Fehler maintenance"+error);
             });

         });




</script>

<template>

    <div class="maintenance" >
        <h1 class="maintenance__h1" > Live-Meldungen</h1>
          <blockquote class="maintenance__blockquote">
              {{msg}}
          </blockquote>

    </div>

</template>

<style scoped>

.maintenance {
    position: fixed;
    bottom: 12px;
    left: 0rem;
    width: 300px;
    background-color: #4a5568;
    border-left: 5px solid #00ffd5;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0, 255, 213, 0.2);
    color: #e2e8f0;
    font-family: "Segoe UI", sans-serif;
    z-index: 999;
    animation: fadeIn 0.5s ease-in-out;
}

.maintenance__h1 {
    font-size: 1.25rem;
    color: #00ffd5;
    margin-bottom: 1rem;
    text-shadow: 0 0 5px #00ffd5;
    text-align: center;
}

.maintenance__blockquote {
    font-size: 1rem;
    background: #2d3748;
    padding: 1rem;
    border-left: 3px solid #00ffd5;
    border-radius: 5px;
    box-shadow: inset 0 0 8px rgba(0, 255, 213, 0.1);
    color: #00ffd5;
    line-height: 1.4;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
