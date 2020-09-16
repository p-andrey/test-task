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
    protected $fillable = ['name', 'remote_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function models()
    {
        return $this->hasMany(Model::class);
    }
}
