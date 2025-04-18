<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class RetroCard extends Model
{
    protected $fillable = ['content', 'retro_column_id'];

    /**
     * Defines an inverse one-to-many relationship.
     * Each RetroCard belongs to one RetroColumn.
     */
    public function column(): BelongsTo
    {
        return $this->belongsTo(RetroColumn::class, 'retro_column_id');
    }

    /**
     * Moves the card to another column.
     * This logic does not typically belong in a model and should be in a controller or service instead.
     *
     * @param Request $request
     * @param int $cardId
     * @return \Illuminate\Http\JsonResponse
     */
    public function move(Request $request, $cardId)
    {
        $request->validate([
            'column_id' => 'required|exists:retro_columns,id',
        ]);

        $card = \App\Models\RetroCard::findOrFail($cardId);
        $card->retro_column_id = $request->input('column_id');
        $card->save();

        return response()->json(['message' => 'Card moved successfully']);
    }
}
