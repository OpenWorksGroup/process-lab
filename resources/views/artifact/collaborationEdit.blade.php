@extends('layouts.adminApp')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="text-center">
                <h2>{{ $pageTitle }}</h2>
            </div>
        </div>
    </div>

    @if(empty($feedback))
		<div class="row">
        	<div class="col-md-10">
            	<div class="text-center">
                	<h4>No feedback is requested at this time.</h4>
            	</div>
        	</div>
    	</div>

    @else

    	@foreach($loadInfo['fields'] as $field)

    	   <div class="row">
                <div class="col-md-10">
                    <div class="vertical-tb-spacer-40"><h4>{{ $field['field_title'] }}</h4></div>
                </div>
            </div>
            @if(!empty($field['text']))
                @foreach($field['text'] as $text)
                    <div class="row">
                        <div class="col-md-10">
                            <div>{!! $text->content !!}</div>
                        </div>
                    </div>
                @endforeach
            @endif

            @if(!empty($field['links']))
                @foreach($field['links'] as $link)
                    <div class="row">
                        <div class="col-md-10">
                            <div><a href="{{ $link->uri}}" target="_blank">{{ $link->uri}}</a></div>
                        </div>
                    </div>
                @endforeach
            @endif

            @if(!empty($field['files']))
                <div id="content-files" data-files="{{$field['files']}}"></div>
            @endif

    	@endforeach

    	@if(!empty($comments))
			<div class="row">
                <div class="col-md-10">
                    <div><h3>Comments</h3></div>
                </div>
            </div>

             @foreach($comments as $comment)
                    <div class="row">
                        <div class="col-md-10">
                            <div>{{ $comment['comment_date'] }}</div>
                            <div  class="vertical-spacer-20"><strong>{{  $comment['userName'] }}</strong></div>
                            <div>{!! $comment['comment'] !!}</div>
                            </div>
                    </div>
                @endforeach
    	@endif

		{{ Form::open(array('action' => 'Artifact\CollaborationController@store')) }}
		{!! Form::hidden('contentId', $contentId ) !!}
		{!! Form::hidden('sectionId', $sectionId ) !!}
		{!! csrf_field() !!}

		<div class="vertical-spacer-40">     
			@if(Session::has('success'))
        		<div class="alert alert-success" role="alert">
            		{{ Session::get('success') }}
        		</div>
    		@endif
    	</div>
		<div class="row">
			<div class="col-md-12">
            	<div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">            
                	{{ Form::label('Add your feedback:', null, ['class' => 'control-label']) }}
                	{{ Form::textArea('comment', null, array('class' => 'form-control')) }}
                	@if ($errors->has('comment'))
                    	<span class="help-block">
                        	<strong>{{ $errors->first('comment') }}</strong>
                    	</span>
                	@endif
            	</div>
        	</div>
    	</div>

		<div class="row vertical-spacer-40">
        	<div class="col-md-10">
            	<br/>
            	<button type="submit" class="btn btn-primary">
                	Submit
            	</button>
        	</div>
    	</div>
    {!! Form::close(); !!}

    @endif


</div>
@endsection