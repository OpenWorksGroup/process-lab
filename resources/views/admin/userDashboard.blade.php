@extends('layouts.adminApp')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $pageTitle }}</div>

                <div class="panel-body">
                     Welcome {{ $userName }}         
                </div>
            </div>
        </div>
    </div>
</div>
@endsection