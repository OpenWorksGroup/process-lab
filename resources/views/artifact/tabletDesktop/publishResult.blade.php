@extends('layouts.tabletDesktopArtifact')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="text-center">
                <h2>{{ $pageTitle }}</h2>
            </div>
        </div>
    </div>
    @if($status=="edit")
        <div class="row">
            <div class="col-md-10">
                <div>
                    <p>To publish, please check the required fields:</p>
                    <ul>
                    @foreach($fieldsMissing as $field)
                    <li><a href="/artifact/{{ $contentId }}/{{ $field['section_id'] }}">
                    {{ $field['section_title'] }} - {{ $field['field_title'] }}</a></li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @else 
        <div class="row">
            <div class="col-md-10">
                <div class="text-center">
                    <h4>View your published content <a href="/artifact/{{ $contentId }}"><strong>here</strong></a></h4>
                </div>
            </div>
        </div>
    @endif  
</div>
@endsection