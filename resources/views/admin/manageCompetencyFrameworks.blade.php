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
                    <a class="btn btn-default" href="/admin/competency-framework/create" role="button">Add New Framework</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Framework</th>
                            <th>Created By</th>
                        <!--   <th>Updated By</th> -->
                            <th>Created</th>
                        <!--  <th>Updated</th> -->
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($frameworks as $framework)
                            <tr>
                                <td>{{ $framework->framework }}</td>
                                <td>{{ $framework->creator }}</td>
                            <!--  <td>{{ $framework->updator }}</td> -->
                                <td>{{ $framework->created_at }}</td>
                            <!--  <td>{{ $framework->updated_at }}</td>-->
                                <td colspan="2"><a class="btn btn-default disabled" href="/admin/competency-framework/{{ $framework->id }}" role="button">Edit</a></td>
                            </tr>
                        @endforeach 
                    </tbody>                                  
                </table>        
            </div>
        </div>    
     </div>       
    
@endsection