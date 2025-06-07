<script setup>
import {onMounted, ref} from "vue";
import {
    getStateLoggedIn,
    listenToBroadcasterArtikelverkauft,
    listenToBroadcasterWartung
} from "../ulities/apiUnities.js";

  let msg = ref();
  let userLoggedIn = ref();
  let userID = ref(0);
  const showPopup = ref(false);


  onMounted(()=>{

      getStateLoggedIn("visitor").then( resolve => {
          if (resolve) {
              listenToBroadcasterArtikelverkauft(e => {
                  msg.value = e.message;
                  showPopup.value = true;

                  setTimeout(() => {
                      showPopup.value = false;
                  }, 5000);
              });

          }else{
              console.log(resolve)
          }
      }).catch(error =>{
          console.log(error);
      });

  })

</script>

<template>
    <div v-if="showPopup" class="popup">
        <p>{{ msg ||"Ihr Artikel wurde nicht verkauft!"}}</p>
    </div>
</template>

<style scoped>
.popup {
    display: flex;
    justify-content: center;  /* Horizontal */
    align-items: center;      /* Vertikal */
    width: 100%;
    height: 26px;
    position: fixed;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    background-color: #00ffd5;
    color: #000;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    z-index: 9999;
    font-weight: bold;
    animation: fadeInOut 3s ease-in-out;
}

.popup p {
    margin: 0;
    text-align: center;
}


@keyframes fadeInOut {
    0% {
        opacity: 0;
        transform: translateX(-50%) translateY(-10px);
    }
    10%, 90% {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
    100% {
        opacity: 0;
        transform: translateX(-50%) translateY(-10px);
    }
}


</style>
