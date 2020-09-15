<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class StolenCarFilter extends ModelFilter
{
    /**
     * @param $id
     */
    public function makeId($id)
    {
        $this->where('make_id', $id);
    }

    /**
     * @param $name
     */
    public function makeName($name)
    {
        $this->related('make', 'name', 'LIKE', "%{$name}%");
    }

    /**
     * @param $id
     */
    public function modelId($id)
    {
        $this->where('model_id', $id);
    }

    /**
     * @param $name
     */
    public function modelName($name)
    {
        $this->related('model', 'name', 'LIKE', "%{$name}%");
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
