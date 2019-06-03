<?php


namespace App\Filters;


use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * @var Request
     */
    protected $request;
    protected $builder;

    protected $filters = [];

    /**
     * ThreadsFilter constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply filters to the builder
     *
     * @param $builder
     * @return mixed|void
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * @return array
     */
    private function getFilters(): array
    {
        $filters = array_intersect(array_keys($this->request->all()), $this->filters);
        return $this->request->only($filters);
    }
}
