<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Make extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function models()
    {
        return $this->hasMany(Model::class);
    }
}
