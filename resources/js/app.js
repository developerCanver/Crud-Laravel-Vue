require('./bootstrap');

require('alpinejs');

import Vue from 'vue';

Vue.component('articulo', require('./components/Articulo.vue').default);

const app = new Vue({
    el: '#app',
});
