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
                <div>
                    <a class="btn btn-default" href="/admin/users/create" role="button">Add New User</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Profile Url</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Last Login</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->profile_url }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->updated_at }}</td>
                            <td>{{ $user->last_login_at }}</td>
                            <td><a class="btn btn-default" href="/admin/users/{{ $user->id }}" role="button">Edit Roles</a><!-- Delete--></td>
                        </tr>
                    @endforeach 
                </tbody>                      
            
            </table>        
    
@endsection