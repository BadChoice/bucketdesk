<?php

namespace App;


class IssuePresenter
{
    private $issue;

    public function __construct($issue)
    {
        $this->issue = $issue;
    }

    public function status()
    {
        $statusFontAwesome = [
            Issue::STATUS_NEW => 'fa-circle-o lighter-gray',
            Issue::STATUS_OPEN => 'fa-adjust green',
            Issue::STATUS_HOLD => 'fa-pause-circle-o lighter-gray',
            Issue::STATUS_RESOLVED => 'fa-circle green',
            Issue::STATUS_CLOSED => 'fa-check-circle green',
            Issue::STATUS_INVALID => 'fa-times-circle red',
            Issue::STATUS_DUPLICATED => 'fa-clone lighter-gray',
            Issue::STATUS_WONTFIX => 'fa-minus-circle lighter-gray',
        ][$this->issue->status] ?? 'fa-circle green';
        return "<i class=\"fa {$statusFontAwesome}\" aria-hidden=\"true\"></i>";
    }

    public function priority()
    {
        return view('components.icons.priority', ['priority' => $this->issue->priority])->render();
        return [
            Issue::PRIORITY_TRIVIAL  => '🌈',
            Issue::PRIORITY_MINOR    => '🥊️',
            Issue::PRIORITY_MAJOR    => '😶',
            Issue::PRIORITY_CRITICAL => '🔥',
            Issue::PRIORITY_BLOCKER  => '☠️',
        ][$this->issue->priority];
    }

    public function type()
    {
        $fa = [
            Issue::TYPE_TASK         => 'fa-code', //'👷',
            Issue::TYPE_BUG          => 'fa-bug', //'👾',
            Issue::TYPE_ENHANCEMENT  => 'fa-diamond', '💅',
            Issue::TYPE_PROPOSAL     => 'fa-lightbulb-o', //💡',
        ][$this->issue->type];
        return "<i class=\"fa {$fa} fa-fw\" aria-hidden=\"true\"></i>";
    }

    public function tags()
    {
        return $this->issue->tags->reduce(function ($carry, $tag) {
            return $carry . "<span class='tag'>{$tag->name}</span>";
        });
    }

    public function cycle(){
        if (! $this->issue->cycle) return "";
        $percentage = $this->issue->cycle->completionPercentage() * 100;
        return view('components.icons.circle-progress', ['percentage' => $percentage, 'size' => 16])->render();
    }

    public function __get($name)
    {
        return $this->$name();
    }
}
