/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import BootstrapVue from 'bootstrap-vue';
import * as VeeValidate from 'vee-validate';
import DatePicker from 'vue2-datepicker';
import VueTheMask from 'vue-the-mask';
import VueMask from 'v-mask';
import Notify from 'vue2-notify';
import Notifications from 'vue-notification';
import VueToast from 'vue-toast-notification';
import vSelect from "vue-select";
import VueGoogleCharts from 'vue-google-charts'
import VueCharts  from 'vue-charts'
Vue.use(VueCharts)
import VueGraph from 'vue-graph'
 
Vue.use(VueGraph)



import 'vue-toast-notification/dist/index.css';




Vue.use(VueMask);
Vue.use(VueTheMask);
Vue.use(Notify);
Vue.use(Notifications);
Vue.use(VueToast);
Vue.use(vSelect);
Vue.use(require('vue-moment'));
Vue.use(VueGoogleCharts)






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


import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import 'vue2-datepicker/index.css';
import "vue-select/dist/vue-select.css";





/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 */


Vue.component('table-pagination-component', require('./components/TablePaginationComponent.vue').default);
Vue.component('checkbox-component', require('./components/CheckBoxComponent.vue').default);
Vue.component('checkin-component', require('./components/CheckinComponent.vue').default);
Vue.component('bubble-graph-component', require('./components/GraphComponent.vue').default);
Vue.component('line-graph-component', require('./components/LineGraphComponent.vue').default);
Vue.component('bar-graph-component', require('./components/GraphBarComponent.vue').default);
Vue.component("v-select", vSelect);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: { DatePicker, VueGoogleCharts },    
    data() {
        return {
          item: Object,
          time1: null,
          message: '',
          responsable: String,
          userSelected: null,          
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
      
      weekday (day) {
        switch (day) {
          case '0': 
            return 'Domingo';
          break;  
          case '1': 
            return 'Segunda-feira';
          break; 
          case '2': 
            return 'Terça-feira';
          break;
          case '3': 
            return 'Quarta-feira';
          break;   
          case '4': 
            return 'Quinta-feira';
          break;    
          case '5': 
            return 'Sexta-feira';
          break;    
          case '6': 
            return 'Sábado';
          break;                                       
        }
      },
      
  },
});
window.app = app;