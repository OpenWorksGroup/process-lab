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
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/edit-user') }}">
                    {!! csrf_field() !!}
                
                    <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Roles</label>

                        <div class="col-md-8">
                            @foreach ($roles as $role)
                                <label>
                                    <input class="checkbox-inline" type="checkbox" class="form-control" name="roles[]" value="{{ $role->name }}" @if ($role->user == true)checked @endif> {{ $role->name }}
                                </label>
                            @endforeach
                            @if ($errors->has('roles'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('roles') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <input type="hidden" name="userId" value="{{ $userId }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i>Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
      
    
@endsection