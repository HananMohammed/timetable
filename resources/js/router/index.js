import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'
Vue.use(VueRouter)

import Login from '../components/login/index.vue';
import DashboardLayout from '../components/layouts/index.vue';
import Dashboard from '../components/dashboard/index'

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
    {
        path:"/",
        component:DashboardLayout,
        meta:{
            middleware:"auth"
        },
        children:[
            {
                name:"dashboard",
                path: '/user/timetable',
                component: Dashboard,
                meta:{
                    title:`TimeTable`
                }
            }
        ]
    }

]
var router  = new VueRouter({
    mode: 'history',
    routes: routes
})

router.beforeEach((to, from, next) => {
    document.title = `${process.env.MIX_APP_NAME} - ${to.meta.title} `
    if(to.meta.middleware=="guest"){
        if(store.state.auth.authenticated){
            next({name:"dashboard"})
        }
        next()
    }else{
        if(store.state.auth.authenticated){
            next()
        }else{
            next({name:"login"})
        }
    }
})

export default router