@extends('layout')
@section('content')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    <div class="float-left mt4 ml4" style="width:70%">
        {!! $calendar->calendar() !!}
    </div>
    <div class="float-left mt2 ml2">
        <h2 class="ml4">@icon(warning) Due Issues! </h2>
        <table>
        @foreach($pending as $issue)
            <tr>
                <td> <a href="{{route('issues.show', $issue)}}" class="showPopup">{{ str_limit($issue->title, 40) }}</a></td>
                <td>
                    @if($issue->user)
                        {!! (new BadChoice\Thrust\Fields\Gravatar)->getImageTag($issue->user->email, 20) !!}
                    @endif
                </td>
                <td> <a href="{{route('thrust.edit', ['issues', $issue->id])}}" class="showPopup">{{ $issue->date->format('d M y') }}</a></td>
            </tr>
        @endforeach
        </table>
    </div>
@stop

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    {!! $calendar->script() !!}
    @csrf
    <script>

        function showIssue(info){
            showPopup("{{route('issues.show', 1111)}}".replace("1111", info.id))
        }
        function updateDate(info) {
            $.post("{{route('thrust.update', ['issues', 1111])}}".replace("1111", info.id), {
                "_token" : "{{csrf_token()}}",
                "_method" : "put",
                "date" : info.start.toISOString()
            }, function(){})
        }
    </script>
@stop
