@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>Check-in</h2>
            <div class="overflow-auto"> 
                <div class="card rounded bg-white d-flex flex-row align-items-center mb-0 p-2">       
                    <div class="ml-auto">   
                        <button class="btn btn-primary" v-b-modal.create><i class="fas fa-save"></i> Novo</button>
                    </div>
                </div>              
            </div> 
        </div>
    </div>
    <div class="row justify-content-center">   
        <div class="col-md-12">             
            <checkin-component
                :url="'/checkin/list/'"
                :selected="{{$selected}}"
                ref="modalities"
            ></checkin-component>
            
            <b-modal id="create" title="Check in">                
                @include("checkin.forms.create")
            </b-modal>
        </div>
    </div>
</div>
@endsection
