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
                <div class="text-warning">Please note: Any changes made here may be overidden by User Roles data set in the VIF Learning Center.</div>
                
                {!! Form::open(array('route' => array('user.update', $userId))) !!}
                
                <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
                    {{ Form::label('Roles', null, ['class' => 'control-label']) }}
                    @foreach ($roles as $role)
                        @if ($role->user == true)
                            {!! Form::checkbox("roles[]", "$role->name", true); !!} {{ $role->name }}
                        @else
                            {!! Form::checkbox("roles[]", "$role->name"); !!} {{ $role->name }}
                        @endif
                    @endforeach
                    @if ($errors->has('roles'))
                        <span class="help-block">
                            <strong>{{ $errors->first('roles') }}</strong>
                        </span>
                        @endif
                </div>
                <div class="row form-group">
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