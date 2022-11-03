require('./bootstrap')

window.Vue = require('vue').default;
import { createApp } from 'vue';
import App from './App.vue'
import axios from 'axios'
import router from './routes'
import Notifications from '@kyvg/vue3-notification'
import VueFeather from 'vue-feather';

const app = createApp(App).use()

app.config.globalProperties.$axios = axios;
app.config.productionTip = true


// components
app.component('header-component', require('./components/layouts/Header.vue').default);
app.component('footer-component', require('./components/layouts/Footer.vue').default);
app.component('sidebar-component', require('./components/layouts/Sidebar.vue').default);
app.use(Notifications)
app.component(VueFeather.name, VueFeather);

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        let token = localStorage.getItem('token') != null;
        if (!token) {
            next({
                path: '/login',
                query: {
                    redirect: to.fullPath
                }
            })
        } else {
            let user = JSON.parse(localStorage.getItem('user'))
            let roles = user.roles.map(role => role.name)
            console.log(roles[0]);
            if (to.matched.some(record => record.meta.isUser)) {
                if (roles.includes('user')) next()
                else if (roles[0] === 'admin') {
                    next({
                        name: 'admin'
                    })
                } else if (roles[0] === 'mentor') {
                    next({
                        name: 'mentor'
                    })
                } else next({
                    name: 'PageNotExist'
                })
            } else if (to.matched.some(record => record.meta.isAdmin)) {
                if (roles.includes('admin')) next()
                else if (roles[0] === 'mentor') {
                    next({
                        name: 'mentor'
                    })
                } else if (roles[0] === 'user') {
                    next({
                        name: 'user'
                    })
                } else next({
                    name: 'PageNotExist'
                })

            } else if (to.matched.some(record => record.meta.isMentor)) {
                if (roles.includes('mentor')) next()
                else if (roles[0] === 'user') {
                    next({
                        name: 'user'
                    })
                } else if (roles[0] === 'admin') {
                    next({
                        name: 'admin'
                    })
                } else next({
                    name: 'PageNotExist'
                })

            } else {
                next()
            }
        }
    } else {
        next()
    }
})

app.use(router)
app.mount('#app')
