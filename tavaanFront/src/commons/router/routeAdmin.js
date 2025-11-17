import layout_home from "@/commons/components/Layouts/homes.vue";
import  * as guards  from "@/commons/router/guard.js"

export const AdminRoute = [
  {
    path: '/panel/dashboard/excel',
    name: 'Dashboard',
    meta: {layout: layout_home},
    beforeEnter: guards.AuthUser,
    component: () => import('@/admin/views/Dashboard/excels/index.vue')
  },

]
