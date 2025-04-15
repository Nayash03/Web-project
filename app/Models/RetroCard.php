<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RetroCard extends Model
{
    protected $fillable = ['content', 'retro_column_id'];

    public function column(): BelongsTo
    {
        return $this->belongsTo(RetroColumn::class, 'retro_column_id');
    }
}
