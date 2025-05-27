import { createRouter, createWebHistory } from "vue-router";
import { isAuthenticated } from "../auth";

const routes = [
    {
        path: "/login",
        component: () => import("../components/auth/Login.vue"),
        meta: { requiresGuest: true },
    },
    {
        path: "/register",
        component: () => import("../components/auth/Register.vue"),
        meta: { requiresGuest: true },
    },
    {
        path: "/",
        component: () => import("../components/Home.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/users",
        component: () => import("../components/users/UserList.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/users/create",
        component: () => import("../components/users/UserForm.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/users/edit/:id",
        component: () => import("../components/users/UserForm.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/clients",
        component: () => import("../components/clients/ClientList.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/clients/create",
        component: () => import("../components/clients/ClientForm.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/clients/edit/:id",
        component: () => import("../components/clients/ClientForm.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/products",
        component: () => import("../components/products/ProductList.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/products/create",
        component: () => import("../components/products/ProductForm.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/products/edit/:id",
        component: () => import("../components/products/ProductForm.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/sales",
        component: () => import("../components/sales/SaleList.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/sales/create",
        component: () => import("../components/sales/SaleForm.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/sales/edit/:id",
        component: () => import("../components/sales/SaleForm.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/reports",
        component: () => import("../components/reports/SalesReport.vue"),
        meta: { requiresAuth: true },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !isAuthenticated.value) {
        return next("/login");
    }
    if (to.meta.requiresGuest && isAuthenticated.value) {
        return next("/");
    }
    next();
});

export default router;
