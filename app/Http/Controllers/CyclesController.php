<?php

namespace App\Http\Controllers;

use App\Cycle;
use App\Issue;
use App\Repository;
use BadChoice\Thrust\Controllers\ThrustController;

class CyclesController extends Controller
{
    public function complete(Cycle $cycle){
        $cycle->complete();
        return back();
    }
}
