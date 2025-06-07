<template>
    <div>
        <p>Hier werden Sie benachrichtigt, wenn es Neuigkeiten gibt. Abalo ist für Sie da!</p>
        <p v-if="nachricht">Nachricht: {{ nachricht }}</p>
        <p v-if="nachrichtId !== null">ID: {{ nachrichtId }}</p>
    </div>
</template>
//setup V.3
<script  setup>

import { ref, onMounted } from 'vue';

// ref() -> reaktive Variable
const nachricht = ref('');
const nachrichtId = ref(null);
//wie mounted in Vue.2
onMounted(() => {
    listenToBroadcaster((e) => {
        console.log('Event erhalten in Komponente:', e);
        nachricht.value = e.message;
        nachrichtId.value = e.id;
    });
});
</script>

<style scoped>
p {
    font-family: sans-serif;
    margin: 0.5em 0;
}
</style>
