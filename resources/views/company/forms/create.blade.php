<div>
    <form
    id="form-create-company"
    ref="form-create-company"
    method="POST"
    data-vv-scope="form-create-company"
    autocomplete="off"
    >        
    <div class="container py-3">
        <div class="row">
            <div class="form-group col-12">            
                <label>Nome </label>
                <input type="text" name="name" id="name"  class="form-control" v-validate="'required'">
            </div>
        </div>
    
        <div class="row">
            <div class="form-group col-12">
                <label>Email</label>
                <input type="email" name="email" id="email"  class="form-control" v-validate="'required|email'">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label>Telefone</label>
                <input type="tel" name="phone" id="phone" v-mask="'(##)####-####'"  class="form-control" v-validate="'required'">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label>Celular</label>
                <input type="text" name="cellphone" id="cellphone" v-mask="'(##)#####-####'"  class="form-control" v-validate="'required'">
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-12">
                <label>CNPJ</label>
                <input type="text" name="document" id="document" v-mask="'##.###.###/####-##'"  class="form-control" v-validate="'required'">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">            
                <label>Site </label>
                <input type="text" name="website" id="website"  class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">            
                <label>Responsável </label>
                <input type="text" name="responsable" id="responsable"  class="form-control" v-validate="'required'">
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-12">
                <label for="plan_id">Plano</label>
                <select name="plan_id" id="plan_id" class="form-control">
                    @foreach ($plans as $plan)
                        <option value="{{$plan->id}}">{{ $plan->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-12">
                <label>Status</label>
                <b-form-radio-group id="status_id" buttons name="status_id" >
                    <b-form-radio button-variant="outline-primary" value="1">Ativo</b-form-radio>
                    <b-form-radio button-variant="outline-primary" value="0">Inativo</b-form-radio>
                </b-form-radio-group>
            </div>
        </div>
    
        <input type="hidden" id="companyid" name="id"  />        
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
            @click="$refs.company.create('form-create-company', '/company')"
          >
            <i class="fas fa-save"></i>
            Salvar
          </b-btn>

          <b-btn
        type="button"
        v-b-modal.modal-footer-sm
        class="float-right mx-1"
        :variant="'danger'"
        @click="$root.$emit('bv::hide::modal', 'create', $event.target)"
    >
        <i class="fas fa-times-circle"></i>
        Cancelar
    </b-btn>
        </b-col>
      </b-row>


    </b-container>

</template>