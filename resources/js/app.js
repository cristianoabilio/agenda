/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import BootstrapVue from 'bootstrap-vue'
import * as VeeValidate from 'vee-validate'
import DatePicker from 'vue2-datepicker';
import VueTheMask from 'vue-the-mask'
import VueMask from 'v-mask'
import Notify from 'vue2-notify'
import Notifications from 'vue-notification'
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/index.css';




Vue.use(VueMask);
Vue.use(VueTheMask)
Vue.use(Notify)
Vue.use(Notifications)
Vue.use(VueToast);


Vue.use(VeeValidate, {
  classes: true,
  classNames: {
    invalid: 'is-invalid'
  },
    // This is the default
    inject: true,
    // Important to name this something other than 'fields'
    fieldsBagName: 'veeFields',
    // This is not required but avoids possible naming conflicts
    errorBagName: 'veeErrors'
 });

Vue.use(BootstrapVue)


import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'vue2-datepicker/index.css'




/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 */


Vue.component('table-pagination-component', require('./components/TablePaginationComponent.vue').default);
Vue.component('checkbox-component', require('./components/CheckBoxComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: { DatePicker },
    data() {
        return {
          item: Object,
          time1: null,
          message: '',
          responsable: String
        }
    },
    methods: {
      mensagem (type, message) {
        console.log('teste') 
        this.$toast.open({
          type: type,
          message: message,
          position: 'top-right',
          queue: true,
        });

        this.$notify({
          title: 'Important message',
          text: 'Hello user! vThis is a notification!'
        })
      },      
  },
});
window.app = app;