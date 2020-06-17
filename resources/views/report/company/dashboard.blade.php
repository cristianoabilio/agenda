<div class="row justify-content-center">
        <div class="col-md-12">
            <h2></h2>
        </div>

        <div class="row justify-content-left">
        <div class="col-md-12 bg-light">
        <div class="card-columns">
            <div class="card">
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
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-right">                        
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Valores">Média de Alunos por aula</h5>
                    <h3 class="mt-3 mb-3 text-info">{{ number_format($average, 2, '.', '') }}</h3> 
                </div> <!-- end card-body-->
            </div>
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-right">                        
                        <i class="fas fa-award"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Top 3 Turmas">Top 3 Turmas</h5>
                    <ul class="list-group list-group-flush">
                    @foreach ($ranking as $class)
                    
                        <li class="list-group-item d-flex justify-content-between align-items-center text-secondary">
                            <span class="badge badge-warning badge-pill"><i class="fas fa-music"></i> {{$class->modality->modality->name }} - {{$class->start }}</span>
                            <span class="badge badge-primary badge-pill"> {{ (new \App\Helpers\Date)->weekday($class->weekday) }}</span>
                            <p class="p-3 mb-2 text-info">{{ substr($class->teacher->name, 0, 10) }}...</p>
                        </li>


                    @endforeach
                    </ul>
                    <p class="mb-0 text-muted">
                        <span class="text-nowrap small">Nos últimos 30 dias em R$</span>  
                    </p>
                </div> <!-- end card-body-->
            </div> 
            </div>    
    </div>
    </div>    
    </div>    

    <div class="row justify-content-left">
        <div class="col-md-12 bg-light">
            <div class="float-right">            
                <i class="fas fa-chart-bar"></i>        
            </div>
            <h5 class="text-muted font-weight-normal mt-0">Estatísticas</h5>
        </div>
        <div class="col-md-12">
            <div class="nav nav-pills col-md-8" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Modalidades</a>
                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Check in</a>
                <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Planos</a>
            </div>
            <div class="tab-content col-md-8" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <bar-graph-component />   
                </div>
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <bubble-graph-component />  
                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <line-graph-component />    
                </div>
            </div>
        </div>    
    </div>