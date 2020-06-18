<div>
    <form
    id="form-edit-credit"
    ref="form-edit-credit"
    method="POST"
    data-vv-scope="form-edit-credit"
    autocomplete="off"
    >        
    <div class="container col-auto">
        <div class="row">
            <div class="form-group col-auto">
                <label>Adicionar dias a Validade</label>
                <datepicker id="end-edit" name="end" :format="customFormatter" v-model="item.end" :language="ptBR"></datepicker>
                
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label>Disponível</label>
                <input type="number" name="available" id="available" v-model="item.available" class="form-control" v-validate="'required'">
            </div>
        </div>
    
        <input type="hidden" id="user_id" name="id" v-model="item.plan_id" />
        
        </div>
    </form>
</div>
<template slot="modal-footer">

    <b-container fluid>
      <b-row class="mb-1">        
        <b-col>
          <b-btn
            type="button"
            v-b-modal.modal-footer-sm
            class="float-right mx-1"
            :variant="'success'"
            @click="$refs.users.update('form-edit-credit', '/user-plan/validity')"
          >
            <i class="fas fa-save"></i>
            Salvar
          </b-btn>

          <b-btn
        type="button"
        v-b-modal.modal-footer-sm
        class="float-right mx-1"
        :variant="'danger'"
        @click="$root.$emit('bv::hide::modal', 'edit', $event.target)"
    >
        <i class="fas fa-times-circle"></i>
        Cancelar
    </b-btn>
        </b-col>
      </b-row>


    </b-container>

</template>