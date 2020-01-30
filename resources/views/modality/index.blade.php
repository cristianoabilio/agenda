@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">          
        <div class="col-md-12">
            <h2>Modalidades</h2>
        
            <form
            id="form-modality"
            ref="form-modality"
            method="POST"
            data-vv-scope="form-modality"
            autocomplete="off"
            >  
                <checkbox-component
                    :options="{{$modalities}}"
                    ref="modalities"
                >
                
                </checkbox-component>
                <div class="row">
                    <div class="form-group col-12">
                    <b-btn
                        type="button"
                        v-b-modal.modal-footer-sm
                        class="float-right mx-1"
                        :variant="'success'"
                        @click="$refs.modalities.save('form-modality', 'modality')"
                    >
                        <i class="fas fa-save"></i>
                        Salvar
                    </b-btn>
                    </div>
                </div>
            </form>

        </div>
        
    </div>
</div>

@endsection

@section('javascript')
    <!-- Scripts -->
    <script src="{{ asset('js/user.js') }}" defer></script>

@endsection
