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
                @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">               
                <div id="competency-framework-editor" 
                data-frameworkId="{{ $cfId }}"
                data-frameworkName="{{ $frameworkName }}"
                data-categories="{{ $categories }}"></div> 
            </div>
        </div>
    </div>    
@endsection