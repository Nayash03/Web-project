<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RetroColumn extends Model
{
    protected $fillable = ['title', 'retrospective_id', 'position'];

    public function retrospective(): BelongsTo
    {
        return $this->belongsTo(Retrospective::class);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(RetroCard::class);
    }
}
