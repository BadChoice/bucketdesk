<?php

namespace App\Http\Controllers;

use App\Issue;
use App\User;
use Illuminate\Support\Facades\DB;

class TrelloController extends Controller
{
    public function index()
    {
        $username = request('username') ?? auth()->user()->username;
        $issues = $this->fetchTrelloIssues($username);
        return view('trello.index', [
            'username'  => $username,
            'users'     => User::all(),
            'new'       => $issues->where('status', Issue::STATUS_NEW),
            'open'      => $issues->where('status', Issue::STATUS_OPEN),
            'hold'      => $issues->where('status', Issue::STATUS_HOLD),
            'resolved'  => $issues->where('status', Issue::STATUS_RESOLVED),
        ]);
    }

    public function update()
    {
        $newStatus = Issue::statuses()[request('status')];
        $issue     = Issue::findOrFail(request('id'));
        $issue->ignoreBitbucketUpdate($issue->status == $newStatus)->update([
            'status' => $newStatus,
        ]);
        $this->sortIssues();
        return response()->json('ok');
    }

    public function sortIssues()
    {
        if (! request()->has('sort')) return;
        $sortedIds = collect(explode('&', request('sort')))->map(function ($sort) {
            return explode('=', $sort)[1];
        });
        $issues = Issue::find($sortedIds);
        $sorted = array_flip($sortedIds->toArray());
        $issues->each(function ($issue) use ($sorted) {
            $issue->ignoreBitbucketUpdate()->update(['order' => $sorted[$issue->id]]);
        });
    }

    /**
     * @param $username
     * @return mixed
     */
    protected function fetchTrelloIssues($username)
    {
        $query = Issue::where('username', $username)
            ->whereIn('status', [Issue::STATUS_NEW, Issue::STATUS_OPEN, Issue::STATUS_RESOLVED, Issue::STATUS_HOLD])
            ->orderBy(DB::raw('`order` IS NULL, `order`'), 'asc');
        if (request('tag')){
            $query->whereHas('tags', function($query){
                return $query->where('name', request('tag'));
            });
        }
        if (request('cycle')) {
            $query->where('cycle_id', request('cycle'));
        }
        return $query->get();
    }
}
