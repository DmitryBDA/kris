import {createRouter, createWebHistory} from "vue-router";

const routes = [
    {
        path: "/admin", component: () => import('./components/admin/pages/main'),
        name: "admin.index",
    }
];

const routerAdmin = createRouter({
    history: createWebHistory(),
    routes
});

export default routerAdmin;



