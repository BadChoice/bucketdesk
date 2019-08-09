
@if ($priority == App\Issue::PRIORITY_BLOCKER)
    @icon(warning)
@else
    <div class="priority-icon-container">
      <ol class="priority-column ">
        <div class="priority-colour-bar priority-column-1 @if($priority > 1) active @endif"></div>
      </ol>
      <ol class="priority-column ">
        <div class="priority-colour-bar priority-column-2 @if($priority > 2) active @endif"></div>
      </ol>
      <ol class="priority-column ">
        <div class="priority-colour-bar priority-column-3 @if($priority > 3) active @endif"></div>
      </ol>
    </div>
@endif
