<h2>#{{ $issue->issue_id }} {{ $issue->title }}</h2>
<div class="mb2">
    {!! $issue->presenter()->status !!}
    {{ $issue->presenter()->priority }}
    {{ $issue->presenter()->type }}
    {{ $issue->repository->name }}
    {!! $issue->presenter()->tags !!}

    @if ($issue->cycle)
        <div class="float-right inline">
            <a href="{{route('thrust.hasMany', ['cycle', $issue->cycle_id, 'issues'] )}}"> @icon(play-circle) {{$issue->cycle->title}}</a>
        </div>
    @endif

</div>
@include('components.comment', [
    'avatar' => $remote->reporter->links->avatar->href,
    'name' => $remote->reporter->display_name,
    'date' => Carbon\Carbon::parse($remote->created_on),
    'content' => $remote->content,
    'editable' => true,
])

@foreach(collect($comments)->sortBy('created_on') as $comment)
    @if (! empty($comment->content))
        @include('components.comment', [
            'avatar' => $comment->user->links->avatar->href,
            'name' => $comment->user->display_name,
            'date' => Carbon\Carbon::parse($comment->created_on),
            'content' => $comment->content,
            'editable' => false,
        ])
    @endif
@endforeach

<div class="mb3 pt3 pb3 bb mt2">
    <form action="{{route('comments.store', $issue)}}" method="POST">
        {{ csrf_field() }}
        <textarea name="comment" class="w100" rows="8"></textarea>
        <br>
        <button class="secondary">Comment</button>
    </form>
</div>
<div>
@if ($issue->status < \App\Issue::STATUS_RESOLVED)
    <a href="{{route('issues.resolve', $issue)}}" class="button">RESOLVE</a>
@endif
<a href="{{$issue->remoteLink()}}" target="__blank">See on Bitbucket</a>
</div>
