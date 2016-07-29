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

     @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif


    {!! Form::model($content, ['action' => 'Artifact\BuilderController@update']) !!}
    {!! Form::hidden('contentId', $contentId ) !!}
    {!! csrf_field() !!}
    <div class="row">
		<div class="col-md-10">
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">            
                {{ Form::label('TITLE', null, ['class' => 'control-label']) }}
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
            @if ($courseId)
        		<div><strong>Course: </strong><a href="{{ $courseUrl}}" target="blank">{{ $courseTitle }}</a></div>
            @endif
            @if ($rubricLink)
        		<div><a href="{{ $rubricLink }}" target="blank">Comptency Rubric</a></div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <br/>
            <button type="submit" class="btn btn-primary">
                Update
            </button>
        </div>
    </div>
    {!! Form::close(); !!}

</div>
@endsection