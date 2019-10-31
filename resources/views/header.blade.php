<div id="sidebar-toggle" class="fs4 mt2">
    <div id="sidebar-decrease" class="absolute hidden" style="margin-left:168px; z-index: 110; margin-top: -4px;">
        @icon(bars)
    </div>
    <div id="sidebar-increase" class="absolute ml4">
        @icon(bars)
    </div>
</div>
<div class="sidebar" id="sidebar">
    <img src="/images/logo.png" class="" height="30" style="margin-left:25px">

    <div class="">
        <ul>
            <li>
                <div>
                    {!! (new BadChoice\Thrust\Fields\Gravatar)->getImageTag(auth()->user()->email, 40) !!}
                    {{ auth()->user()->name }}
{{--                    <div style="float:right; width:95px; margin-top:6px">{!! str_replace(" ", "<br>", auth()->user()->name) !!}</div>--}}
                </div>
            </li>
            <li class="@if (Route::current()->getName() == 'thrust.index' && collect(Route::current()->parameters)->contains('issues')) active @endif "><a href="{{route('thrust.index', 'issues')}}"> @icon(check-square-o) Issues</a></li>
            <li class="@if (Route::current()->getName() == 'thrust.index' && collect(Route::current()->parameters)->contains('cycles')) active @endif "><a href="{{route('thrust.index', 'cycles')}}"> @icon(folder-open-o) Cycles</a></li>
            <li class="@if (Route::current()->getName() == 'my.issues.current') active @endif "><a href="{{route('my.issues.current')}}"> @icon(fire) My Current Work</a></li>
            <li class="@if (Route::current()->getName() == 'my.issues.all') active @endif "><a href="{{route('my.issues.all')}}">@icon(list) All My Work</a></li>
            <li class="@if (Route::current()->getName() == 'trello') active @endif "><a href="{{route('trello')}}"> @icon(road) Trello</a></li>
            <li class="@if (Route::current()->getName() == 'calendar') active @endif "><a href="{{route('issues.calendar')}}"> @icon(calendar) Calendar</a></li>
            <li class="@if (Route::current()->getName() == 'issues.backlog') active @endif "><a href="{{route('issues.backlog')}}">@icon(bed) Backlog</a></li>
            <li class="@if (Route::current()->getName() == 'reports') active @endif "><a href="{{route('reports')}}">@icon(bar-chart) Reports </a></li>
        </ul>
    </div>
</div>
