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

         <div class="row">
			<div class="col-md-10">
            
                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <p>Q: This won't always be a lesson plan. Do we need a setting to set this or should we come up with something more generic?</p>
                    {{ Form::label('LESSON PLAN TITLE', null, ['class' => 'control-label']) }}
                    {{ Form::text('title', null, array('class' => 'form-control')) }}
                    @if ($errors->has('title'))
                       	<span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>

		<div class="row">
			<div class="col-md-10">
			<p>Q: Do we need these any longer since we have user tags for grade and subject?</p>
				{{ Form::label('TARGET GRADE LEVEL', null, ['class' => 'control-label']) }}
        		<div id="grade-tags"></div>
        	</div>
        </div>

        <div class="row">
			<div class="col-md-10">
				{{ Form::label('SUBJECT AREA', null, ['class' => 'control-label']) }}
        		<div id="subject-tags"></div>
        	</div>
        </div>

        <div class="row">
			<div class="col-md-10">
				{{ Form::label('MODULE', null, ['class' => 'control-label']) }}
        		<div>Engaging Students with Global Challenges</div>
        		<div><a href="#">Comptency Rubric</a></div>
        	</div>
        </div>

        <div class="row">
			<div class="col-md-10">
			<br/>
				<a href="/artifact-builder/ask" className="btn btn-default">Next ></a>
			</div>
		</div>	

</div>
@endsection