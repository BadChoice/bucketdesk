<?php

namespace App\ThrustHelpers\Fields;

use App\Issue;
use BadChoice\Thrust\Fields\Select;

class StatusField extends Select
{
    public function displayInIndex($object)
    {
        return $object->presenter()->status;
    }

}