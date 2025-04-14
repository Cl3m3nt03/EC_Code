<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RetrosDataController extends Controller
{
    /**
     * function to create a new card
     * @param Request $request
     * Column_id is required
     * 
     */

     public function createCard(Request $request){
        $request->validate([
            'column_id' => 'required|integer',
            'content' => 'required|string|max:255',
        ]);
    
        $card = RetrosData::create([
            'column_id' => $request->input('column_id'),
            'name' => $request->input('content'), 
            'description' => '',
        ]);
    
        return response()->json(['message' => 'Card created successfully', 'card' => $card], 201);
    }
}
