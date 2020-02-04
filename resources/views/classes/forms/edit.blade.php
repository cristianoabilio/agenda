<div>
    <form
    id="form-edit-user"
    ref="form-edit-user"
    method="POST"
    data-vv-scope="form-edit-user"
    autocomplete="off"
    >        
    <div class="container py-3">
        <div class="row">
            <div class="form-group col-12">
                <label>Nome</label>
                <input type="text" name="name" id="edit-name" v-model="item.name" class="form-control" v-validate="'required'">
            </div>
        </div>
    
        <div class="row">
            <div class="form-group col-12">
                <label>Email</label>
                <input type="email" name="email" id="edit-email" v-model="item.email" class="form-control" v-validate="'required|email'">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label>Telefone</label>
                <input type="text" name="phone" id="phone" v-mask="'(##)####-####'" v-model="item.phone" class="form-control" v-validate="'required'">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label>Celular</label>
                <input type="text" name="cellphone" id="cellphone" v-mask="'(##)#####-####'" v-model="item.cellphone" class="form-control" v-validate="'required'">
            </div>
        </div>        
        
        <div class="row">
            <div class="form-group col-12">
                <label>CPF</label>
                <input type="text" name="document" id="document" v-mask="'###.###.###-##'" v-model="item.document" class="form-control" v-validate="'required'">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                <label>Data de nascimento</label>    
                <input type="text" name="birthday" id="birthday" v-mask="'##/##/####'" v-model="item.birthday" class="form-control" v-validate="'required'">
            </div>
        </div>
        <div class="row">

        </div>
        <div class="row">
            <div class="form-group col-12">
                <label>Gênero</label>
                <b-form-radio-group id="edit-userGender" buttons name="gender" v-model="item.gender">
                    <b-form-radio button-variant="outline-primary" value="F">Feminino</b-form-radio>
                    <b-form-radio button-variant="outline-primary" value="M">Masculino</b-form-radio>
                </b-form-radio-group>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                <label>Status</label>
                <b-form-radio-group id="edit-userStatus" buttons name="status_id" v-model="item.status_id">
                    <b-form-radio button-variant="outline-primary" value="1">Ativo</b-form-radio>
                    <b-form-radio button-variant="outline-primary" value="0">Inativo</b-form-radio>
                </b-form-radio-group>
            </div>
        </div>
    
        <input type="hidden" id="user_id" name="id" v-model="item.id" />
        <input type="hidden" id="company_id" name="company_id" v-model="item.company_id" />
        
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
            @click="$refs.users.updateUser()"
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