@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>Empresas</h2>
            <table-pagination-component 
                ref="company"
                :name="'company'"         
                :per-page="5" 
                :url="'/company/list/'"            
                :per-page="1" 
                :items="{{$items}}"
                :fields="[
                    'index',
                    { 'key' : 'id', 'sortable' : true, 'label' : '#' },
                    { 'key' : 'name', 'sortable' : true, 'label' : 'Nome' },
                    { 'key' : 'email', 'sortable' : true, 'label' : 'E-mail' },
                    { 'key' : 'actions-dropdown', 'sortable' : false, 'label' : '', 'type' : 'actions-dropdown' }
                ]"
                :type="'company'"
            >
            
            </table-pagination-component>
            <b-modal id="create" title="Empresa"

            >                
                @include("company.forms.create")
            </b-modal>
            <b-modal id="edit"  title="Empresa"

            >                
                @include("company.forms.edit")
            </b-modal>

            <b-modal id="delete"  title="Empresa" body-text-variant="danger"

            >                
                @include("company.forms.delete")
            </b-modal>            
        </div>
    </div>
</div>
@endsection
