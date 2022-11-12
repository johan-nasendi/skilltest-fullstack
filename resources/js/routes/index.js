import { createWebHistory, createRouter } from "vue-router";

import Login from '../components/Login.vue'
import ForgotPassword from '../components/ForgotPassword.vue'
import SendEmail from '../components/SendEmail.vue'
import Register from '../components/Register.vue'


// Default Layout
import MyHeader from '../components/layouts/Header.vue'
import MySidebar from '../components/layouts/Sidebar.vue'
import MyFooter from '../components/layouts/Footer.vue'

// Dashboard student
import Dashboard from '../pages/Dashboard.vue'
// Todo List
import TodolistIndex from '../pages/todolist/Index.vue'
import TodolistCreate from '../pages/todolist/Create.vue'
import TodolistEdit from '../pages/todolist/Edit.vue'
import TodolistDetail from '../pages/todolist/Detail.vue'

// Profile
import ProfileIndex from '../pages/profile/Index.vue'
import ProfileChanePassword from '../pages/profile/Changepassword.vue'
import ProfileUpload from '../pages/profile/Uploadphoto.vue'
import ProfileEdit from '../pages/profile/Edit.vue'

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
        meta: {
            hideForAuth: true,
        }
    },
    {
        path: '/send-email',
        name: 'sendemail',
        component: SendEmail,
        meta: {
            hideForAuth: true,
        }
    },
    {
        path: '/reset-password',
        name: 'forgotpassword',
        component: ForgotPassword,
        meta: {
            hideForAuth: true,
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            hideForAuth: true,
        }
    },
    {
        path: '/dashboard',
        name: 'user',
        components: {
            default: () => Dashboard,
            HeaderComponent: () => MyHeader,
            SidebarComponent: () => MySidebar,
            FooterComponent: () => MyFooter,
        },
        meta: {
            requireAuth: true,
            isUser: true
        }
    },
    {
        path: '/dashboard/todo-list',
        name: 'todolist',
        components: {
            default: () => TodolistIndex,
            HeaderComponent: () => MyHeader,
            SidebarComponent: () => MySidebar,
            FooterComponent: () => MyFooter,
        },
        meta: {
            requireAuth: true,
            isUser: true
        },
        props: true
    },
    {
        path: '/dashboard/todo-list/create',
        name: 'addtodo',
        components: {
            default: () => TodolistCreate,
            HeaderComponent: () => MyHeader,
            SidebarComponent: () => MySidebar,
            FooterComponent: () => MyFooter,
        },
        meta: {
            requireAuth: true,
            isUser: true
        },
        props: true
    },
    {
        path: '/dashboard/todo-list/:id/edit',
        name: 'todoedit',
        components: {
            default: () => TodolistEdit,
            HeaderComponent: () => MyHeader,
            SidebarComponent: () => MySidebar,
            FooterComponent: () => MyFooter,
        },
        meta: {
            requireAuth: true,
            isUser: true
        },
        props: true
    },
    {
        path: '/dashboard/todo-list/:id/detail',
        name: 'tododetail',
        components: {
            default: () => TodolistDetail,
            HeaderComponent: () => MyHeader,
            SidebarComponent: () => MySidebar,
            FooterComponent: () => MyFooter,
        },
        meta: {
            requireAuth: true,
            isUser: true
        },
        props: true
    },
    {
        path: '/dashboard/myaccount',
        name: 'profile',
        components: {
            default: () => ProfileIndex,
            HeaderComponent: () => MyHeader,
            SidebarComponent: () => MySidebar,
            FooterComponent: () => MyFooter,
        },
        meta: {
            requireAuth: true,
            isUser: true
        },
        props: true
    },
    {
        path: '/dashboard/myaccount/:id/upload-photo',
        name: 'profileupload',
        components: {
            default: () => ProfileUpload,
            HeaderComponent: () => MyHeader,
            SidebarComponent: () => MySidebar,
            FooterComponent: () => MyFooter,
        },
        meta: {
            requireAuth: true,
            isUser: true
        },
        props: true
    },
    {
        path: '/dashboard/myaccount/:id/edit',
        name: 'profileedit',
        components: {
            default: () => ProfileEdit,
            HeaderComponent: () => MyHeader,
            SidebarComponent: () => MySidebar,
            FooterComponent: () => MyFooter,
        },
        meta: {
            requireAuth: true,
            isUser: true
        },
        props: true
    },
    {
        path: '/dashboard/myaccount/change-password',
        name: 'profilechangespassword',
        components: {
            default: () => ProfileChanePassword,
            HeaderComponent: () => MyHeader,
            SidebarComponent: () => MySidebar,
            FooterComponent: () => MyFooter,
        },
        meta: {
            requireAuth: true,
            isUser: true
        },
        props: true
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});


router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        let token = localStorage.getItem('token') != null;
        if (!token) {
            next({
                path: '/',
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

    if (to.matched.some(record => record.meta.hideForAuth)) {
        if (user) {
            next({ path: '/dashboard' });
        } else {
            next();
        }
    } else {
        next();
    }
})

export default router;