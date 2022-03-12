require('./bootstrap');

require('alpinejs');

import { createApp } from 'vue';
import router from './router'
createApp({
    components: {

    }
}).use(router).mount('#app')