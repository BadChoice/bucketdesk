<?php

namespace App\ThrustHelpers\Fields;

use BadChoice\Thrust\Fields\Text;

class CompletionField extends Text
{
    public function __construct()
    {
        $this->onlyInIndex()->displayWith(function($cycle){
            $percentage = $cycle->completionPercentage() * 100;
            return view('components.icons.circle-progress', ['percentage' => $percentage, 'size' => 16, 'withValue' => true]);
        });
    }

}
