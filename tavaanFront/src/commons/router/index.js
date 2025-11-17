import {createRouter, createWebHistory} from 'vue-router'
import layout_home from "@/commons/components/Layouts/homes.vue"
import * as guards from "./guard.js"
import {AdminRoute} from "./routeAdmin.js"
import notFound from "@/commons/views/NotFound.vue";


const routes = [
    ...AdminRoute,
    {
        path: '/home',
        name: 'Home',
        meta: {layout: layout_home},
        beforeEnter: guards.AuthUser,
        component: () => import('@/Home/views/homes/index.vue')
    },
      {
        path: '/',
        name: 'login',
        meta: {layout: layout_home},
        component: () => import('@/Home/views/Login/index.vue')
    },
    {
        path: "/:pathMatch(.*)*",
        name: "not-found",
        meta: {layout: notFound}
    }



]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),  // استفاده از import.meta.env
    routes
});


export default router;
