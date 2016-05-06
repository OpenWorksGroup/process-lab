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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/tag') }}/{{ $tag->id }}">
                    {!! csrf_field() !!}
                
                    <div class="form-group{{ $errors->has('tag') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Edit</label>

                        <div class="col-md-8">
                            <input type="input" class="form-control" name="tag" value="{{ $tag->tag }}">

                            @if ($errors->has('tag'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tag') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <input type="hidden" name="_method" value="PATCH">
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