/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import axios from "axios";
import router from './router'
import store from './store'
axios.defaults.baseURL = '/api/v1';
axios.defaults.headers.common['Authorization'] = '';

window.Fire = new Vue();
Vue.prototype.AppUrl = '/api/v1';
process.env.MIX_APP_NAME='Timetable';


const app = new Vue({
    el: '#app',
    router:router,
    store:store,
    created() {
        let user = this.$store.getters['auth/user'];
        let authenticated = this.$store.getters['auth/authenticated'];
        if(Object.keys(user).length && authenticated)
            axios.defaults.headers.common['Authorization'] = `Bearer ${user.token}`;
    }

});