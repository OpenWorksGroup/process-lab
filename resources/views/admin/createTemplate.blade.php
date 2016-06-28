@extends('layouts.adminApp')

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
                <div id="formSavedNotice"></div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                
                <div id="template"></div>
 
            </div>
        </div>
    </div>    
@endsection