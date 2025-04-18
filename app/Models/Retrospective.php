<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Retrospective extends Model
{
    protected $fillable = ['title', 'cohort_id'];

    /**
     * Defines a one-to-many relationship.
     * Each Retrospective can have many RetroColumns.
     */
    public function columns(): HasMany
    {
        return $this->hasMany(RetroColumn::class);
    }

    /**
     * Defines an inverse one-to-many relationship.
     * Each Retrospective belongs to a single Cohort.
     */
    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }
}
