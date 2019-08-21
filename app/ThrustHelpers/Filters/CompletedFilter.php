<?php

namespace App\ThrustHelpers\Filters;

use BadChoice\Thrust\Filters\SelectFilter;
use Illuminate\Http\Request;

class CompletedFilter extends SelectFilter
{
    public function apply(Request $request, $query, $value)
    {
        if ($value == -1) return $query;
        return $query->where('completed', $value);
    }

    public function options()
    {
        return [
            'incomplete' => 0,
            'completed'  => 1,
            'all'       => -1
        ];
    }
}
