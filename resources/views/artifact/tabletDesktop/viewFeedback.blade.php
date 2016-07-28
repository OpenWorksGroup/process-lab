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
                    	<div>{{ $comment['comment_date'] }}</div>
                        <div  class="vertical-spacer-20"><strong>{{  $comment['userName'] }}</strong></div>
                        <div>{!! $comment['comment'] !!}</div>
                    </div>
                </div>
          	@endforeach

    	@endforeach
    @endif
</div>
@endsection