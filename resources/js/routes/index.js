import { createWebHistory, createRouter } from "vue-router";

import Login from '../components/Login.vue'

import Register from '../components/Register.vue'


// Default Layout
import MyHeader from '../components/layouts/Header.vue'
import MySidebar from '../components/layouts/Sidebar.vue'
import MyFooter from '../components/layouts/Footer.vue'

// Dashboard student



export const routes = [

    {
        path: '/404',
        name: 'PageNotExist',
        component: () =>
            import ('../components/NotFound.vue'),
    },
    {
        path: "/:catchAll(.*)",
        redirect: '/404',
    },
    {
        path: '/',
        name: 'login',
        component: Login,
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    },
    // {
    //     path: '/dashboard/student',
    //     name: 'user',
    //     components: {
    //         default: () => Dashboarduser,
    //         HeaderComponent: () => MyHeader,
    //         SidebarComponent: () => MySidebar,
    //         FooterComponent: () => MyFooter,
    //     },
    //     meta: {
    //         requireAuth: true,
    //         isUser: true
    //     }
    // },

];



const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;