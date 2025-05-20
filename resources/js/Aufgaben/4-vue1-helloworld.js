import { createApp } from 'vue'
export function createAppM4_Vue_1() {

    let bool = true;

    let data = {
        msg: 'Hello World!',
    };

    const vm = createApp({
        data() {
            return data;
        }
    }).mount('#app');

    setInterval(() => {
        if (bool) {
            vm.$data.msg =    'Hello World!';

            bool = false;
        } else {
            vm.$data.msg =  'hello world!';
            bool = true;
        }
    }, 2000);



   let data_auto =
       [
           {name: "Reifen", price: 8290},
           {name: "Antenne drehbar. Leicht geknickt", price: 1400},
           {name: "Opel Kadett C 1992 – wie neu", price: 150000},
       ]

    const vm_auto = createApp({
        data() {
            return {
              //muss ein Objekt sein
              autos:data_auto
            };
        },
        methods: {
            addItem() {
                this.autos.push({name: "Radio-Ukw", price: 4});
            }
        }
    }).mount('#tab');




}















