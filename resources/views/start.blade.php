@extends('layouts.adminApp')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Welcome to Process Lab</h2>
                <div>
                    Let's get started by entering the information below:
                </div>
            </div>
        </div>
         <div class="row">
             <div class="col-md-12">
                 {!! Form::open(array('url' => '/register')) !!}      
                 {!! Form::hidden('site', 'new') !!}

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
                    
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {{ Form::label('Admin Name', null, ['class' => 'control-label']) }}
                    {{ Form::text('name', null, array('class' => 'form-control')) }}
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                    
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    {{ Form::label('Admin E-Mail Address', null, ['class' => 'control-label']) }}
                    {{ Form::email('email', null, array('class' => 'form-control')) }}
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                    
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    {{ Form::label('Password', null, ['class' => 'control-label']) }}
                    {{ Form::password('password', null, array('class' => 'form-control')) }}
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                    
                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    {{ Form::label('Confirm Password', null, ['class' => 'control-label']) }}
                    {{ Form::password('password_confirmation', null, array('class' => 'form-control')) }}
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                    
                <div class="form-group{{ $errors->has('profile_url') ? ' has-error' : '' }}">
                    {{ Form::label('Admin Profile Url', null, ['class' => 'control-label']) }}
                    {{ Form::text('profile_url', null, array('class' => 'form-control')) }}
                    @if ($errors->has('profile_url'))
                        <span class="help-block">
                            <strong>{{ $errors->first('profile_url') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-user"></i> Submit
                    </button>
                </div>
                    
                {!! Form::close(); !!}
            </div>
        </div>
    </div>

@endsection
