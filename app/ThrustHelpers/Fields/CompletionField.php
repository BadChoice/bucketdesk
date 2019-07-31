<?php

namespace App\ThrustHelpers\Fields;

use BadChoice\Thrust\Fields\Text;

class CompletionField extends Text
{
    public function __construct()
    {
        $this->onlyInIndex()->displayWith(function($cycle){
            $percentage = $cycle->completionPercentage() * 100;
            return "<pie class='".$this->getPercentageClass($percentage)."'></pie> " . number_format($percentage, 0) . ' %';
        });
    }

    public function getPercentageClass($value){
        if ($value > 85) return "onehundred";
        if ($value > 60) return "seventyfive";
        if ($value > 40) return "fifty";
        if ($value > 20) return "twentyfive";
        if ($value > 5) return "ten";
        return "";
    }

}