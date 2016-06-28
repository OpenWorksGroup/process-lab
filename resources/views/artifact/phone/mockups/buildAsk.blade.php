@extends('layouts.phoneArtifact')

@section('content')
<div class="container">

	<div id="build"><h2>Build ></h2></div>
		<div id="build-section">
	
			<div id="ask"><h3>Ask ></h3>
				<div id="ask-section">
					<div class="row">
						<div class="col-md-10">
                			<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    			<h4>Compelling Question</h4>
                    			{{ Form::textArea('title', null, array('class' => 'form-control')) }}
                    			@if ($errors->has('title'))
                       			<span class="help-block">
                            		<strong>{{ $errors->first('title') }}</strong>
                        		</span>
                    		@endif
                		</div>
            		</div>

					<div class="row">
						<div class="col-md-10">
							{{ Form::label('website', null, ['class' => 'control-label']) }}
                			{{ Form::text('website', null, array('class' => 'form-control')) }}
        				</div>
        			</div>

        			<div class="row">
            			<div class="col-md-10">
                			{{ Form::label('video url', null, ['class' => 'control-label']) }}
                			{{ Form::text('video_url', null, array('class' => 'form-control')) }}
            			</div>
        			</div>

        			<div class="row">
            			<div class="col-md-10">
                			{{ Form::label('upload file', null, ['class' => 'control-label']) }}
                			{{ Form::file('file', null, array('class' => 'form-control')) }}
                			+ add another file
            			</div>
        			</div>
        			<div><br/></div>

        			<div class="row">
            			<div class="col-md-10">
                			<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    			<h4>Design Challenge</h4>
                    			{{ Form::textArea('title', null, array('class' => 'form-control')) }}
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
                			{{ Form::label('website', null, ['class' => 'control-label']) }}
                			{{ Form::text('website', null, array('class' => 'form-control')) }}
            			</div>
        			</div>

        			<div class="row">
            			<div class="col-md-10">
                			{{ Form::label('video url', null, ['class' => 'control-label']) }}
                			{{ Form::text('video_url', null, array('class' => 'form-control')) }}
            			</div>
        			</div>

        			<div class="row">
            			<div class="col-md-10">
                			{{ Form::label('upload file', null, ['class' => 'control-label']) }}
                			{{ Form::file('file', null, array('class' => 'form-control')) }}
                			+ add another file
            			</div>
        			</div>
        			<div><br/></div>
				</div>
			</div> <!-- end ask -->

			<div id="investigate"><h3>Investigate ></h3>
				<div id="investigate-section">
					<p>Investigate fields </p>
				</div>
			</div>

			<div id="synth"><h3>Synthesize/Create ></h3>
				<div id="synth-section">
					<p>Synthesize fields </p>
				</div>
			</div>

			<div id="share"><h3>Share ></h3>
				<div id="share-section">
					<p>Share fields </p>
				</div>
			</div>

			<div id="reflect"><h3>Reflect ></h3>
				<div id="reflect-section">
					<p>Reflect fields </p>
				</div>
			</div>
		</div>

	</div><!-- end build --> 

	<div id="tag"><h2>Tag ></h2></div>
	<div id="tag-section">
		<p>Tags here</p>
	</div>


	<div id="collaborate"><h2>Collaborate ></h2></div>
	<div id="collaborate-section">
		<p>Formative feedback here</p>
	</div>

	<div id="notes"><h2>Notes from the field ></h2></div>
	<div id="notes-section">
		<p>Notes here - Q: what is this section?</p>
	</div>

</div>
@endsection