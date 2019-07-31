<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    protected $guarded = [];
    protected $dates = ['date'];

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    public function completedIssues()
    {
        return $this->issues->filter(function($issue){
            return $issue->isCompleted();
        });
    }

    public function pendingIssues()
    {
        return $this->issues->filter(function($issue){
            return ! $issue->isCompleted();
        });
    }

    public function completionPercentage()
    {
        if ($this->issues->count() == 0) return 100;
        return $this->completedIssues()->count() / $this->issues->count();
    }
}
