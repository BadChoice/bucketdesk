<?php

namespace App\Thrust;

use App\ThrustHelpers\Actions\AssignToCycle;
use App\ThrustHelpers\Actions\CloseIssues;
use App\ThrustHelpers\Actions\MoveToActive;
use App\ThrustHelpers\Actions\MoveToBacklog;
use App\ThrustHelpers\Actions\QuickCreateIssue;
use App\ThrustHelpers\Fields\CycleField;
use App\ThrustHelpers\Fields\IssueLink;
use App\ThrustHelpers\Fields\PriorityField;
use App\ThrustHelpers\Fields\ResolveField;
use App\ThrustHelpers\Fields\StatusField;
use App\ThrustHelpers\Fields\Tags;
use App\ThrustHelpers\Fields\TitleField;
use App\ThrustHelpers\Fields\TypeField;
use App\ThrustHelpers\Filters\PriorityFilter;
use App\ThrustHelpers\Filters\RepositoryFilter;
use App\ThrustHelpers\Filters\StatusFilter;
use App\ThrustHelpers\Filters\TypeFilter;
use App\ThrustHelpers\Filters\UserFilter;
use BadChoice\Thrust\ChildResource;
use BadChoice\Thrust\Fields\BelongsTo;
use BadChoice\Thrust\Fields\Date;
use BadChoice\Thrust\Fields\Gravatar;

class Issue extends ChildResource
{
    public static $model = \App\Issue::class;
    public static $search = ['title', 'repository.name', 'tags.name', 'username'];
    public static $defaultOrder = 'desc';
    public static $defaultSort = 'updated_at';

    public static $parentRelation = 'cycle';

    protected $noEmphasisClass = 'o70';

    public function fields()
    {
        return [
            PriorityField::make('priority')->sortable()->withoutIndexHeader()->options(array_flip(\App\Issue::priorities()))->rowClass($this->noEmphasisClass),
            IssueLink::make('issue_id')->sortable()->rowClass($this->noEmphasisClass),
            StatusField::make('status')->sortable()->withoutIndexHeader()->options(array_flip(\App\Issue::statuses()))->rowClass('pr2'),
            TitleField::make('title')->sortable()->rowClass('text-row')->attributes('autofocus'),
            CycleField::make('cycle')->withoutIndexHeader()->onlyInIndex()->withLink(),
            TypeField::make('type')->withoutIndexHeader()->sortable()->options(array_flip(\App\Issue::types()))->rowClass($this->noEmphasisClass),
            Tags::make('tags'),
            BelongsTo::make('repository')->onlyInIndex()->rowClass($this->noEmphasisClass),
            BelongsTo::make('user')->allowNull()->rowClass('date')->onlyInEdit(),
            Date::make('date')->sortable()->rowClass($this->noEmphasisClass),
            Date::make('created_at')->sortable()->onlyInIndex()->format('M d')->rowClass($this->noEmphasisClass),
            Gravatar::make('user.email','')->onlyInIndex()->hideWhen('user', null),

            ResolveField::make('id',''),
        ];
    }

    protected function getBaseQuery()
    {
        $query = parent::getBaseQuery();
        if ($this->parentId) {
            return $query;  //It means we are in cycle
        }
        if (!request()->has('search')) {
            $query->where('backlog', intval(request()->has('backlog')));
        }
        if ($this->filtersApplied()->keys()->contains('App\ThrustHelpers\Filters\StatusFilter') && $this->filtersApplied()['App\ThrustHelpers\Filters\StatusFilter'] != '--'){
            return $query;
        }
        return $query->where('status', '<', \App\Issue::STATUS_RESOLVED);
    }


    public function mainActions()
    {
        return [
            QuickCreateIssue::make('createIssue'),
        ];
    }

    public function actions()
    {
        return [
            new CloseIssues,
            new MoveToBacklog,
            new MoveToActive,
            new AssignToCycle,
        ];
    }

    public function filters()
    {
        return [
            new PriorityFilter,
            new TypeFilter,
            new StatusFilter,
            new RepositoryFilter,
            new UserFilter,
        ];
    }

    public function canDelete($object)
    {
        return false;
    }
}
