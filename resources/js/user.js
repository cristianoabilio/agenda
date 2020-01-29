/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue'
import VueMask from 'v-mask'


Vue.use(VueMask);
Vue.use(BootstrapVue)



import VeeValidate from 'vee-validate';

Vue.use(VeeValidate);



import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 */
Vue.component('table-pagination-component', require('./components/TablePaginationComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data() {
        return {
          item: Object
        }
    },

    methods: {
        updateUser () {
            let vThis = this;
            let data = $("#form-edit-user").serialize();
            let id = $('#id').val();

            console.log(data);

            axios.post('/users/'+id, data)
            .then(function (response) {
                if (response.data.status == 'success') {
                    vThis.events = response.data.data;
                }                 
            })
        }
    },
});
