@extends('layouts.tabletDesktopArtifact')

@section('content')
<div class="container">

<div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="text-center">
                    <h2>{{ $pageTitle }}</h2>
                </div>
            </div>
        </div>

		<div class="row">
			<div class="col-md-10">
				{{ Form::label('TAG', null, ['class' => 'control-label']) }}
        		<div id="grade-tags"></div>
        	</div>
        </div>
</div>
@endsection