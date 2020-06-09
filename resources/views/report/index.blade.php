@extends('layouts.app')

@section('content')


<div class="container">

    @if (Auth::user()->profile_id == \App\Models\Profile::RESPONSABLE) 
        <!-- Dashboard Academia -->
        @include("report.company.dashboard")   
        <!-- Edn Dashboard Academia -->

    @elseif (Auth::user()->profile_id == \App\Models\Profile::TEACHER)    
        @include("report.teacher.dashboard")   
    @elseif (Auth::user()->profile_id == \App\Models\Profile::STUDENT)
        @include("report.user.dashboard")   
    @endif



            
               

</div>
@endsection
