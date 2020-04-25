import Vue from 'vue';
import Home from './components/pages/Home.vue';
import About from './components/pages/about.vue';
import VueRouter from 'vue-router';

const routes = [{
        path: '/',
        name: 'home',
        component: Home,
    },
    {
        path: '/about',
        name: 'about',
        component: About,
    }
];

Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    routes
});


export default router;