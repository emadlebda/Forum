require('./bootstrap');

Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('thread-view', require('./pages/Thread').default);

const app = new Vue({
    el: '#app',
});
