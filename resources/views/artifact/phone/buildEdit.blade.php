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

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    {{ Form::open(array('action' => 'Artifact\BuilderController@store')) }}
    {!! Form::hidden('templateId', $templateId ) !!}
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

    <div class="row vertical-spacer-40">
        <div class="col-md-10">
            <br/>
            <button type="submit" class="btn btn-primary">
                Update
            </button>
        </div>
    </div>
    {!! Form::close(); !!}


    @foreach($sections as $section)
        <div class="row">
            <div class="col-md-12">
                <div class="phoneLinks"><a href="/artifact/{{ $contentId }}/{{ $section->id }}">{{ $section->section_title }}</a></div>
            </div>
        </div>
    @endforeach


    <div class="row">
        <div class="col-md-12">
            <div class="phoneLinks"><a href="{{ $tagsLink }}">Tag</a></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="phoneLinks"><a href="{{ $collaborateLink }}">Collaborate</a></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="phoneLinks"><a href="{{ $notesLink }}">Notes from the field</a></div>
        </div>
    </div>

</div>
@endsection