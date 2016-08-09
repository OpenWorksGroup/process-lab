@extends('layouts.tabletDesktopArtifact')

@section('content')

@include('partials.artifactPublishConfirmModal')

<div class="container vertical-t-spacer-40">
    <div class="row">
        <div class="col-md-6">
            <div class="text-center">
                <h2>{{ $pageTitle }}</h2>
            </div>
        </div>
    </div>

    <div id="tags" 
    data-contentId="{{ $contentId }}" 
    data-tags="{{ $tags }}">
    </div>
</div>

@endsection