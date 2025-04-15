<?php

namespace App\Http\Controllers;

use App\Models\RetroCard;
use App\Models\RetroColumn;
use Illuminate\Http\Request;

class RetroCardController extends Controller
{
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

        return response()->json(['success' => true]);
    }

}
