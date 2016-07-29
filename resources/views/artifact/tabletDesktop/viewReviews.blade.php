@extends('layouts.tabletDesktopArtifact')

@section('content')

@include('partials.artifactPublishConfirmModal')

<div class="container">
    <div class="row vertical-spacer-40">
        <div class="col-md-10">
            <div class="text-center">
                <h2>{{ $pageTitle }}</h2>
            </div>
        </div>
    </div>

    @if(empty($reviewContent))
		<div class="row">
        	<div class="col-md-10">
            	<div class="text-center">
                	<h4>No reviews are available yet.</h4>
            	</div>
        	</div>
    	</div>
    @else
        @foreach($reviewContent as $review) 
			<div class="row vertical-spacer-40">
                <div class="col-md-10">
                    @foreach($review['data'] as $data) 
                       <div class="row vertical-spacer-20">
                            <div class="col-md-10">
                                <strong>{{ $data['competency'] }}: </strong> {{ $data['description'] }}
                            </div>
                        </div>    
                     @endforeach   
                    <div><strong>Comments: </strong> {!! $review['comment'] !!}</div>
                </div>
            </div>
            <div class="row vertical-spacer-40">
                <div class="col-md-10 text-center">
                    <div><hr></div>
                </div>
            </div>

        @endforeach
    @endif
</div>
@endsection