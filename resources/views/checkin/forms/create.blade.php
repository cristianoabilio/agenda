<div>
    <form
        id="form-create-checkin"
        ref="form-create-checkin"
        method="POST"
        data-vv-scope="form-create-checkin"
        autocomplete="off"
        >        

        <div id="message" style="display: none" class="p-3 mb-2 bg-danger text-white">

                Todos os campos são obrigatórios

        </div>   


        <div class="container py-3">
            <div class="row">
                <div class="form-group col-12">
                <label for="teacher_id">Aluno</label>
                <v-select v-model="userSelected" :options="{{$students}}"></v-select>
                </div>
            </div>
        </div>    

        <div class="container py-1">
            <div class="form-group col-12" >
              @foreach ($schedule as $s)
                <div class="checkbox">
                  <label><input type="radio" name="class_id" value="{{ $s['id'] }}"> {{ $s['name'] }}</label>
                </div>
              @endforeach
            </div>
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
            @click="$refs.modalities.create('form-create-checkin', '/checkin/company')"
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