<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RetrosColumnsController extends Controller
{
    /**
     * function to create a new column
     * @param Request $request
     * Retro_id is required
     * Name is required
     */

     public function createColumn(Request $request)
     {
         $request->validate([
             'retro_id' => 'required|integer',
             'name' => 'required|string|max:255',
         ]);

         $request = RetrosColumns::create([
             'retro_id' => $request->input('retro_id'),
             'name' => $request->input('name'),
         ]);


         return response()->json(['message' => 'Column created successfully'], 201);
     }
}
