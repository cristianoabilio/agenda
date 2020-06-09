<div class="row justify-content-center">
        <div class="col-md-12">
            <h2></h2>
        </div>

        <div class="card-columns">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">Visitantes</h5>
                    <h3 class="mt-3 mb-3 text-info">{{ $visitors }}</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-nowrap small">Nos últimos 30 dias</span>  
                    </p>
                </div> <!-- end card-body-->
            </div>  

            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-right">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Planos">Alunos</h5>
                    <h3 class="mt-3 mb-3 text-success">{{$checkin}}</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-nowrap small">Nos últimos 30 dias</span>  
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
                        <i class="fas fa-calendar"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Top 3 Turmas">Minhas Turmas</h5>
                    <ul class="list-group list-group-flush">
                    @foreach ($classes as $class)                    
                        <li class="list-group-item bg-light d-flex justify-content-between align-items-center">
                            <span class="badge badge-warning badge-pill"><i class="fas fa-music"></i> {{$class->modality->modality->name }} - {{ substr($class->start, 0, 5) }}</span>
                            <span class="badge badge-primary badge-pill">{{ (new \App\Helpers\Date)->weekday($class->weekday) }}</span>
                        </li>
                    @endforeach
                    </ul>
                </div> <!-- end card-body-->
            </div> 
                
        </div> 
        <div class="card">
                <div class="card-body">
                    <div class="float-right">                                                
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Top 3 Turmas">Estatísticas</h5>
                    <div class="nav nav-pills col-md-8" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Modalidades</a>
                    </div>
                    <div class="tab-content col-md-8" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <bar-graph-component />   
                        </div>
                    </div>
                </div>
            
        </div>   

    
    </div>