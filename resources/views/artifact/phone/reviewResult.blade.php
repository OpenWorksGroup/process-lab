@extends('layouts.phoneArtifact')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="text-center">
                <h2>{{ $pageTitle }}</h2>
            </div>
        </div>
    </div>
    @if(count($fieldsMissing) > 0)
        <div class="row">
            <div class="col-md-10">
                <div>
                    <p>To submit for review, please check the required fields:</p>
                    @include('partials.checkFieldsRequired')
                </div>
            </div>
        </div>
    @else 
        <div class="row">
            <div class="col-md-10">
                <div class="text-center">
                    <h4>Your content has been submitted for review. Please check your dashboard for updates.</h4>
                </div>
            </div>
        </div>
    @endif  
</div>
@endsection