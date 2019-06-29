<?php

namespace App\ThrustHelpers\Actions;

use App\Issue;
use BadChoice\Thrust\Actions\Action;
use Illuminate\Support\Collection;

class CloseIssues extends Action
{
    public function handle(Collection $objects)
    {
        $objects->filter(function($issue){
            return $issue->status = Issue::STATUS_RESOLVED;
        })->each->close();
    }

}