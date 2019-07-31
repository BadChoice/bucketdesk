<?php

namespace App\ThrustHelpers\Fields;

use BadChoice\Thrust\Fields\Text;

class CompletionProgressField extends Text
{
    public function __construct()
    {
        $this->onlyInIndex()->displayWith(function($cycle){
            return $cycle->completedIssues()->count() . ' Done - ' .
                   $cycle->pendingIssues()->count() .' Pending';
        });
    }

}