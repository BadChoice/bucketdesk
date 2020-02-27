<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Issue;
use App\IssueTrackers\Bitbucket\Bitbucket;
use App\Repository;
use Carbon\Carbon;

class IssuesController extends Controller
{
    public function index()
    {
        $query = Issue::query();
        if (request()->has('user')){
           $query = $query->where('username', 'like', request()->user);
        }
        $issues = $query->workingOn()->with('repository')->orderBy('order', 'asc')->orderBy('repository_id', 'asc')->get();
        return response($issues);
    }

    public function show($repo, $issue)
    {
        return response(Issue::findWith($repo, $issue)->load('repository'));
    }

    public function update($repo, $issue){
        Issue::findWith($repo, $issue)->update(["status" => request()->status]);
    }

    public function createPullRequest($repo, $issue){
        $issue = Issue::findWith($repo, $issue);
        if ($issue->pull_request) {
            return response(["link" => $issue->pull_request]);
        }
        $pr = app(Bitbucket::class)->createPullRequest($issue->repository->account, $issue->repository->repo, $issue->title, "feature/issue-{$issue->issue_id}", "dev");
        $issue->ignoreBitbucketUpdate()->update(["pull_request" => $pr->links->html->href]);
        return response(["link" => $issue->pull_request]);
    }

}
