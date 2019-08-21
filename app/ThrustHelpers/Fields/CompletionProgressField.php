<?php

namespace App\ThrustHelpers\Fields;

use BadChoice\Thrust\Fields\Text;

class CompletionProgressField extends Text
{
    public function __construct()
    {
        //TODO: Check this for more accurate circle => https://codepen.io/felipefialho/pen/vGMJBN
        $this->onlyInIndex()->displayWith(function($cycle){
            return $cycle->completedIssues()->count() . ' Done - ' .
                   $cycle->pendingIssues()->count() .' Pending';
        });
    }

}
