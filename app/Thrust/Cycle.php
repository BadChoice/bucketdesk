<?php

namespace App\Thrust;

use App\ThrustHelpers\Actions\CloseIssues;
use App\ThrustHelpers\Actions\MoveToActive;
use App\ThrustHelpers\Actions\MoveToBacklog;
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


    public function fields()
    {
        return [
            //IssueLink::make('issue_id')->sortable()->rowClass($this->noEmphasisClass),
            //StatusField::make('status','')->sortable()->options(array_flip(\App\Issue::statuses()))->rowClass('pr2'),
            //TitleField::make('title')->sortable(),
            Text::make('title'),
            HasMany::make('issues')->onlyCount()->withLink(),
            Text::make('id', 'completion')->displayWith(function($cycle){
                return $cycle->completionPercentage() . ' %';
            })->onlyInIndex(),
            Text::make('id', 'completed')->displayWith(function($cycle){
                return $cycle->completedIssues()->count() . ' Done';
            })->onlyInIndex(),
            Text::make('id', 'Pending')->displayWith(function($cycle){
                return $cycle->pendingIssues()->count() . ' Pending';
            })->onlyInIndex(),
            Date::make('date')->showInTimeAgo()->onlyInIndex(),
            //Tags::make('tags'),
            //BelongsTo::make('repository')->onlyInIndex()->rowClass($this->noEmphasisClass),
            //BelongsTo::make('user')->allowNull()->rowClass('date')->onlyInEdit(),
            //PriorityField::make('priority')->sortable()->options(array_flip(\App\Issue::priorities()))->rowClass($this->noEmphasisClass),
            //TypeField::make('type')->sortable()->options(array_flip(\App\Issue::types()))->rowClass($this->noEmphasisClass),
            Date::make('date')->format('M d'),
            //Date::make('created_at')->sortable()->onlyInIndex()->format('M d')->rowClass($this->noEmphasisClass),
            //Gravatar::make('user.email','')->onlyInIndex()->hideWhen('user', null),

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