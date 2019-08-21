{{--https://css-tricks.com/building-progress-ring-quickly/--}}
<?php $randomId = str_random(6); ?>
<svg class="progress-ring" width="{{$size}}" height="{{$size}}">
    <circle class="progress-ring__circle" stroke-width="2" fill="transparent"
            stroke="#aaa"
            r="6" cx="{{$size/2}}" cy="{{$size/2}}"/>

    <circle id="{{$randomId}}" class="progress-ring__circle" stroke-width="2" fill="transparent"
            stroke="#DB4D52"
        r="6" cx="{{$size/2}}" cy="{{$size/2}}"/>

    @if (isset($withTriangle))
        <polygon points="6,5 6,10 11,7.5" style="fill:#aaa; stroke:#aaa ;stroke-width:1" />
    @endif
</svg>

@if(isset($withValue))
<div style="display: inline-block;">
    {{ number_format($percentage, 0) }} %
</div>
@endif

<script>
    var circle = document.getElementById('{{$randomId}}');
    var radius = circle.r.baseVal.value;
    var circumference = radius * 2 * Math.PI;

    circle.style.strokeDasharray = `${circumference} ${circumference}`;
    circle.style.strokeDashoffset = `${circumference}`;
    var offset = circumference - {{ $percentage }} / 100 * circumference;
    circle.style.strokeDashoffset = offset;
</script>
