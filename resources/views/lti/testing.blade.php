@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $pageTitle }}</div>

                <div class="panel-body">
                     {{ var_dump($input) }}            
                </div>
            </div>
        </div>
    </div>
</div>
@endsection