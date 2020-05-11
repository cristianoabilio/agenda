@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>Check-in</h2>   
            <h3 class="small">Histórico</h3>         
        </div>
    </div>
    <div class="row justify-content-center">   
        <div class="col-md-12">     
            <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
            <!-- Navbar content -->
                <form 
                    id="form-search-checkin"
                    ref="form-search-checkin"
                    method="POST"
                    data-vv-scope="form-search-checkin"
                    autocomplete="off"
                >
                    <div class="form-row align-items-center">
                        <div class="form-group col-auto">
                        <label class="col-sm-2 col-form-label" for="inputEmail4">Inicio</label>
                            <div class="input-group mb-2">
                                <datepicker id="start" name="start" :format="customFormatter" :language="ptBR"></datepicker>
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                </div>
                                
                            </div>
                            
                        </div>
                        <div class="form-group col-auto">
                            <label class="col-sm-2 col-form-label" for="inputEmail4">Fim</label>
                            <div class="input-group mb-2">
                                <datepicker id="end" name="end" :format="customFormatter" :language="ptBR"></datepicker>
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                </div>                                
                            </div>

                        </div>

                        <div class="col-auto">
                            <button class="btn btn-primary" type="button" @click="$refs.checkin.search('form-search-checkin', '/checkin/list')"><i class="fas fa-search"></i></button>
                        </div>

                    </div>
                </form>
            </nav>        
            
        </div>
        <div class="col-md-12">
            <table-pagination-component        
                ref="checkin"
                :name="'checkin'"         
                :per-page="20" 
                :url="'/checkin/list/'"
                :new="false"
                :fields="[
                    { 'key' : 'id', 'sortable' : true, 'label' : '#' },
                    { 'key' : 'user', 'sortable' : true, 'label' : 'Aluno', 'type': 'object' },
                    { 'key' : 'class', 'sortable' : true, 'label' : 'Modalidade', 'type': 'object' },
                    { 'key' : 'created_at', 'sortable' : true, 'label' : 'Data' },
                ]"
            >         
            </table-pagination-component> 
        </div>    
    </div>
</div>
@endsection
