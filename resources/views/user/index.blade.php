@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">        
        <div class="col-md-12">
            <h2>Usuários</h2>
            <table-pagination-component 
                :per-page="1" 
                :items="{{$items}}"
                :fields="{{$fields}}"
            >
            
            </table-pagination-component>
        </div>
    </div>
</div>
@endsection
