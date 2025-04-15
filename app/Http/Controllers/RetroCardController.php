<?php

namespace App\Http\Controllers;

use App\Models\RetroCard;
use App\Models\RetroColumn;
use Illuminate\Http\Request;

class RetroCardController extends Controller
{
    public function store(Request $request, $retroId, RetroColumn $column)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $card = new RetroCard();
        $card->content = $request->content;
        $card->retro_column_id = $column->id;
        $card->save();

        return redirect()->back();
    }
}
