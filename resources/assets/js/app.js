require('./bootstrap');
window.Vue = require('vue');

Vue.use(require('vue-paginate'));

Vue.component('broadcast', require('./components/pages/Broadcast'));
Vue.component('subscribers', require('./components/pages/Subscribers'));

const app = new Vue({
    el: '#app'
});
