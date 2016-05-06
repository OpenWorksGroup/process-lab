@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h2>{{ $pageTitle }}</h2>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
               
 
               <p>{{ $message }}</p>
                   
                @if (isset($error)) 
                <p>Error: {{ $error }}</p>
                @endif
                
               @if (isset($returnUrl))
               <p>Click <a href="{{ $returnUrl }}">here</a> to return to {{ $consumerName }}.</p>
               @endif
        </div>
    </div>
      
    
@endsection