<script >

import {getStateLoggedIn} from "../ulities/apiUnities.js";

export default {
    props: {
        artikel: Array
    },
    methods: {
        entferne(id) {
            this.$emit('entferne-artikel', id);
        },
        isLoggedIn(){
            getStateLoggedIn().then(response =>{
                console.log(response);
                return true;

            }).catch(error=>{
                console.log(error);
                return false;
            })
        }
    },
    mounted() {

    }
}

</script>

<template>
    <div class="warenkorb">
        <p class="warenkorb__p">Warenkorb</p>
        <ul class="warenkorb__content" >
            <li v-for="a in artikel" :key="a" @click="entferne(a)">
                {{ a }}
            </li>

        </ul>
    </div>


</template>

<style scoped>

</style>
