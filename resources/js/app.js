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

// axios.defaults.withCredentials = true;
axios.defaults.headers.common['Content-Type'] = 'application/json'
axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')

// components
app.component('header-component', require('./components/layouts/Header.vue').default);
app.component('footer-component', require('./components/layouts/Footer.vue').default);
app.component('sidebar-component', require('./components/layouts/Sidebar.vue').default);
app.use(Notifications)
app.component(VueFeather.name, VueFeather);


app.use(router)
app.mount('#app')