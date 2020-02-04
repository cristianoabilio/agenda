<div>
    <form
    id="form-create-class"
    ref="form-create-class"
    method="POST"
    data-vv-scope="form-create-class"
    autocomplete="off"
    >        
    
    <div class="container py-3">

        <div class="row">
            <div class="form-group col-12">
                <label for="teacher_id">Professor</label>
                <select name="teacher_id" id="teacher_id" class="form-control">
                    @foreach ($teachers as $teacher)
                        <option value="{{$teacher->id}}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="modality_id">Modalidade</label>
                <select name="modality_id" id="modality_id" class="form-control">
                    @foreach ($modalities as $m)
                        <option value="{{$m->id}}">{{ $m->modality->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="level_id">Nível</label>
                <select name="level_id" id="level_id" class="form-control">
                    @foreach ($levels as $l)
                        <option value="{{$l->id}}">{{ $l->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <checkbox-component
            :options="{{$weekdays}}"
            ref="modalities"
        >        
        </checkbox-component>

        <div class="row">
            <div class="form-group col-12">
                <label for="start">Início</label>
                <input class="form-control" type="text" v-mask="'##:##:##'" id="start" name="start" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="end">Fim</label>
                <input class="form-control" type="text" id="end" v-mask="'##:##:##'" name="end" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="description">Observação</label>
                <input class="form-control" type="text" id="description" name="description" required>
            </div>
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
            @click="$refs.classes.create('form-create-class', '/classes')"
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