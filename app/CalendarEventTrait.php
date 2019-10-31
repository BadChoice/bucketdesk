<?php

namespace App;

trait CalendarEventTrait
{
    public function getId() {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title . ": " . optional($this->user)->username ?? "";
    }

    public function isAllDay()
    {
        return true;
    }

    public function getStart()
    {
        return $this->date;
    }


    public function getEnd()
    {
        return $this->date;
    }
}
