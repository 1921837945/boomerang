import Vue from 'vue';
import router from 'vue-router';
import App from './App.vue';
import Vr from 'vue-resource'
import Vuex from "./components/vuex"

Vue.use(Vuex)
Vue.use(Vr);





new Vue({
    el: '#app',
    router,
    template: '<App/>',
    components: {App},

});
