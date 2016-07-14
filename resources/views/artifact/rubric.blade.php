
@extends('layouts.adminApp')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="text-center">
                <h2>{{ $pageTitle }}</h2>
            </div>
        </div>
    </div>

    <div class="row">
		<div class="col-md-10">
            <table class="table table-bordered">
                <caption>{{ $framework }}</caption>
                <thead>
                    <tr>
                        <th>Competency</th>
                        @foreach($competencyHeaders as $header)
                            <th>{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($rubrics as $rubric)
                        <tr>
                            <td><strong>{{ $rubric['category'] }}</strong></td>
                            <td>{{ $rubric['rubric']['description_1'] }}</td>
                            <td>{{ $rubric['rubric']['description_2'] }}</td>
                            <td>{{ $rubric['rubric']['description_3'] }}</td>
                            <td>{{ $rubric['rubric']['description_4'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                
        </div>
    </div>
</div>
@endsection