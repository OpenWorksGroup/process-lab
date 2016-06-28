@extends('layouts.adminApp')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading text-center">Welcome {{ Auth::user()->name }}</div>

                <div class="panel-body">
                    <div>
                        <a class="btn btn-default" href="/admin/settings" role="button">Manage Site Settings</a>
                    </div>
                    <br/>
                    <div>
                        <a class="btn btn-default" href="/admin/users" role="button">Manage Users</a>
                    </div>
                    <br/>
                    <div>
                        <a class="btn btn-default" href="/admin/tags" role="button">Manage Tags</a>
                    </div>
                    <br/>
                    <div>
                        <a class="btn btn-default" href="/admin/templates" role="button">Manage Templates</a>
                    </div>
                    <br/>
                    <div>
                        <a class="btn btn-default" href="/admin/competency-frameworks" role="button">Manage Competency Frameworks</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
