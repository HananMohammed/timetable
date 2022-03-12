
import { createRouter, createWebHistory } from 'vue-router'
import Login from '../components/login/index.vue';
const routes = [
    {
        name: "login",
        path: "/",
        component: Login,
        meta: {
            middleware: "guest",
            title: `Login`,
        }
    },
    // {
    //     name: "homepage",
    //     path: "/",
    //     component: Homepage,
    //     meta: {
    //         middleware: "guest",
    //         title: `Homepage`,
    //         position: 0
    //     },
    // },

]
const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})
export default router