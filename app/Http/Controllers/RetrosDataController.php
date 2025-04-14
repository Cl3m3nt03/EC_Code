<?php

namespace App\Http\Controllers;
use App\Models\RetrosData;
use App\Models\RetrosColumns;

use Illuminate\Http\Request;

class RetrosDataController extends Controller
{
    /**
     * function to create a new card
     * @param Request $request
     * Column_id is required
     * 
     */

     public function store(Request $request)
     {
         $validated = $request->validate([
             'column_id' => 'required|exists:retros_columns,id',
             'name' => 'required|string|max:255',
             'description' => 'required|string|max:255',
         ]);
     
         RetrosData::create([
             'column_id' => $validated['column_id'],
             'name' => $validated['name'],
             'description' => $validated['description'],
         ]);
     
         return redirect()->back()->with('success', 'Tâche créée avec succès.');
     }
}
