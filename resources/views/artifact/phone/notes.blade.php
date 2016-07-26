@extends('layouts.phoneArtifact')

@section('content')

<div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="phoneLinks"><a href="{{ $buildLink }}">Build</a></div>
        </div>
    </div>
    
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

    <div class="vertical-spacer-40">&nbsp;</div>

    @if($otherSections)
        @foreach($otherSections as $section)
            <div class="row">
                <div class="col-md-12">
                    <div class="phoneLinks"><a href="/artifact/{{ $contentId }}/{{ $section->id }}">{{ $section->section_title }}</a></div>
                </div>
            </div>
        @endforeach
    @endif

       <div class="row">
        <div class="col-md-12">
            <div class="phoneLinks"><a href="{{ $tagsLink }}">Tag</a></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="phoneLinks"><a href="{{ $collaborateLink }}">Collaborate @if($commentsCount > 0)({{ $commentsCount }})@endif</a></div>
        </div>
    </div>

    @include('partials.artifactButtonsNav')

</div>

@endsection