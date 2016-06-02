@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h2>{{ $pageTitle }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
            
            {!! Form::model($settings, ['action' => 'Admin\SettingsController@update']) !!}
            
                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {{ Form::label('Site Title', null, ['class' => 'control-label']) }}
                    {{ Form::text('title', null, array('class' => 'form-control')) }}
                    @if ($errors->has('title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
            
                <div class="form-group{{ $errors->has('lti_consumer_name') ? ' has-error' : '' }}">
                    {{ Form::label('LTI Consumer Name', null, ['class' => 'control-label']) }}
                    {{ Form::text('lti_consumer_name', null, array('class' => 'form-control')) }}
                    @if ($errors->has('lti_consumer_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('lti_consumer_name') }}</strong>
                        </span>
                    @endif
                </div>
            
                <div class="form-group{{ $errors->has('lti_consumer_key') ? ' has-error' : '' }}">
                    {{ Form::label('LTI Consumer Key', null, ['class' => 'control-label']) }}
                    {{ Form::text('lti_consumer_key', null, array('class' => 'form-control')) }}
                    @if ($errors->has('lti_consumer_key'))
                        <span class="help-block">
                            <strong>{{ $errors->first('lti_consumer_key') }}</strong>
                        </span>
                    @endif
                </div>
            
                <div class="form-group{{ $errors->has('lti_secret') ? ' has-error' : '' }}">
                    {{ Form::label('LTI Secret', null, ['class' => 'control-label']) }}
                    {{ Form::text('lti_secret', null, array('class' => 'form-control')) }}
                    @if ($errors->has('lti_secret'))
                        <span class="help-block">
                            <strong>{{ $errors->first('lti_secret') }}</strong>
                        </span>
                    @endif
                </div>
            
                <div class="form-group">
                    <input type="hidden" name="_method" value="PATCH">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-user"></i> Submit
                    </button> 
                </div>
        
            {!! Form::close(); !!}
            
            </div>
        </div>
    </div>
@endsection