@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">          
        <div class="col-md-12">
            <h2>Usuários</h2>
        
            
            <table-pagination-component        
                ref="users"
                :name="'user'"         
                :per-page="5" 
                :url="'/users/list/'"
                :new="true"
                :fields="[
                    { 'key' : 'id', 'sortable' : true, 'label' : '#' },
                    { 'key' : 'name', 'sortable' : true, 'label' : 'Nome' },
                    { 'key' : 'email', 'sortable' : true, 'label' : 'E-mail' },
                    { 'key' : 'actions-dropdown', 'sortable' : false, 'label' : '', 'type' : 'actions-dropdown' }
                ]"
            >         
            
               
            </table-pagination-component>
            <b-modal id="create" title="Usuário"

            >                
                @include("user.forms.create")
            </b-modal>
            <b-modal id="edit"  title="Usuário"

            >                
                @include("user.forms.edit")
            </b-modal>

            <b-modal id="delete"  title="Usuário" body-text-variant="danger"

            >                
                @include("user.forms.delete")
            </b-modal>
        </div>
        
    </div>
</div>

@endsection

@section('javascript')
    <!-- Scripts -->
    <script src="{{ asset('js/user.js') }}" defer></script>

@endsection
