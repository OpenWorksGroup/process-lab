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
                    <h4>Compelling Question</h4>
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
@endsection