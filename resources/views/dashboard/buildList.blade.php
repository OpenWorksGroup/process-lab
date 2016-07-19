@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h2>{{ $pageTitle }}</h2>
                    <h4>Click on a template below to get started.</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>
                    @foreach($templates as $template)
                    <p><a href="/artifact-builder/{{$template->id}}">{{ $template->title }}</a></p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>     
</div>
@endsection