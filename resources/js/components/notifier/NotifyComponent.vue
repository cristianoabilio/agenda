<template>
  <div
    v-if="value.isShow"
    :class="'custom-alert-' + value.tipo"
    class="hasAnimation custom-alert custom-alert-top"
    @click="close()"
  >{{ value.message }}</div>
</template>

<script>
import Vue from "vue";
import { setTimeout } from 'timers';
export default {
    name: "notifier-component",
    props: {
        value: {
            tipo: {
                type : String,
                required: true
            },
            message:{
                type: String,
                required: true
            },
            isShow: {
                type:Boolean,
                required: true
            }
        }
    },
    data() {
        return {

        }
    },
    computed: {
        showValue: function () {
           return this.value.isShow
        }
    },
    methods:{
        close(){
            setTimeout(() => {
                this.value.isShow = false;
            }, 2600);
        }
    },
    watch: {
        showValue: function () {
            (this.close());
        }
    }
};
</script>