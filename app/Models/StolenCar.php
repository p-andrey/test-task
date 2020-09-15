<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model as Eloquent;

class StolenCar extends Eloquent
{
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'registration_number', 'color', 'vin', 'year'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function make()
    {
        return $this->belongsTo(Make::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function model()
    {
        return $this->belongsTo(Model::class);
    }
}
