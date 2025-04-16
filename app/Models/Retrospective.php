<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Retrospective extends Model
{
    protected $fillable = ['title', 'cohort_id'];

    public function columns(): HasMany
    {
        return $this->hasMany(RetroColumn::class);
    }

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }
}
