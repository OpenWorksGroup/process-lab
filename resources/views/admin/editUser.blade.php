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

                <div class="text-warning">Please note: Any changes made here may be overidden by User Roles data set in the VIF Learning Center.</div>
                
                <form role="form" class="form" method="POST" action="{{ url('/admin/user') }}/{{ $userId }}">
                    {!! csrf_field() !!}
                
                    <div class="row form-group{{ $errors->has('roles') ? ' has-error' : '' }}">

                        <label class="col-md-2 control-label text-right">Roles</label>
                        <div class="col-md-10">
                            @foreach ($roles as $role)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="form-control" name="roles[]" value="{{ $role->name }}" @if ($role->user == true)checked @endif> {{ $role->name }}
                                </label>
                            </div>
                            @endforeach
                            @if ($errors->has('roles'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('roles') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row form-group">
                         <div class="col-md-8 col-md-offset-4">
                         <input type="hidden" name="_method" value="PATCH">
                             <button type="submit" class="btn btn-primary">
                                 <i class="fa fa-btn fa-user"></i> Submit
                             </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
      
    
@endsection