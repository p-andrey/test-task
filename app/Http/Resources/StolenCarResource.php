<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class StolenCar
 * @package App\Http\Resources
 * @mixin \App\Models\StolenCar
 */
class StolenCarResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'registration_number' => $this->registration_number,
            'color' => $this->color,
            'vin' => $this->vin,
            'year' => $this->year,
            'make' => $this->make->name,
            'model' => $this->model->name,
        ];
    }
}
