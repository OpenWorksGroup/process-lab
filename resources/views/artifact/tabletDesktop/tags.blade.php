@extends('layouts.tabletDesktopArtifact')

@section('content')

@include('partials.artifactPublishConfirmModal')

<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="text-center">
                <h2>{{ $pageTitle }}</h2>
            </div>
        </div>
    </div>

    <div id="tags" 
    data-contentId="{{ $contentId }}" 
    data-tags="{{ $tags }}">
    </div>


@endsection