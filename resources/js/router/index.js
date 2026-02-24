import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import Dashboard from '../views/Dashboard.vue';

const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { guest: true },
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: { requiresAuth: true },
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/dashboard',
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to) => {
    const isAuthRoute = to.meta.requiresAuth;
    const isGuestRoute = to.meta.guest;

    try {
        await window.axios.get('/api/user');

        // Authenticated — redirect away from guest-only routes
        if (isGuestRoute) {
            return { name: 'dashboard' };
        }
    } catch {
        // Not authenticated — redirect away from protected routes
        if (isAuthRoute) {
            return { name: 'login' };
        }
    }
});

export default router;
