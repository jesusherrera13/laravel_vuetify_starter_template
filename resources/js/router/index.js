import { createRouter, createWebHistory } from 'vue-router';

const Dashboard = () => import ('@/components/Dashboard.vue');
const Login = () => import ('@/components/Auth/Login.vue');
const Modulos = () => import ('@/components/System/Modulos.vue');
const Modulo = () => import ('@/components/System/Modulo.vue');
const Usuarios = () => import ('@/components/System/Usuarios.vue');
const Acceso = () => import ('@/components/System/Acceso.vue');

const routes = [
    { path: '/', name: 'dashboard', component: Dashboard },
    { path: '/login', name: 'login', component: Login },
    { path: '/system-modulos', name: 'system-modulos', component: Modulos },
    { path: '/system-modulo/:id', name: 'system-modulo', component: Modulo },
    { path: '/system-usuarios', name: 'system-usuarios', component: Usuarios },
    { path: '/system-accesos', name: 'system-accesos', component: Acceso },
];
const router = createRouter({
    // history: createWebHistory(import.meta.env.BASE_URL),
    history: createWebHistory('/'),
    routes
});


export default router;