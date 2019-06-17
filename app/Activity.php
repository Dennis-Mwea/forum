<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'subject_id', 'subject_type', 'type'
    ];

    public function subject()
    {
        return $this->morphTo();
    }

    public static function feed($user)
    {
        return $user->activity()->latest()->with('subject')->get()->groupBy(function ($activity) {
            return $activity->created_at->format('y-m-d');
        });
    }
}
