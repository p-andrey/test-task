<?php

namespace App\Sort;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class ModelSorter
{
    const SORT_ORDER_PARAMETER = 'sort';
    const SORT_FIELD_PARAMETER = 'sort_field';

    /**
     * Array of input to sorting.
     *
     * @var array
     */
    protected $input;

    /**
     * @var QueryBuilder
     */
    protected $query;

    /**
     * ModelSorter constructor.
     *
     * @param $query
     * @param array $input
     */
    public function __construct($query, array $input = [])
    {
        $this->input = $input;
        $this->query = $query;
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        $resp = call_user_func_array([$this->query, $method], $args);

        // Only return $this if query builder is returned
        // We don't want to make actions to the builder unreachable
        return $resp instanceof QueryBuilder ? $this : $resp;
    }

    /**
     * Handle all sort.
     *
     * @return QueryBuilder
     */
    public function handle()
    {
        // Run input sorters
        $this->sortInput($this->input);

        return $this->query;
    }

    /**
     * @param array $input
     */
    public function sortInput(array $input)
    {
        $sortableFieldName = Str::camel(Arr::get($input, static::SORT_FIELD_PARAMETER));
        $sortableOrder = Arr::get($input, static::SORT_ORDER_PARAMETER);
        if (!in_array(mb_strtolower($sortableOrder), ['asc', 'desc'])) {
            $sortableOrder = 'asc';
        }

        if ($sortableFieldName && method_exists($this, $sortableFieldName)) {
            $this->{$sortableFieldName}($sortableOrder);
        }
    }
}
