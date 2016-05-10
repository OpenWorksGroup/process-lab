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
     
                {!! Form::open(array('action' => 'Admin\TagCreateController@store')) !!}  
        
                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                    {{ Form::label('Type', null, ['class' => 'control-label']) }}
                    {{ Form::select('type', array('user' => 'user', 'content' => 'content'), null, ['placeholder' => 'Choose a type']) }}

                    @if ($errors->has('type'))
                    <span class="help-block">
                        <strong>{{ $errors->first('type') }}</strong>
                    </span>
                    @endif
                </div>
                
            <!--    <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                    {{ Form::label('Label (optional)', null, ['class' => 'control-label']) }}
                    {{ Form::text('label', null, array('class' => 'form-control')) }}
                    @if ($errors->has('label'))
                        <span class="help-block">
                            <strong>{{ $errors->first('label') }}</strong>
                        </span>
                    @endif
                </div>-->
                
                <div class="form-group{{ $errors->has('tag') ? ' has-error' : '' }}">
                    {{ Form::label('Tag', null, ['class' => 'control-label']) }}
                    {{ Form::text('tag', null, array('class' => 'form-control')) }}
                    @if ($errors->has('tag'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tag') }}</strong>
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