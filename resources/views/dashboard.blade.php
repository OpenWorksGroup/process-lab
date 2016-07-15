@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h2>{{ $userName }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <a class="btn btn-default" href="/build-list">Build a Lesson</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="tabContent" class="tab-content">
                    <ul id="dashboardTabs" class="nav nav-tabs" role="tablist">
                        <li>
                            <a href="#content" id="content" role="tab" data-toggle="tab" aria-controls="content" aria-expanded="true">My Published Content</a>
                        </li>
                        <li>
                            <a href="#progress" id="progress" role="tab" data-toggle="tab" aria-controls="progress" aria-expanded="true">Work in Progress</a>
                        </li>
                        <li>
                            <a href="#feedback" id="feedback" role="tab" data-toggle="tab" aria-controls="feedback" aria-expanded="true">Feedback Needed</a>
                        </li>           
                    </ul> 
                <div role="tabpanel" class="tab-pane fade" id="content" aria-labelledby="content"> 
                        <p>List of my published content</p> 
                </div>
                <div role="tabpanel" class="tab-pane fade" id="progress" aria-labelledby="progress"> 
                        <p>List of work in progress</p> 
                </div>
                <div role="tabpanel" class="tab-pane fade" id="feedback" aria-labelledby="feedback"> 
                        <p>List of feedback needed</p> 
                </div>
            </div>
        </div>
    </div>     
</div>
@endsection