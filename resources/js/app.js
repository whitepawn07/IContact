/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Router from 'vue-router'
import VueMaterial from 'vue-material';
// import 'vue-material/dist/vue-material.min.css';
// import 'vue-material/dist/theme/default-dark.css';

import "vue-material/dist/vue-material.css";
import "../sass/material-dashboard.scss";

import paths from './routes/routes';
import Auth from './commons/services/auth.js';

Vue.use(VueMaterial)
Vue.use(Router)
const router = new Router({
    base: '/',
    mode: 'history',
    linkActiveClass: 'active',
    routes: paths
});

router.beforeEach((to, from, next) => {
    if (!to.name && !Auth.authenticated()) {
        next({
            path: '/login'
        });
    } else {
        next(); 
    }
    // if (!to.name) {
    //     next({
    //     path: '/404'
    //     });
    // } else if (to.meta.requiresAuth && !store.state.token) {
    //     next({
    //     path: '/403'
    //     });
    // } else if (to.meta.requiresAdmin && store.state.user.type === 2) {
    //     next({
    //     path: '/403'
    //     });
    // } else {
    // next();
    // }
});


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => {
//     console.log(key.split('/').pop().split('.')[0])
//     Vue.component(key.split('/').pop().split('.')[0], files(key).default)
// });

// Vue.component('form-component', require('./components/FormComponent.vue').default);
// Vue.component('main-component', require('./components/MainComponent.vue').default);
// Vue.component('calendar-component', require('./components/CalendarComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
