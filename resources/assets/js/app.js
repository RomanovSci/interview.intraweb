require('./bootstrap');

window.Vue = require('vue');
const VueRouter = require('vue-router');

Vue.use(require('vue-paginate'));
Vue.use(VueRouter);

const Subscribers = Vue.component('subscribers', require('./components/pages/Subscribers'));
const Broadcast = Vue.component('broadcast', require('./components/pages/Broadcast'));
const routes = [
    {
        path: '/',
        component: Subscribers,
    },
    {
        path: '/broadcast',
        component: Broadcast,
    },
];

const router = new VueRouter({mode: 'history', routes});
const app = new Vue({
    el: '#app',
    router
});
