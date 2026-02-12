require('./bootstrap');
window.Vue = require('vue');
Vue.component('comments', require('./components/Example.vue'));
const app = new Vue({
    el: '#contentComment'
});