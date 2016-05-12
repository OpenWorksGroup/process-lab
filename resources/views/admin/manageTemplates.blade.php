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
                    <a class="btn btn-default" href="/admin/template" role="button">Add New Template</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                         <th>Created</th>
                        <th>Updated</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($templates as $template)
                        <tr>
                            <td>{{ $template->title }}</td>
                            <td>{{ $template->status }}</td>
                            <td>{{ $template->creator }}</td>
                            <td>{{ $template->updator }}</td>
                            <td>{{ $template->created_at }}</td>
                            <td>{{ $template->updated_at }}</td>
                            @if ($template->status == "active")
                                <td colspan="2"><a class="btn btn-default disabled" href="/admin/template/{{ $template->id }}" role="button">Edit</a></td>
                            @else
                            <td colspan="2"><a class="btn btn-default\" href="/admin/template/{{ $template->id }}" role="button">Edit</a></td>
                            @endif <!-- do this cleanr -->
                        </tr>
                    @endforeach 
                </tbody>                      
            
            </table>        
    
@endsection