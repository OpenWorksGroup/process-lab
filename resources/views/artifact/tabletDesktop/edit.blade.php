@extends('layouts.tabletDesktopArtifact')

@section('content')

@include('partials.artifactPublishConfirmModal')

<div class="container vertical-t-spacer-40">
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

   @if($nextSection)
   <div class="row">
        <div class="col-md-10 text-right vertical-spacer-40">
            <a href="/artifact/{{ $contentId }}/{{ $nextSection['id'] }}" class="btn btn-default"><i class="fa fa-arrow-right" aria-hidden="true"></i> {{  $nextSection['section_title'] }}</a>
        </div> 
    </div>
    @endif

</div>
@endsection