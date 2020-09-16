<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class StolenCarFilter extends ModelFilter
{
    /**
     * @param $sentence
     */
    public function search($sentence)
    {
        $this->where(function ($query) use ($sentence) {
            $query->where($query->getModel()->getTable() . '.name', 'LIKE', "%{$sentence}%")
                ->orWhere('registration_number', $sentence)
                ->orWhere('vin', $sentence);
        });
    }

    /**
     * @param $id
     */
    public function makeId($id)
    {
        $this->where($this->getModel()->getTable() . '.make_id', $id);
    }

    /**
     * @param $name
     */
    public function makeName($name)
    {
        $this->related('make', 'makes.name', 'LIKE', "%{$name}%");
    }

    /**
     * @param $id
     */
    public function modelId($id)
    {
        $this->where($this->getModel()->getTable() . '.model_id', $id);
    }

    /**
     * @param $name
     */
    public function modelName($name)
    {
        $this->related('model', 'models.name', 'LIKE', "%{$name}%");
    }

    /**
     * @param $year
     */
    public function year($year)
    {
        $this->where('year', $year);
    }

    /**
     * @param $color
     */
    public function color($color)
    {
        $this->where('color', $color);
    }
}
