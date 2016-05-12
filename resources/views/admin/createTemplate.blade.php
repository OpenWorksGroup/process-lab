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
     
                {!! Form::open(array('action' => 'Admin\TemplateCreateController@store')) !!}  
                
                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    {{ Form::label('Title', null, ['class' => 'control-label']) }}
                    {{ Form::text('title', null, array('class' => 'form-control')) }}
                    @if ($errors->has('title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
                
                <div class="form-group{{ $errors->has('required_num_reviews') ? ' has-error' : '' }}">
                    {{ Form::label('Designate Number of Reviewers', null, ['class' => 'control-label']) }}
                    {{ Form::text('required_num_reviews', "3", array('class' => 'form-control')) }}
                    @if ($errors->has('required_num_reviews'))
                        <span class="help-block">
                            <strong>{{ $errors->first('required_num_reviews') }}</strong>
                        </span>
                    @endif
                </div>
                
                <div class="form-group{{ $errors->has('tags') ? ' has-error' : '' }}">
                    {{ Form::label('Tags', null, ['class' => 'control-label']) }}
                    {{ Form::text('tags', "Start typing tags here...", array('class' => 'form-control')) }}
                    @if ($errors->has('tags'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tags') }}</strong>
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