<div class="row justify-content-center">
        <div class="col-md-12">
            <h2></h2>
        </div>

        <div class="card-columns">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-right">                        
                        <i class="fas fa-list"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Top 3 Turmas">Planos</h5>
                    <plan-list-component ref="plan"></plan-list-component>                    
                    
                </div> <!-- end card-body-->
            </div> 

            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">Acadêmias Visitadas</h5>
                    <h3 class="mt-3 mb-3 text-info">{{$companies}}</h3>
                </div> <!-- end card-body-->
            </div>  

            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-right">                        
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Valores">Aulas realizadas</h5>
                    <h3 class="mt-3 mb-3 text-info">{{ $totalCheckins }}</h3> 
                </div> <!-- end card-body-->
            </div>

            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-right">                        
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Planos">Histórico</h5>
                    <ul class="list-group bg-success">
                        @foreach ($checkins as $checkin)
                            <li class="list-group-item d-flex justify-content-between align-items-center text-secondary">                                                            
                                <span class="badge badge-warning badge-pill"><i class="fas fa-music"></i> {{ $checkin->class->modality->modality->name }} - {{ substr($checkin->class->start, 0, 5) }} </span>                                                        
                                <p class="p-3 mb-2 text-info"><span class="text-nowrap small">{{ substr($checkin->class->teacher->company->name, 0, 15) }}</span></p>
                                <small> <span class="badge badge-info badge-pill">{{   Carbon\Carbon::parse($checkin->created_at)->format('d/m/Y H:i')   }}</span> </small>
                            </li>
                        @endforeach
                    </ul> 
                </div> <!-- end card-body-->
            </div>
            


        </div>    
    
        <div class="row justify-content-center">   
            <div class="col-md-12">                             
                <b-modal id="create" title="Check in">                
                    @include("checkin.forms.user.create")
                </b-modal>
            </div>
        </div>
    
    
    
    </div>

    