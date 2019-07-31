<?php

namespace App\Thrust;

use App\ThrustHelpers\Actions\CloseIssues;
use App\ThrustHelpers\Actions\MoveToActive;
use App\ThrustHelpers\Actions\MoveToBacklog;
use App\ThrustHelpers\Actions\QuickCreateIssue;
use App\ThrustHelpers\Fields\CompletionField;
use App\ThrustHelpers\Fields\CompletionProgressField;
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
use BadChoice\Thrust\Fields\HasMany;
use BadChoice\Thrust\Fields\Link;
use BadChoice\Thrust\Fields\Select;
use BadChoice\Thrust\Fields\Text;
use BadChoice\Thrust\Filters\Filter;
use BadChoice\Thrust\Resource;

class Cycle extends Resource
{
    public static $model = \App\Cycle::class;
    public static $search = ['title'];
    public static $defaultOrder = 'desc';
    public static $defaultSort = 'date';

    // https://twitter.com/karrisaarinen/status/1148287007329701888/photo/1
    // https://twitter.com/linear_app/status/1153344163410141184/photo/1

    public function fields()
    {
        return [
            //IssueLink::make('issue_id')->sortable()->rowClass($this->noEmphasisClass),
            //StatusField::make('status','')->sortable()->options(array_flip(\App\Issue::statuses()))->rowClass('pr2'),
            //TitleField::make('title')->sortable(),
            Text::make('title'),
            HasMany::make('issues')->onlyCount()->withLink(),
            CompletionField::make('id', 'completion'),
            CompletionProgressField::make('id', 'progress'),
            Date::make('date')->showInTimeAgo()->onlyInIndex(),
            Date::make('date')->format('M d'),
        ];
    }

    protected function getBaseQuery()
    {
        $query = parent::getBaseQuery();
        return $query;
    }


    /*public function mainActions()
    {
        return [

        ];
    }*/

    public function actions()
    {
        return [
       //     new CloseIssues,
       //     new MoveToBacklog,
        //    new MoveToActive,
        ];
    }

    public function filters()
    {
        return [
          //  new PriorityFilter,
           // new TypeFilter,
           // new StatusFilter,
           // new RepositoryFilter,
           // new UserFilter,
        ];
    }

    public function canDelete($object)
    {
        return false;
    }
}