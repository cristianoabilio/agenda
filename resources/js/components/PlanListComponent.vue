<template>
<div class="container">
        <ul class="list-group list-group-flush">
            <template v-for="(item, index) in items"  >           
                <li class="list-group-item bg-light d-flex justify-content-between align-items-center">
                    <p class="p-3 mb-2 text-info"><span class="text-nowrap small">{{ item.plan.company.name| truncate(20, '...') }}</span></p>
                    <button class="btn btn-primary" v-b-modal.create v-bind:item="item" @click="sendInfo(item)"><i class="fas fa-check-circle"></i> check in</button> 
                </li>
                <li class="list-group-item bg-light d-flex justify-content-between align-items-center">
                    <span class="badge badge-primary badge-pill">{{ item.available}} saldo</span>                             
                    <p class="mb-0 text-muted">
                        <span class="text-nowrap small">validade {{ item.end | moment("DD/MM/YY") }}</span>  
                    </p>    
                </li>
            </template>
        </ul>
</div>  
</template>

<script>
  export default {     
    data: function() {
      return {
        items: Array, 
        item: Object,       
      }
    }, 
    computed: {
    },
    created: function() {
      this.getItems(); 
    },
    filters: {
        truncate: function (text, length, suffix) {
            return text.substring(0, length) + suffix;
        },
    },
    methods: { 
        getItems() {
            var vm = this;
            
            let data = new FormData();

            axios.post('user-plan/list', data)
            .then(function(res){
            console.log(res.data.data);

                vm.items =  res.data.data;
                                
            })
            .catch(function(err){
                console.log(err);
            })
        },

        sendInfo (item, index = 0) { 
          let vThis = this;
          vThis.item = item;
          vThis.$root.item = item
        },
        

    }
  }      
</script>