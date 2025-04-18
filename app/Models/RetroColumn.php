<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RetroColumn extends Model
{
    protected $fillable = ['title', 'retrospective_id', 'position'];

    /**
     * Defines an inverse one-to-many relationship.
     * Each RetroColumn belongs to a single Retrospective.
     */
    public function retrospective(): BelongsTo
    {
        return $this->belongsTo(Retrospective::class);
    }

    /**
     * Defines a one-to-many relationship.
     * Each RetroColumn can have many RetroCards.
     */
    public function cards(): HasMany
    {
        return $this->hasMany(RetroCard::class);
    }
}
