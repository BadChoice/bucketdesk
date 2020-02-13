<?php

namespace App\ThrustHelpers\Filters;

use BadChoice\Thrust\Filters\SelectFilter;
use Illuminate\Http\Request;

class ReadyFilter extends SelectFilter
{
    public function apply(Request $request, $query, $value)
    {
        if ($value == -1) return $query;
        return $query->whereNotNull('pull_request');
    }

    public function options()
    {
        return [
            'Ready' => 0,
        ];
    }
}
