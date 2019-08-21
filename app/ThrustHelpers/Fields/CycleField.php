<?php

namespace App\ThrustHelpers\Fields;

use App\Issue;
use BadChoice\Thrust\Fields\BelongsTo;
use BadChoice\Thrust\Fields\Link;
use BadChoice\Thrust\Fields\Select;
use BadChoice\Thrust\Fields\Text;

class CycleField extends BelongsTo
{
    public function displayInIndex($object)
    {
        return "<a href='". route('thrust.hasMany', ['cycles', $object->cycle_id, 'issues']) ."'>" . $object->presenter()->cycle . "</a>";
    }

}
