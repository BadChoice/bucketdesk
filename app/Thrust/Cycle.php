<?php

namespace App\Thrust;

use App\ThrustHelpers\Fields\CompleteCycleField;
use App\ThrustHelpers\Fields\CompletionField;
use App\ThrustHelpers\Fields\CompletionProgressField;
use App\ThrustHelpers\Filters\CompletedFilter;
use BadChoice\Thrust\Fields\Date;
use BadChoice\Thrust\Fields\HasMany;
use BadChoice\Thrust\Fields\Text;
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
            Text::make('title')->displayWith(function($cycle){
                return "<a href=" . route('thrust.hasMany', ['cycles', $cycle->id, 'issues']) . ">" . $cycle->title . "</a>";
            })->rules('required'),
            HasMany::make('issues')->onlyCount()->withLink(),
            CompletionField::make('id', 'completion'),
            CompletionProgressField::make('id', 'progress'),
            Date::make('date')->showInTimeAgo()->onlyInIndex(),
            Date::make('date')->format('M d')->rules('required'),

            CompleteCycleField::make('id')->withoutIndexHeader()
        ];
    }

    protected function getBaseQuery()
    {
        $query = parent::getBaseQuery();
        if (! request()->has('filters')) {
            return $query->where('completed', 0);
        }
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
            new CompletedFilter,
        ];
    }

    public function canDelete($object)
    {
        return false;
    }
}
