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

    public function move(Request $request, $cardId)
    {
        $request->validate([
            'column_id' => 'required|exists:retro_columns,id',
        ]);

        $card = \App\Models\RetroCard::findOrFail($cardId);
        $card->retro_column_id = $request->input('column_id');
        $card->save();

        return response()->json(['message' => 'Carte déplacée avec succès']);
    }

}
