<template>
<div class="container">
            <ul class="list-group">
                    
                     <li v-for="item in items" :key="item.id" class="list-group-item d-flex justify-content-between align-items-center text-secondary">
                            <label>
                              <input type="radio" name="class_id" :value="item.id"  />
                              <span class="badge badge-primary badge-pill"><i class="fas fa-music"></i> {{ item.modality.modality.name }} </span>
                              <span class="badge badge-primary badge-pill">    {{ item.level.name }}</span>
                               <span class="badge badge-warning badge-pill"><i class="far fa-clock"></i> {{ item.start | truncate(5, '') }} </span>
                            </label>  

                      
                    </li>
              
            </ul>
</div>  
</template>

<script>
    
  export default {    
    data: function() {
      return {
        items: Array,            
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
            data.append('company_id', this.$root.item.plan.company_id);
            data.append('user_id', this.$root.item.user_id);
            axios.post('classes/list', data)
            .then(function(res){
            console.log(res.data.data);
                console.log(res.data.data);
                vm.items =  res.data.data;
                                
            })
            .catch(function(err){
                console.log(err);
            })
        },

        sendInfo (item, index = 0) { 
          console.log(item)          ;
          let vThis = this;
          vThis.item = item;
        },

create (id, url) {        
        let vThis = this;
        let data = $("#"+id).serialize();

        this.$validator.validateAll(id).then(valid => {          
            if (!valid) {
              this.$root.mensagem('error', 'Preencha todos os campos obrigatórios')


                $.each(response.data.errors, function(index, value) {
                    $('#'+index).addClass('is-invalid');
                });
                return false;
            } else {
              let id = $('#id').val();

              data = data+'&user_id='+this.$root.item.user_id;
              axios.post(url, data)
              .then(function (response) {
                  if (response.data.status == 'success') {
                    vThis.$emit('bv::hide::modal', 'create');

                    vThis.$bvModal.hide('create')
                    vThis.$bvModal.hide('plan')

                    vThis.items.push(response.data.data);                       


                    vThis.$root.mensagem('success', response.data.message);

                    //if (id == 'form-create-credit') {
                      $('#studants').css('display', 'none');
                      $('#new-plan').css('display', 'block');

                      vThis.item = response.data.data;
                      vThis.$root.item = response.data.data;
                    //}
                    

                  } else {
                      
                      $.each(response.data.errors, function(index, value) {                        
                          $('#'+index).addClass('is-invalid');
                      });
                  }                 
              }).catch(errors => {

                $.each(errors.response.data.errors, function (index, value) {
                    console.log(index);
                    $('#' + index).addClass('is-invalid');
                });
            });
            }         
        });
      },        
        

    }
  }      
</script>