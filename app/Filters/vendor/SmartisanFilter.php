<?php

namespace App\Filters\vendor;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class SmartisanFilter
{
    /**
     * Eloquent builder.
     *
     * @var Builder
     */
    protected $builder;

    /**
     * Http request.
     *
     * @var Request
     */
    protected $request;

    /**
     * Filter constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the filters on the query.
     *
     * @param $builder
     * @return Builder
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            $this->$filter($value);
        }

        return $this->builder;
    }

    /**
     * Fetch all relevant filters from the request.
     *
     * @throws FiltersNotDefinedException
     * @return array
     */
    protected function getFilters()
    {
        $filters = array_diff(get_class_methods($this), ['__construct', 'apply', 'getFilters']);

        return array_filter($this->request->only($filters), function ($value) {
            return !empty($value);
        });
    }
}
