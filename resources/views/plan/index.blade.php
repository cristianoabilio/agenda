@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">          
        <div class="col-md-12">
            <h2>Planos</h2>
        
            <div class="overflow-auto"> 
                <div class="card rounded bg-white d-flex flex-row align-items-center mb-0 p-2">       
                    <div class="ml-auto">   
                        @can('viewAny',  \App\Models\Plan::class)                     
                        <a href="/plan/history" class="btn btn-white" ><i class="fas fa-history"></i> Histórico</a>
                        @endcan
                    </div>
                </div>              
            </div> 
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
