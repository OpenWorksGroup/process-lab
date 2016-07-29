@if($status == "edit") 
	<div class="vertical-tb-spacer-20"><a class="btn btn-default" data-toggle="modal" data-target="#publishModal">Publish</a></div>
@endif
@if(count($rubric) > 0)
<div class="vertical-tb-spacer-20">
	<a class="btn btn-default" href="/review/{{ $contentId }}">Submit for Review</a>
	</div>
@endif