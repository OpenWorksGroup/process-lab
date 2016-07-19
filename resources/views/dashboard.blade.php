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
                <div class="vertical-spacer-40">
                    <a class="btn btn-default" href="/build-list">Build</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul id="dashboardTabs" class="nav nav-tabs vertical-spacer-40" role="tablist">
                    <li class="active">
                        <a href="#content" data-toggle="tab" aria-controls="content" aria-expanded="true">My Published Content @if($pCount)({{ $pCount }})@endif</a>
                    </li>
                    <li>
                        <a href="#progress" data-toggle="tab" aria-controls="progress" aria-expanded="true">Work in Progress @if($wipCount)({{ $wipCount }})@endif</a>
                    </li>
                    <li>
                        <a href="#feedback" data-toggle="tab" aria-controls="feedback" aria-expanded="true">Feedback Needed</a>
                    </li>           
                </ul> 
                <div id="tabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="content" aria-labelledby="content"> 
                        @if (! empty($published))
                            @foreach($published as $item)
                                <a href="/artifact-builder/{{$item->template_id}}">{{ $item->title }}</a></p>
                            @endforeach
                        @else
                            <p>You have not published any content yet.</p>
                        @endif 
                    </div>
                <div role="tabpanel" class="tab-pane" id="progress" aria-labelledby="progress"> 
                        @if (! empty($workInProgress))
                            @foreach($workInProgress as $item)
                                <a href="/artifact-builder/{{$item->template_id}}">{{ $item->title }}</a></p>
                            @endforeach
                        @else
                            <h4>You do not have any work in progress.</h4>
                        @endif 
                </div>
                <div role="tabpanel" class="tab-pane" id="feedback" aria-labelledby="feedback"> 
                        <p>List of feedback needed</p> 
                </div>
            </div>
        </div>
    </div>     
</div>
@endsection