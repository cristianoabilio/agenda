@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">          
        <div class="col-md-12">
            <h2>Planos</h2>
        
            
            <table-pagination-component        
                ref="plan"
                :name="'plan'"         
                :per-page="5" 
                :url="'/plan/list/'"
                :new="true"
                :fields="[
                    { 'key' : 'name', 'sortable' : true, 'label' : 'Nome' },
                    { 'key' : 'description', 'sortable' : true, 'label' : 'Descrição' },
                    { 'key' : 'actions-dropdown', 'sortable' : false, 'label' : '', 'type' : 'actions-dropdown' }
                ]"
            >         
            
               
            </table-pagination-component>
            <b-modal id="create" title="Plano"

            >                
                @include("plan.forms.create")
            </b-modal>
            <b-modal id="edit"  title="Plano"

            >                
                @include("plan.forms.edit")
            </b-modal>

            <b-modal id="delete"  title="Plano" body-text-variant="danger"

            >                
                @include("plan.forms.delete")
            </b-modal>
        </div>
        
    </div>
</div>

@endsection

@section('javascript')
    <!-- Scripts -->
    <script src="{{ asset('js/user.js') }}" defer></script>

@endsection
