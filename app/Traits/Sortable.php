<?php

namespace App\Traits;

use App\Sort\ModelSorter;

trait Sortable
{
    /**
     * Returns ModelSorter class to be instantiated.
     *
     * @param null|string $sorter
     * @return string
     */
    public function provideSorter($sorter = null)
    {
        if ($sorter === null) {
            $sorter = 'App\\ModelSorters\\' . class_basename($this) . 'Sorter';
        }

        return $sorter;
    }

    /**
     * Creates local scope to run the sorter.
     *
     * @param $query
     * @param array $input
     * @param null|string|ModelSorter $sorter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSort($query, array $input = [])
    {
        $sorter = $this->getModelSorterClass();

        // Create the model sorter instance
        $modelSorter = new $sorter($query, $input);

        // Return the sorter query
        return $modelSorter->handle();
    }

    /**
     * Returns the ModelSorter for the current model.
     *
     * @return string
     */
    public function getModelSorterClass()
    {
        return method_exists($this, 'modelSorter') ? $this->modelSorter() : $this->provideSorter();
    }
}
