window.Vue = require('vue').default;
import Vuex from "vuex";
import { createApp } from 'vue';
import * as auth from "./modules/Auth";
import * as user from "./modules/User";
import * as message from "./modules/Message";

import App from '../App.vue'
const app = createApp(App).use()
app.use(Vuex);

export default new Vuex.Store({
    strict: true,

    modules: {
        auth,
        user,
        message,
    },
});