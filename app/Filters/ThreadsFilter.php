<?php


namespace App\Filters;


use App\User;

/**
 * Class ThreadsFilter
 * @package App\Filters
 */
class ThreadsFilter extends Filters
{
    /**
     * All the filters available to filter through
     *
     * @var array
     */
    protected $filters = ['by', 'popular'];

    /**
     * Filter the query by a given username
     *
     * @param $username
     * @return mixed
     */
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query by popularity
     *
     * @return mixed
     */
    public function popular()
    {
        $this->builder->getQuery()->orders = [];

        $this->builder->orderBy('replies_count', 'desc');
    }
}
