<?php

namespace App\ThrustHelpers\Actions;

use App\Issue;
use BadChoice\Thrust\Actions\Action;
use Illuminate\Support\Collection;

class MoveToActive extends Action
{
    public function handle(Collection $objects)
    {
        $objects->filter(function($issue){
            return !$issue->backlog;
        })->each->moveToBacklog(false);
    }

}