<?php

namespace App;

use App\Channel;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug'
    ];

    /**
     * Get all the threads that belong to a channel
     */
    public function thread()
    {
        return $this->hasMany(Channel::class);
    }
}
