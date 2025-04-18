<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardController extends Controller
{
    public function store(Request $request) // This method handles the storing of a new card
        {
            $request->validate([
                'column_id' => 'required|exists:columns,id',
                'content' => 'required|string|max:500'
            ]);

            \App\Models\Card::create($request->only('column_id', 'content')); // Create a new card using the validated data

            return back();
        }

}
