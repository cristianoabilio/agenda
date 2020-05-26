<div>
      
    


    <form
    id="form-create-credit"
    ref="form-create-credit"
    method="POST"
    data-vv-scope="form-create-credit"
    autocomplete="off"
    >  
    <div class="container py-3">
        <div class="row">
            <div class="form-group col-12">            
                <label>Nome</label>
                <input type="text" name="name" id="name" v-model="item.name" class="form-control-plaintext" v-validate="'required'">
            </div>
        </div>
    
        <div class="row">
            <div class="form-group col-12">
                <label>Email</label>
                <input type="email" name="email" id="email" v-model="item.email" class="form-control-plaintext" v-validate="'required|email'">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label>Telefone</label>
                <input type="tel" name="cellphone" id="cellphone" v-mask="'(##)####-####'" v-model="item.cellphone" class="form-control-plaintext" v-validate="'required'">
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-12">
                <label>CPF</label>
                <input type="text" name="document" id="document" v-mask="'###.###.###-##'" v-model="item.document"  class="form-control-plaintext" v-validate="'required'">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label>Plano</label>
                <select name="plan_id" id="plan_id" class="form-control">
                    @foreach ($plans as $plan)
                        @if ($plan->type == 'C')
                            <option value="{{$plan->id}}">{{ $plan->name }} - R$ {{ number_format($plan->price, 2) }} - {{ $plan->quantidity}} aulas</option>
                        @else 
                            <option value="{{$plan->id}}">{{ $plan->name }} - R$ {{ number_format($plan->price, 2) }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label>Desconto</label>
                <input type="number" name="discount" id="discount"  class="form-control">
            </div>
        </div>
    
        <input type="hidden" id="id" v-model="item.id" name="id"  />
        <input type="hidden" id="company_id" name="company_id" />
        <input type="hidden" id="status_id" name="status_id"  value="1" />
        
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
            @click="$refs.users.create('form-create-credit', '/user-plan')"
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