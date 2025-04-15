<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardController extends Controller
{
    public function store(Request $request)
        {
            $request->validate([
                'column_id' => 'required|exists:columns,id',
                'content' => 'required|string|max:500'
            ]);

            \App\Models\Card::create($request->only('column_id', 'content'));

            return back();
        }

}
