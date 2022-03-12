import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'
import { mapGetters } from "vuex";
Vue.use(VueRouter)

/* Guest Component */

import Login from '../components/login/index.vue';
//import Homepage from '../components/hompage/index';

import axios from "axios";

let Routes = [
    {
        name: "login",
        path: "/login",
        component: Login,
        meta: {
            middleware: "guest",
            title: `Login`,
        }
    },

    {
        name: "homepage",
        path: "/",
        component: Homepage,
        meta: {
            middleware: "guest",
            title: `Homepage`,
            position: 0
        },
    },

    ];
    let router = new VueRouter({
        mode: 'history',
        routes: Routes
    })

    router.beforeEach(async(to, from, next) => {

        if (to.matched.some(record => record.meta.reuse === true)) {
            app.key = to.path
            to.meta.title = to.params.slug
        } else {
            app.key = null
        }

        document.title = `Grand Community - ${to.meta.title}`

        if (to.meta.middleware == "guest") {
            if (store.state.auth.authenticated) {
                if (to.fullPath == '/login' || to.fullPath == '/register') {
                    (store.state.auth.user.otherData.active == 0) ? next({ name: "completeData" }): next({ name: "dashboard" })
                }
            }
            next()
        } else {
            if (store.state.auth.authenticated) {
                next()
            } else {
                next({ name: "login" })
            }
        }
    })


export default router
