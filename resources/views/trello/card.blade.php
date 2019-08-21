<li id='issue_{{$issue->id}}' class="ui-state-default sort">
    <div class="float-right o60">
        <a href="{{route('thrust.edit', ['resourceName' => 'issues', 'id' => $issue->id])}}" class="showPopup">@icon(ellipsis-h)</a>
    </div>
    <div>
        <strong class="gray">
            <a class="gray" href="{{ $issue->remoteLink() }}" target="__blank">#{{$issue->issue_id}}</a>
            {{ $issue->repository->name }}
        </strong>
        <div>
        <span class="tag">{!! $issue->presenter()->priority !!}</span>
        <span class="tag">{!! $issue->presenter()->type !!}</span>
        @if($issue->cycle)
            <a href="{{route('thrust.hasMany', ['cycles', $issue->cycle_id, 'issues'])}}" style="margin-left:-2px">
                <span class="tag">{!! $issue->presenter()->cycle !!}</span>
            </a>
        @endif
        {!! $issue->presenter()->tags !!}
        </div>
    </div>
    <a href="{{ route('issues.show', $issue)}}" class="showPopup">
        <p class="mt1"> {{ $issue->title }}  </p>
    </a>

</li>
