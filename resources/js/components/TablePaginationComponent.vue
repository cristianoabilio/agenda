<template>
  <div class="overflow-auto"> 
    <div class="card rounded bg-white d-flex flex-row align-items-center mb-0 p-2">       
        <div class="ml-auto">   
            <span class="h3 text-primary sn"></span><span id="total">{{total}} <strong>total</strong></span>
            <template v-if="this.new == true">
              <button class="btn btn-primary" v-b-modal.create><i class="fas fa-save"></i> Novo</button>
            </template>
        </div>
    </div>  
    <b-table
      id="my-table"
      responsive
      striped hover
      :items="items"
      :per-page="perPage"
      :current-page="currentPage"
      :fields="fields"
      small
    >

        <template
        v-for="column in fields" :item="data.item" 
        :slot="column.key"
        slot-scope="data"
        > 
            <span v-if="data.field.type == 'actions-dropdown'">
                <b-dropdown variant="primary">
                    <template slot="button-content">
                        <i class="fas fa-cog"></i>
                    </template>
                    <b-dropdown-header tag="div" class="text-center border-bottom"><h4 class="mb-0">Ações</h4></b-dropdown-header>
                    <b-dropdown-item v-b-modal.edit v-bind:item="data.item" @click="sendInfo(data.item)">Editar</b-dropdown-item>
                    <b-dropdown-item v-b-modal.delete v-bind:item="data.item" @click="sendInfo(data.item, data.index)">Excluir</b-dropdown-item>

                </b-dropdown>

            </span>     
            <span v-else-if="data.field.type == 'object'">
              <template v-if="column.key == 'teacher'">                  
                {{ data.item.teacher.name }}
              </template>  
              <template v-if="column.key == 'modality'">                  
                {{ data.item.modality.modality.name }}
              </template>  

              <template v-if="column.key == 'class'">                  
                {{ data.item.class.modality.modality.name }}
              </template> 

              <template v-if="column.key == 'level'">                  
                {{ data.item.level.name }}
              </template>      
              <template v-if="column.key == 'user'">                  
                {{ data.item.user.name }}
              </template>       
              <template v-if="column.key == 'plan'">                  
                {{ data.item.plan.name }} {{ data.item.plan.description}}
              </template>          
            </span> 

            <span v-else-if="column.key == 'weekday'">
              {{ weekday(data.item[column.key]) }}
            </span>  

            <span v-else-if="column.key == 'created_at'">
              {{ data.item[column.key] | moment("DD/MM/YY H:mm:ss") }}
            </span> 

            <span v-else-if="data.field.type == 'buttons'">
              <b-btn variant="success" v-b-modal.plan v-bind:item="data.item" @click="sendInfo(data.item)">
                Adicionar
              </b-btn>
              <b-btn variant="info" v-b-modal.edit v-bind:item="data.item" @click="sendInfo(data.item)">
                Editar
              </b-btn>
              <template v-if="data.item['plan_status'] == 1">
                <b-btn variant="danger" v-b-modal.delete v-bind:item="data.item" @click="sendInfo(data.item)">
                  Desativar
                </b-btn>
              </template>
              
            </span>


            <span v-else>
              <template v-if="data.field.jsonPath">
                  @{{ data.item[ column.key ][ column.jsonPath ] }}
              </template>

              <template v-else>
                    {{ data.item[ column.key ] }}                 
              </template>
            </span>
        </template>         
    </b-table>

    <div class="mt-3">
      <b-pagination 
        v-model="currentPage" 
        :total-rows="rows"
        :per-page="perPage"
        size="sm">
        </b-pagination>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
        refs: String,
        perPage: Number,
        fields: Array,
        url: String,
        name: String,
        type: String,
        new: Boolean,
    },      
    data: function() {
      return {
        currentPage: 1,
        item: Object,        
        total: Number,
        boxTwo: '',
        index: Number,
        responsable: String,
        items: Array, 

      }
    },
    computed: {
      rows() {
        this.total = this.items.length;
        return this.total
      },
 
    },
    created: function() {
      this.getItems();           
    },
    methods: {
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
      update (id, url) {
          let vThis = this;
          let data = $("#"+id).serialize();

          this.$validator.validateAll(id).then(valid => {
              if (!valid) {
                  vThis.$root.mensagem('error', 'Preencha todos os campos obrigatórios')
                  $.each(response.data.errors, function(index, value) {
                      $('#'+index).addClass('is-invalid');
                  });
                  return false;
              } else {
                axios.post(url, data)
                .then(function (response) {
                    if (response.data.status == 'success') {
                      vThis.$emit('bv::hide::modal', 'edit');

                      vThis.$bvModal.hide('edit')
                      
                      vThis.item = response.data.data;
                      vThis.$root.item = response.data.data;
                      vThis.$root.mensagem('success', response.data.message)

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
      del(id, url) {
        console.log('delete');
        let vThis = this;
        let data = $("#"+id).serialize();
        
        axios.post(url, data)
        .then(function (response) {
            console.log(response);
            if (response.data.status == 'success') {
              vThis.$emit('bv::hide::modal', 'delete');

              vThis.$bvModal.hide('delete')

              vThis.items.splice(vThis.index, 1);

              vThis.$root.mensagem('success', response.data.message)
            } else {
                vThis.$root.mensagem('error', response.data.message)
            }                 
        })
      },
      createUser () {
        let vThis = this;

        
        
        let data = $("#form-create-user").serialize();

        this.$validator.validateAll('form-create-user').then(valid => {
            if (!valid) {
              vThis.$root.mensagem('error', 'Preencha todos os campos obrigatórios')


                $.each(response.data.errors, function(index, value) {
                    $('#'+index).addClass('is-invalid');
                });
                return false;
            } else {
              let id = $('#id').val();

              axios.post('/users', data)
              .then(function (response) {
                  if (response.data.status == 'success') {
                    vThis.$emit('bv::hide::modal', 'create');

                    vThis.$bvModal.hide('create')

                    vThis.items.push(response.data.data);                       


                    vThis.$root.mensagem('success', response.data.message)

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
      updateUser () {
          let vThis = this;
          let data = $("#form-edit-user").serialize();

          this.$validator.validateAll('form-edit-user').then(valid => {
              if (!valid) {
                  vThis.$root.mensagem('error', 'Preencha todos os campos obrigatórios')
                  $.each(response.data.errors, function(index, value) {
                      $('#'+index).addClass('is-invalid');
                  });
                  return false;
              } else {
                let id = $('#user_id').val();

                axios.post('/users', data)
                .then(function (response) {
                    if (response.data.status == 'success') {
                      vThis.$emit('bv::hide::modal', 'edit');

                      vThis.$bvModal.hide('edit')
                      

                      vThis.$root.mensagem('success', response.data.message)

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
      deleteUser() {
        console.log('delete');

        let vThis = this;
        let data = $("#form-delete-user").serialize();
        
        axios.post('/users/destroy', data)
        .then(function (response) {
            console.log(response);
            if (response.data.status == 'success') {
              vThis.$emit('bv::hide::modal', 'delete');

              vThis.$bvModal.hide('delete')

              vThis.items.splice(vThis.index, 1);

              vThis.$root.mensagem('success', response.data.message)
            } else {
                vThis.$root.mensagem('error', response.data.message)
            }                 
        })
      },
      getItems() {
        var vm = this;
        
        axios.post(vm.url)
        .then(function(res){
          console.log(res.data.data);
            vm.items =  res.data.data;
        })
        .catch(function(err){
            console.log(err);
        })
      },
      sendInfo (item, index = 0) { 
          console.log(index)          ;
          let vThis = this;
          vThis.item = item;

          vThis.item.responsable = (vThis.item.responsable) ? item.responsable.name : '';
          vThis.index = index;
          vThis.$root.item = item
          vThis.$root.item.resṕonsable = vThis.item.responsable
      },

      search (id, url) {
        let vThis = this;
        let data = $("#"+id).serialize();
        $('#expiration').css('display', 'none');

        console.log(data);
        this.$validator.validateAll(id).then(valid => {
            if (!valid) {
              vThis.$root.mensagem('error', 'Preencha todos os campos obrigatórios')


                $.each(response.data.errors, function(index, value) {
                    $('#'+index).addClass('is-invalid');
                });
                return false;
            } else {
              let id = $('#id').val();

              axios.post(url, data)
              .then(function (response) {
                  if (response.data.status == 'success') {
                    $('#studants').css('display', 'block');
                    console.log(response.data.data);
                    vThis.items = response.data.data;                       
                    vThis.$root.items =response.data.data;  


                    vThis.$root.mensagem('success', response.data.message)

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
      }

    },
    
  }
</script>