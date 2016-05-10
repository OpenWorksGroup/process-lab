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
                <div>
                    <a class="btn btn-default" href="/admin/tag" role="button">Add New Tag</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tag</th>
                        <th>Label</th>
                        <th>Type</th>
                        <th>Created By</th>
                         <th>Created</th>
                        <th>Updated</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tags as $tag)
                        <tr>
                            <td>{{ $tag->tag }}</td>
                            <td>{{ $tag->label }}</td>
                            <td>{{ $tag->type }}</td>
                            <td>{{ $tag->creator }} ({{ $tag->created_by }})</td>
                            <td>{{ $tag->created_at }}</td>
                            <td>{{ $tag->updated_at }}</td>
                            <td colspan="2"><a class="btn btn-default" href="/admin/tag/{{ $tag->id }}" role="button">Edit Tag</a></td>
                        </tr>
                    @endforeach 
                </tbody>                      
            
            </table>        
    
@endsection