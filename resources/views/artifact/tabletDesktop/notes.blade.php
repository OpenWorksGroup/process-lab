@extends('layouts.tabletDesktopArtifact')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="text-center">
                <h2>{{ $pageTitle }}</h2>
            </div>
        </div>
    </div>

    <div id="notes" 
    data-contentId="{{ $contentId }}" 
    data-notes="{{ $note }}">
    </div>


@endsection