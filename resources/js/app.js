import VueJSModal from "vue-js-modal";

require('./bootstrap');

import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'

Vue.use(Vuex);
Vue.use(VueRouter);

import StoreData from './store'

const store = new Vuex.Store(StoreData);

import VTooltip from 'v-tooltip'
import Toasted from 'vue-toasted'

Vue.use(VTooltip);
Vue.use(Toasted);
Vue.use(VueJSModal);

import MainApp from "./components/MainApp";

import {routes} from './routes';

let router = new VueRouter({
  routes,
  mode: 'history',
  base: '/api'
});

Vue.component('invited', require('./components/Invited/Invited.vue').default);
Vue.component('theme-switcher', require('./components/theme-switcher/theme-switcher.vue').default);


new Vue({
  el: '#app',
  components: {
    MainApp
  },
  router,
  store,
});

