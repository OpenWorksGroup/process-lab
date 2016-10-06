@foreach($contents as $content)
        <div class="row">
            <div class="col-md-10">
                <div>
                    <h3>{{ $content['section_title'] }}</h3>
                </div>
            </div>
        </div>

        @foreach($content['fields'] as $field)
            <div class="row">
                <div class="col-md-10">
                        <div class="vertical-tb-spacer-40"><h4>{{ $field['field_title'] }}</h4></div>
                    </div>
                </div>
            @if(!empty($field['text']))
                @foreach($field['text'] as $text)
                    <div class="row">
                        <div class="col-md-10">
                            <div>{!! $text->content !!}</div>
                        </div>
                    </div>
                @endforeach
            @endif

            @if(!empty($field['links']))
                @foreach($field['links'] as $link)
                    <div class="row">
                        <div class="col-md-10">
                            <div><a href="{{ $link->uri}}" target="_blank">{{ $link->uri}}</a></div>
                        </div>
                    </div>
                @endforeach
            @endif
            {{ count($field['files']) }}
            @if(count($field['files']) >0)
                <div class="content-files" data-files="{{$field['files']}}"></div>
            @endif
        @endforeach
    @endforeach