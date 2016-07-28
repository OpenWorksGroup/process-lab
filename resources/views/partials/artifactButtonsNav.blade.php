<div class="vertical-tb-spacer-20"><a class="btn btn-default" href="/publish-content/{{ $contentId }}">Publish</a></div>
@if(count($rubric) > 0)
<div class="vertical-tb-spacer-20">
	<a class="btn btn-default" href="/review/{{ $contentId }}">Submit for Review</a>
	</div>
@endif