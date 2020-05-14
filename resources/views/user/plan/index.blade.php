@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">          
        <div class="col-md-12">
            <h2>Créditos</h2>
        
            <div class="container col-md-6 p-3" >
                <b-form id="search-user" inline onsubmit="return false;">
                    <label class="mr-sm-2 " >Pesquisar</label>
                    <b-input
                        id="name"
                        name="name"
                        class="mb-2 mr-sm-2 mb-sm-0"
                        placeholder="Digite o termo de busca..."
                        v-on:keyup.enter="$refs.users.search('search-user', '/users/list')"
                    ></b-input>

                    <input type="hidden" id="profile_id" name="profile_id" value="4"  />
                    <b-button variant="primary" @click="$refs.users.search('search-user', '/users/list')"><i class="fas fa-search"></i></b-button>

                </b-form>
                
            </div>             
            


            <div id="studants">
                <table-pagination-component        
                    ref="users"
                    :name="'user'"         
                    :per-page="5" 
                    :url="'/user-plan/expiration'"
                    :new="true"
                    :fields="[
                        { 'key' : 'id', 'sortable' : true, 'label' : '#' },
                        { 'key' : 'name', 'sortable' : true, 'label' : 'Nome' },
                        { 'key' : 'email', 'sortable' : true, 'label' : 'E-mail' },
                        { 'key' : 'available', 'sortable' : false, 'label' : 'Disponível' },
                        { 'key' : 'end', 'sortable' : false, 'label' : 'Validade' },
                        { 'key' : 'status_name', 'sortable' : false, 'label' : 'Status' },
                        { 'key' : 'buttons', 'sortable' : false, 'label' : '', 'type' : 'buttons' }
                    ]"
                >         
                
                
                </table-pagination-component>
            </div>

            <div id="new-plan" class="alert alert-success" role="alert" style="display: none">
                        Plano cadastrado com sucesso.
            </div>

            <b-modal id="create" title="Créditos"

            >                
                @include("user.plan.create")
            </b-modal>
            <b-modal id="delete" title="Créditos"

            >                
                @include("user.plan.delete")
            </b-modal>
        </div>
        
    </div>
</div>

@endsection

@section('javascript')
    <!-- Scripts -->
    <script src="{{ asset('js/user.js') }}" defer></script>

@endsection
