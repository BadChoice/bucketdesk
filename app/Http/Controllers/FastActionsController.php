<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class FastActionsController extends Controller
{
    public function index()
    {
        return view('components.actions.fastActions');
    }
}
