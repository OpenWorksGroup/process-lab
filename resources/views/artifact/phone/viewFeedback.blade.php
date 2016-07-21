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

    @if($sections)
        @foreach($sections as $section)
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

	@if(empty($sectionsFeedback))
		<div class="row">
        	<div class="col-md-10">
            	<div class="text-center">
                	<h4>No feedback is available yet.</h4>
            	</div>
        	</div>
    	</div>
    @else

    	@foreach($sectionsFeedback as $section)
    		<div class="row">
               	<div class="col-md-10">
                	<div class="vertical-tb-spacer-40"><h3>{{ $section['sectionTitle'] }}</h3></div>
                </div>
            </div>

          	@foreach($section['comments'] as $comment) 
				<div class="row">
                    <div class="col-md-10">
                        <div><strong>{{  $comment['userName'] }}</strong></div>
                        <div>{{  $comment['comment'] }}</div>
                    </div>
                </div>
          	@endforeach

    	@endforeach
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="phoneLinks"><a href="{{ $notesLink }}">Notes from the field</a></div>
        </div>
    </div>
</div>


</div>
@endsection