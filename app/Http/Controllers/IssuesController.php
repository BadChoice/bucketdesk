<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Repository;
use BadChoice\Thrust\Controllers\ThrustController;

class IssuesController extends Controller
{
    public function store()
    {
        $this->validate(request(), [
            'title' => 'required|min:3',
            'tags' => 'nullable|min:2'
        ]);

        $issue = Repository::find(request('repository_id'))->createIssue(request('title'), '', [
            'kind'     => array_flip(Issue::types())[request('type')],
            'priority' => array_flip(Issue::priorities())[request('priority')],
            //'username' => request('username'), the create issues doesn't have it
        ]);
        $issue->attachTags(request('tags'));
        return back();
    }

    public function show(Issue $issue)
    {
        return view('issues.show', [
            'issue'    => $issue,
            'remote'   => $issue->getRemote(),
            'comments' => $issue->getComments()->values,
        ]);
    }

    public function resolve(Issue $issue)
    {
        $issue->resolve();
        return back();
    }

    public function backlog()
    {
        request()->merge(['backlog' => true]);
        return (new ThrustController)->index('issues');
    }

    public function toggleBacklog(Issue $issue)
    {
        $issue->moveToBacklog(! $issue->backlog);
        return back();
    }
}
