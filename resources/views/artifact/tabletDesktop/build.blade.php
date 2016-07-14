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


    {!! Form::model($content, ['action' => 'Artifact\BuilderController@store']) !!}
    {!! Form::hidden('templateId', $templateId ) !!}
    @if ($contentId)
        {!! Form::hidden('contentId', $contentId ) !!}
    @endif
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
            @if ($loadInfo['course_id'])
        		<div><strong>Course: </strong><a href="{{ $loadInfo['course_url'] }}" target="blank">{{ $loadInfo['course_title'] }}</a></div>
            @endif
            @if ($loadInfo['rubric_link'])
        		<div><a href="{{ $loadInfo['rubric_link'] }}" target="blank">Comptency Rubric</a></div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <br/>
            <button type="submit" class="btn btn-primary">
                Next <i class="fa fa-btn fa-arrow-right"></i>
            </button>
        </div>
    </div>
    {!! Form::close(); !!}

</div>
@endsection