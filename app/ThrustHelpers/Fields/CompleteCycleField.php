<?php

namespace App\ThrustHelpers\Fields;

use BadChoice\Thrust\Fields\Link;

class CompleteCycleField extends Link
{
    public function __construct()
    {
        $this->classes = 'button secondary shadow-outer-3';
        $this->route = 'cycles.complete';
        $this->displayCallback = function($object){
            if (!$object->completed && $object->pendingIssues()->count() == 0) {
//                return "<button><i class='fa fa-wrench'></i> RESOLVE</button>";
                return "COMPLETE";
            }
            return "";
        };
    }
}
