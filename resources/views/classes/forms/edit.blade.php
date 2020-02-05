<div>
    <form
    id="form-edit-class"
    ref="form-edit-class"
    method="POST"
    data-vv-scope="form-edit-class"
    autocomplete="off"
    >        
    
    <div class="container py-3">

        <div class="row">
            <div class="form-group col-12">
                <label for="teacher_id">Professor</label>
                <select name="teacher_id" id="teacher_id" class="form-control" v-model="item.teacher_id">
                    @foreach ($teachers as $teacher)
                        <option value="{{$teacher->id}}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="modality_id">Modalidade</label>
                <select name="modality_id" id="modality_id" class="form-control" v-model="item.modality_id">
                    @foreach ($modalities as $m)
                        <option value="{{$m->id}}">{{ $m->modality->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="level_id">Nível</label>
                <select name="level_id" id="level_id" class="form-control" v-model="item.level_id">
                    @foreach ($levels as $l)
                        <option value="{{$l->id}}">{{ $l->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="start">Dia</label>
                <p>@{{ weekday(item.weekday) }}</p>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="start">Início</label>
                <input class="form-control" type="text" v-mask="'##:##:##'" id="start" name="start" v-model="item.start" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="end">Fim</label>
                <input class="form-control" type="text" id="end" v-mask="'##:##:##'" name="end" v-model="item.end" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12">
                <label for="description">Observação</label>
                <input class="form-control" type="text" id="description" name="description" v-model="item.description" required>
            </div>
        </div>
        <input type="hidden" id="id" name="id" v-model="item.id" />   
        <input type="hidden" id="item" name="item" v-model="item.weekday" />   
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
            @click="$refs.classes.update('form-edit-class', '/classes')"
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