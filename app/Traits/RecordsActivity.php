<?php

namespace App\Traits;

use App\Activity;

trait RecordsActivity
{
    /**
     * Similar to boot method in the model rhat uses this trait
     *
     * @return void
     */
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }
    /**
     * Add a record to the activities table when a thread is created to record the activity
     *
     * @param string $event
     * @return void
     */
    protected function recordActivity($event)
    {
        $this->activity()->create([
            'type' => $this->getActivityType($event),
            'user_id' => auth()->id(),
        ]);
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    /**
     * Get the activity typw
     *
     * @param string $event
     * @return string
     */
    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$event}_{$type}";
    }
}
