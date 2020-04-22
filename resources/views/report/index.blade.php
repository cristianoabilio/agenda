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
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-right">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">Visitantes</h5>
                    <h3 class="mt-3 mb-3 text-info">{{$visitors}}</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-nowrap small">Nos últimos 30 dias</span>  
                    </p>
                </div> <!-- end card-body-->
            </div>   
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-right">
                        <i class="fas fa-cart-plus"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Planos">Planos</h5>
                    <h3 class="mt-3 mb-3 text-success">{{$total}}</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-nowrap small">Nos últimos 30 dias</span>  
                    </p>
                </div> <!-- end card-body-->
            </div>
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-right">                        
                        <i class="fas fa-money-bill-alt"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Valores">Valores</h5>
                    <h3 class="mt-3 mb-3 text-success">{{ number_format($money, 2, ',', '.') }}</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-nowrap small">Nos últimos 30 dias em R$</span>  
                    </p>
                </div> <!-- end card-body-->
            </div>
        </div>
    </div>
</div>
@endsection
