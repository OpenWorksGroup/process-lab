@extends('layouts.app')

@section('content')

<div class="container vertical-t-spacer-40">
    <div class="row">
        <div class="col-md-10">
            <div class="text-center">
                <h2>{{ $pageTitle }}</h2>
            </div>
        </div>
    </div>

    <div class="row vertical-tb-spacer-40">
        <div class="col-md-10 scrollable">
			@include('partials.artifactContentDisplay')
   	 	</div>
   	</div>

   	<div class="row vertical-tb-spacer-20">
		<div class="col-md-10">
			<h4>Review</h4>
		</div>
	</div>

   	<div class="row vertical-spacer-20">
		<div class="col-md-10">
			<div><a href="{{ $rubricLink}}" target="blank">Competency Rubric</a></div>
		</div>
	</div>

    @if(count($sectionsFeedback) > 0)
        <div class="row">
            <div class="col-md-10">
                <h4>Collaborative Feedback</h4>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">

            @foreach($sectionsFeedback as $section)
                <div class="row">
                    <div class="col-md-10">
                        <div class="vertical-tb-spacer-20"><h5>{{ $section['sectionTitle'] }}</h5></div>
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

            </div>
        </div>
    @endif

	@if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @elseif($alreadySubmitted)
		<div class="alert alert-warning" role="alert">
            {{ $alreadySubmitted }}
        </div>
	@elseif(Session::has('alreadySubmitted'))
		<div class="alert alert-warning" role="alert">
            {{ Session::get('alreadySubmitted') }}
        </div>
    @else

    	<div class="row">
			<div class="col-md-10">
				{{ Form::open(array('action' => 'Artifact\ReviewerController@store')) }}
    			{!! Form::hidden('contentId', $contentId ) !!}
    			{!! csrf_field() !!}
			
				<div class="row">
					<div class="col-md-2"><strong>Competency</strong></div>
					@foreach($competencyHeaders as $header)
                    	<div class="col-md-2 text-center"><strong>{{ $header }}</strong></div>
                	@endforeach
            	</div>

				@foreach($rubrics as $rubric)
					<div class="row form-group{{ $errors->has('category_'.$rubric['category_id']) ? ' has-error' : '' }}">
					@if ($errors->has('category_'.$rubric['category_id']))
							<span class="help-block">
                				<strong>{{ $errors->first('category_'.$rubric['category_id']) }}</strong>
                  			</span>
                		@endif
						<div class="col-md-2">{{ $rubric['category'] }}</div>
						<div class="col-md-2 text-center">{{ Form::radio('category_'.$rubric['category_id'],'1') }}</div>
						<div class="col-md-2 text-center">{{ Form::radio('category_'.$rubric['category_id'],'2') }}</div>
						<div class="col-md-2 text-center">{{ Form::radio('category_'.$rubric['category_id'],'3') }}</div>
						<div class="col-md-2 text-center">{{ Form::radio('category_'.$rubric['category_id'],'4') }}</div>
					</div>
					
				@endforeach

				<div class="row form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
					<div class="col-md-10">           
                		{{ Form::label('Comments', null, ['class' => 'control-label']) }}
                		{{ Form::textarea('comment', null, array('class' => 'form-control')) }}
                        @if ($errors->has('comment'))
                            <span class="help-block">
                                <strong>{{ $errors->first('comment') }}</strong>
                            </span>
                        @endif
        			</div>
    			</div>



    			<div class="row  vertical-spacer-20">
        			<div class="col-md-10">
            			<button data-toggle="modal" data-target="#reviewModal"class="btn btn-primary">
                			Submit Review
            			</button>
        			</div>
    			</div>
    			{!! Form::close(); !!}

    		</div>
    	</div>
    @endif

    @include('partials.confirmReviewModal')

</div>
@endsection