@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center">Welcome {{ Auth::user()->name }}</div>

                <div class="panel-body">
                    <div>
                        <a class="btn btn-default" href="/admin/register-user" role="button">Register User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
