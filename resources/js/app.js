require('./bootstrap');

Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('reply', require('./components/Reply.vue').default);
Vue.component('favoriate', require('./components/Favoriate.vue').default);

const app = new Vue({
    el: '#app',
});
