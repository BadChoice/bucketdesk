<?php

namespace App\Thrust;

use App\ThrustHelpers\Actions\CloseIssues;
use App\ThrustHelpers\Actions\QuickCreateIssue;
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
use BadChoice\Thrust\Fields\BelongsTo;
use BadChoice\Thrust\Fields\Date;
use BadChoice\Thrust\Fields\Gravatar;
use BadChoice\Thrust\Fields\Link;
use BadChoice\Thrust\Fields\Select;
use BadChoice\Thrust\Fields\Text;
use BadChoice\Thrust\Filters\Filter;
use BadChoice\Thrust\Resource;

class Issue extends Resource
{
    public static $model = \App\Issue::class;
    public static $search = ['title', 'repository.name', 'tags.name', 'username'];
    public static $defaultOrder = 'desc';
    public static $defaultSort = 'updated_at';

    protected $noEmphasisClass = 'o70';

    public function fields()
    {
        return [
            IssueLink::make('issue_id')->sortable()->rowClass($this->noEmphasisClass),
            TitleField::make('title')->sortable(),
            Tags::make('tags'),
            BelongsTo::make('repository')->onlyInIndex()->rowClass($this->noEmphasisClass),
            BelongsTo::make('user')->allowNull()->rowClass('date')->onlyInEdit(),
            PriorityField::make('priority')->sortable()->options(array_flip(\App\Issue::priorities()))->rowClass($this->noEmphasisClass),
            TypeField::make('type')->sortable()->options(array_flip(\App\Issue::types()))->rowClass($this->noEmphasisClass),
            StatusField::make('status')->sortable()->options(array_flip(\App\Issue::statuses())),
            Date::make('date')->sortable()->rowClass($this->noEmphasisClass),
            Date::make('created_at')->sortable()->onlyInIndex()->format('M d')->rowClass($this->noEmphasisClass),
            Gravatar::make('user.email','')->onlyInIndex()->hideWhen('user', null),

            ResolveField::make('id',''),
        ];
    }

    protected function getBaseQuery()
    {
        if ($this->filtersApplied()->keys()->contains('App\ThrustHelpers\Filters\StatusFilter') && $this->filtersApplied()['App\ThrustHelpers\Filters\StatusFilter'] != '--'){
            return parent::getBaseQuery();
        }
        return parent::getBaseQuery()->where('status', '<', \App\Issue::STATUS_RESOLVED);
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
            new CloseIssues()
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