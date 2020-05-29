@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>Planos</h2>   
            <h3 class="small">Histórico</h3>         
        </div>
    </div>
    <div class="row justify-content-center">   
        <div class="col-md-12">     
            <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
            <!-- Navbar content -->
                <form 
                    id="form-search-plan"
                    ref="form-search-plan"
                    method="POST"
                    data-vv-scope="form-search-plan"
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

                        <div class="form-group col-auto">
                            <label class="col-sm-2 col-form-label" for="inputEmail4">Plano</label>
                            <div class="input-group mb-2">
                                <select name="plan_id" id="plan_id" class="form-control">
                                    <option value=""></option>
                                    @foreach ($plans as $p)
                                        <option value="{{$p->id}}">{{ $p->name }} {{ $p->description }}</option>
                                    @endforeach
                                </select>
                            </div>    
                        </div>

                        <div class="col-auto">
                            <button class="btn btn-primary" type="button" @click="$refs.plan.search('form-search-plan', '/user-plan/history/')"><i class="fas fa-search"></i></button>
                        </div>

                    </div>
                </form>
            </nav>        
            
        </div>
        <div class="col-md-12">
            <table-pagination-component        
                ref="plan"
                :name="'plan'"         
                :per-page="20" 
                :url="'/user-plan/history/'"
                :new="false"
                :fields="[
                    { 'key' : 'id', 'sortable' : true, 'label' : '#' },
                    { 'key' : 'user', 'sortable' : true, 'label' : 'Aluno', 'type': 'object' },
                    { 'key' : 'plan', 'sortable' : true, 'label' : 'Plano', 'type': 'object' },
                    { 'key' : 'price', 'sortable' : true, 'label' : 'Valor' },
                    { 'key' : 'discount', 'sortable' : true, 'label' : 'Desconto' },
                    { 'key' : 'created_at', 'sortable' : true, 'label' : 'Data' },
                ]"
            >         
            </table-pagination-component> 
        </div>    
    </div>
</div>
@endsection
