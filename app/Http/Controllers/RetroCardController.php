<?php

namespace App\Http\Controllers;

use App\Models\RetroCard;
use App\Models\RetroColumn;
use Illuminate\Http\Request;

class RetroCardController extends Controller
{
    /**
     * Store a newly created card in the specified retro column.
     *
     * @param Request $request
     * @param int $retroId
     * @param int $columnId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $retroId, $columnId)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        \App\Models\RetroCard::create([
            'content' => $request->input('content'),
            'retro_column_id' => $columnId
        ]);

        return redirect()->back();
    }

    public function move(Request $request, $cardId)
    {
        $request->validate([
            'column_id' => 'required|exists:retro_columns,id',
        ]);

        $card = \App\Models\RetroCard::findOrFail($cardId);
        $card->retro_column_id = $request->input('column_id');
        $card->save();

        return response()->json([
            'success' => true,
            'moved_to_column' => $card->retro_column_id,
            'card_id' => $card->id,
        ]);
    }

    /**
     * Move a card to a different column.
     *
     * @param Request $request
     * @param int $cardId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, RetroCard $card)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        
        $card->content = $request->input('content');
        $card->save();

        return response()->json(['content' => $card->content]);
    }

}
