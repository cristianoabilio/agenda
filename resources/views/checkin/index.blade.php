@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>Check-in</h2>
            <checkin-component
                :url="'/checkin/list/'"
            ></checkin-component>

            <b-modal id="create" title="Empresa"

            >                
            </b-modal>
            <b-modal id="edit"  title="Empresa"

            >                
            </b-modal>

            <b-modal id="delete"  title="Empresa" body-text-variant="danger"

            >                
            </b-modal>            
        </div>
    </div>
</div>
@endsection
