<?php

namespace App\ThrustHelpers\Actions;

use App\Cycle;
use App\Issue;
use BadChoice\Thrust\Actions\Action;
use BadChoice\Thrust\Fields\Select;
use Illuminate\Support\Collection;

class AssignToCycle extends Action
{
    public function fields()
    {
        return [
            Select::make('cycle_id')->options(Cycle::all()->pluck('title', 'id')->toArray())->allowNull()
        ];
    }

    public function handle(Collection $objects)
    {
        $this->getAllObjectsQuery($objects)->update(['cycle_id' => request()->cycle_id]);
    }

}