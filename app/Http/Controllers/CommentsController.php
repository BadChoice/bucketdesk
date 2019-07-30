<?php

namespace App\Http\Controllers;

use App\Issue;

class CommentsController extends Controller
{
    public function store(Issue $issue)
    {
        $issue->comment(request('comment'));
        return back();
    }

    public function update(Issue $issue)
    {
        $issue->updateDescription(request('content'));
        return back();
    }
}
