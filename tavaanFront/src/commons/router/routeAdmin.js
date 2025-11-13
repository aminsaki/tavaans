import layout_home from "@/commons/components/Layouts/homes.vue";


export const AdminRoute = [
  {
    path: '/panel/dashboard/excel',
    name: 'Dashboard',
    meta: {layout: layout_home},
    // beforeEnter: guards.paranGuards,
    component: () => import('@/admin/views/Dashboard/excels/index.vue')
  },

]
