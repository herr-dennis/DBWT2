<script >

    export default{

        methods:{
            redirectionImpressum(){
                this.$root.$refs.siteBody.switchComponent('impressum');
            }
        }

    }

</script>

<template>

    <div class="container">
        <a @click="redirectionImpressum" class="container--a">Impressum</a>
        <a class="container--a">Datenschutz</a>
        <a class="container--a">Abalo | Zuverlässig</a>
    </div>


</template>

<style scoped>


    .container {
        position: fixed;
        bottom: 0;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        width: 100%;

    }
    .container--a{
        padding: .5rem;
        color: #00ffd5;
        cursor: pointer;
        text-shadow:
            -1px -1px 0 #000,
            1px -1px 0 #000,
            -1px  1px 0 #000,
            1px  1px 0 #000;
    }

</style>
