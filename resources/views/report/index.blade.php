@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2></h2>
        </div>
        <div class="col-md-5 border border-info">
            <p class="">Modalidades</p>
            <bar-graph-component /> 

            </div>
        <div class="col-md-1">
        </div>    
        <div class="col-md-5 border border-warning">
            <p class="">Check in</p>

            <bubble-graph-component />            
        </div>
    </div>    
    <br />
    <div class="row justify-content-center">            
        <div class="col-md-5 border border-primary">
            <p class="">Planos</p>
            <line-graph-component />     
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5 border border-primary">
            <p class="">Planos</p>
            <line-graph-component />     
        </div>
    </div>
</div>
@endsection
