<template>
<div class="container">
    <div class="row">
        <div class="col-md-5 bg-primary text-white">Aguardando
            <ul class="list-group bg-primary">
                <template v-for="(item, index) in items"  >
                    <li v-on:click="toApprove(item.id, index)" class="list-group-item d-flex justify-content-between align-items-center text-secondary">
                      <small>{{ item.user.name }} - <strong>{{ item.class.modality.modality.name }}</strong> - {{ item.class.start }}</small>
                        <span class="badge badge-primary badge-pill"> <i class="far fa-check-circle"></i></span>
                    </li>
                </template>
            </ul>
        </div>
        <div class="col-md-5 ml-auto bg-success text-white">Aprovados
            <ul class="list-group bg-success">
                <template v-for="(item, index) in approved"  >
                    <li class="list-group-item d-flex justify-content-between align-items-center text-secondary">
                      <small>{{ item.created_at | moment("DD/MM/YY") }} - {{ item.user.name }} - <strong>{{ item.class.modality.modality.name }}</strong> - {{ item.class.start }}</small>                        
                    </li>
                </template>
            </ul>        
        </div>        
    </div>  
</div>  
</template>

<script>
  export default {
    props: {
        url: String,
    },      
    data: function() {
      return {
        items: Array, 
        approved: [], 
      }
    },
    computed: {
    },
    created: function() {
      this.getItems(5);   
      this.getItems(1);  
      
      
      setInterval(function () {
		      this.getItems(5); 
     }.bind(this), 120000);
     
     setInterval(function () {
		      this.getItems(1); 
		 }.bind(this), 120000);
    },
    methods: {     
      getItems(statusId) {
        var vm = this;
        
        let data = new FormData();

        data.append('status_id', statusId);
        axios.post(vm.url, data)
        .then(function(res){
          console.log(res.data.data);
            if (statusId == 5) {
              vm.items =  res.data.data;
            }

            if (statusId == 1) {
              vm.approved =  res.data.data;
            }
            
            
        })
        .catch(function(err){
            console.log(err);
        })
      },
      toApprove(id, index) {
        console.log('aprovado'+id+' '+index);
        var vm = this;
        let vThis = this;

        let data = new FormData();

        data.append('id', id);
        
        axios.post('/checkin', data)
        .then(function(res){
            console.log(res.data.message);
            vm.items.splice(index, 1);
            vm.approved.push(res.data.data);                       
            vm.$root.mensagem('success', res.data.message)
        })
        .catch(function(err){
            console.log(err);
        })


        
      }     

    },
    
  }
</script>