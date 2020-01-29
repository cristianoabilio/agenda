import Vue from 'vue';
//Selecty Notifier
import Notifier from './components/notifier/NotifyComponent.vue';
Vue.component('notifier-component', Notifier);

let NotifierMixin = {
    data: {
        notifyBuilder:{
            tipo: '',
            message: '',
            isShow: false
        },
    },
    methods : {
        showNotifier(message, status) {

            this.notifyBuilder = {
                message: message,
                tipo: status,
                isShow: true
            }
        }
    },
    mounted() {

        // Add a response interceptor
        axios.interceptors.response.use(function (response) {
            //console.warn("receiving response", response.data.action);
            if (_.has(response.data, 'action') && response.data.action == "notify") {
                this.showNotifier(
                    this.$i18n.t(response.data.message),
                    response.data.status
                );
            }
            // Do something with response data
            return response;
        }.bind(this), function (error) {
            // Do something with response error
            return Promise.reject(error);
        });
    }
};
export default NotifierMixin;