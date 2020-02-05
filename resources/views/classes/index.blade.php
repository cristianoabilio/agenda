@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">          
        <div class="col-md-12">
            <h2>Aulas</h2>
        
            
            <table-pagination-component        
                ref="classes"
                :name="'classes'"         
                :per-page="20" 
                :url="'/classes/list/'"
                :fields="[
                    'index',
                    { 'key' : 'id', 'sortable' : true, 'label' : '#' },
                    { 'key' : 'teacher', 'sortable' : true, 'label' : 'Professor', 'type': 'object' },
                    { 'key' : 'modality', 'sortable' : true, 'label' : 'Modalidade', 'type': 'object' },
                    { 'key' : 'level', 'sortable' : true, 'label' : 'Nível', 'type': 'object' },
                    { 'key' : 'weekday', 'sortable' : true, 'label' : 'Dia' },
                    { 'key' : 'start', 'sortable' : true, 'label' : 'Horário' },
                    { 'key' : 'actions-dropdown', 'sortable' : false, 'label' : '', 'type' : 'actions-dropdown' }
                ]"
            >         
            
               
            </table-pagination-component>
            <b-modal id="create" title="Aulas"

            >                
                @include("classes.forms.create")
            </b-modal>
            <b-modal id="edit"  title="Aulas"

            >                
                @include("classes.forms.edit")
            </b-modal>

            <b-modal id="delete"  title="Aulas" body-text-variant="danger"

            >                
                @include("classes.forms.delete")
            </b-modal>
        </div>
        
    </div>
</div>

@endsection