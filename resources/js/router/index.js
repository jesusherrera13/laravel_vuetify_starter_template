import { createRouter, createWebHistory } from 'vue-router';

const Dashboard = () => import ('@/components/Dashboard.vue');
const Login = () => import ('@/components/Auth/Login.vue');
const Modulos = () => import ('@/components/System/Modulos.vue');

const routes = [
    { path: '/', name: 'dashboard', component: Dashboard },
    { path: '/login', name: 'login', component: Login },
    { path: '/system-modulos', name: 'system-modulos', component: Modulos },
];
const router = createRouter({
    // history: createWebHistory(import.meta.env.BASE_URL),
    history: createWebHistory('/'),
    routes
});


export default router;