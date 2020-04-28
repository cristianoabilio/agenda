<div>
    <form
    id="form-edit-plan"
    ref="form-edit-plan"
    method="POST"
    data-vv-scope="form-edit-plan"
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
                <label>Detalhes</label>
                <input type="text" name="description" id="description" v-model="item.description"  class="form-control" v-validate="'required|email'">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label>Tipo</label>
                <select name="type" id="type" v-model="item.type" class="form-control">
                    @foreach ($types as $k => $type)
                        <option value="{{$k}}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label>Validade</label>
                <input type="number" name="validity" id="validity" v-model="item.validity" class="form-control" v-validate="'required'">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label>Quantidade</label>
                <input type="number" name="quantidity" id="quantidity" v-model="item.quantidity"  class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label>Preço</label>
                <input type="number" name="price" id="price" v-model="item.price"  class="form-control">
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
            @click="$refs.plan.update('form-edit-plan', '/plan')"
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