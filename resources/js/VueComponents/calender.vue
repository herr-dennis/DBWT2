<template>
    <div id="app">
        <h1>Besondere Events auf unsere Seite!</h1>
        <CalendarView
            :show-date="showDate"
            class="theme-default holiday-us-traditional holiday-us-official">
            <template>
                <CalendarViewHeader
                    @input="setShowDate" />
            </template>
        </CalendarView>
    </div>
</template>
<script>
import { CalendarView, CalendarViewHeader } from "vue-simple-calendar"

import "vue-simple-calendar/dist/vue-simple-calendar.css";
import "vue-simple-calendar/dist/css/default.css";
import "vue-simple-calendar/dist/css/holidays-ue.css";
export default {
    name: 'app',
    data: function() {
        return { showDate: new Date() }
    },
    components: {
        CalendarView,
        CalendarViewHeader,
    },
    methods: {
        setShowDate(d) {
            this.showDate = d;
        },
    }
}
</script>
<style scoped >
#app {

    h1{
        text-shadow:
            -1px -1px 0 #000,
            1px -1px 0 #000,
            -1px  1px 0 #000,
            1px  1px 0 #000;

        color: #00ffd5cc;
    }
     display: flex;

    margin-bottom: 12px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    text-shadow: 0 0 6px #00ffd5cc;

    margin-left: auto;
    margin-right: auto;
}
</style>
