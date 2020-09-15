<?php

namespace App\ModelSorters;

use App\Sort\ModelSorter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class StolenCarSorter
 * @package App\ModelSorters
 * @mixin Builder
 */
class StolenCarSorter extends ModelSorter
{
    /**
     * @param  string  $sortOrder
     */
    public function id(string $sortOrder)
    {
        $this->orderBy($this->getModel()->getTable() . '.id', $sortOrder);
    }

    /**
     * @param  string  $sortOrder
     */
    public function name(string $sortOrder)
    {
        $this->orderBy($this->getModel()->getTable() . '.name', $sortOrder);
    }
    /**
     * @param  string  $sortOrder
     */
    public function registrationNumber(string $sortOrder)
    {
        $this->orderBy('registration_number', $sortOrder);
    }

    /**
     * @param  string  $sortOrder
     */
    public function color(string $sortOrder)
    {
        $this->orderBy('color', $sortOrder);
    }

    /**
     * @param  string  $sortOrder
     */
    public function vin(string $sortOrder)
    {
        $this->orderBy('vin', $sortOrder);
    }

    /**
     * @param  string  $sortOrder
     */
    public function year(string $sortOrder)
    {
        $this->orderBy('year', $sortOrder);
    }

    /**
     * @param  string  $sortOrder
     */
    public function make(string $sortOrder)
    {
        $this->select($this->getModel()->getTable() . '.*')
            ->join('makes', 'makes.id', 'stolen_cars.make_id')
            ->orderBy('makes.name', $sortOrder);
    }

    /**
     * @param  string  $sortOrder
     */
    public function model(string $sortOrder)
    {
        $this->select($this->getModel()->getTable() . '.*')
            ->join('models', 'models.id', 'stolen_cars.model_id')
            ->orderBy('models.name', $sortOrder);
    }
}
