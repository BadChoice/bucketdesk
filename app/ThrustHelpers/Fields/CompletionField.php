<?php

namespace App\ThrustHelpers\Fields;

use BadChoice\Thrust\Fields\Text;

class CompletionField extends Text
{
    public function __construct()
    {
        $this->onlyInIndex()->displayWith(function($cycle){
            return number_format($cycle->completionPercentage() * 100, 0) . ' %';
        });
    }

}