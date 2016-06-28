@extends('layouts.adminApp')

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
                  {!! Form::model($tag, array('route' => array('tags.update', $tag->id))) !!}
                   
                  <div class="form-group{{ $errors->has('tag') ? ' has-error' : '' }}">
                      {{ Form::text('tag', null, array('class' => 'form-control')) }}
                      @if ($errors->has('tag'))
                          <span class="help-block">
                              <strong>{{ $errors->first('tag') }}</strong>
                          </span>
                      @endif
                  </div>
                  <div class="form-group">
                      <input type="hidden" name="_method" value="PATCH">
                      <button type="submit" class="btn btn-primary">
                          <i class="fa fa-btn fa-user"></i> Submit
                      </button>
                  </div>
              </div>
              {!! Form::close(); !!}
          </div>
      </div>
    </div>
    
@endsection