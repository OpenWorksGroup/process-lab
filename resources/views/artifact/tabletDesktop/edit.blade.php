@extends('layouts.tabletDesktopArtifact')

@section('content')

@include('partials.artifactPublishConfirmModal')

<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="text-center">
                <h2>{{ $pageTitle }}</h2>
                <h5>{{ $sectionDescription }}</h5>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <div class="text-right">
                <div id="feedback-switch"
                data-contentId="{{ $contentId }}" 
                data-sectionId="{{ $sectionId }}"
                data-sectionComments="{{ $sectionsComments }}">
                </div> 
            </div>
        </div>
    </div>


    <div id="section-fields" 
    data-contentId="{{ $contentId }}" 
    data-sectionId="{{ $sectionId }}" 
    data-loadInfo="{{ $loadInfo }}">
    </div>

</div>
@endsection