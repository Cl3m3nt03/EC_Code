<?php

namespace App\Http\Controllers;
use App\Models\RetrosData;
use App\Models\RetrosColumns;
use App\Events\RetrosDataCreate;

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
         ]);

         $retrosData = RetrosData::create([
             'column_id' => $validated['column_id'],
             'name' => $validated['name'],
         ]);
     
         $retro_id = $retrosData->column->retro_id;
         
         broadcast(new RetrosDataCreate( $retrosData , $retro_id));

     
         return response()->json([
             'message' => 'Carte créée avec succès',
             'data' => $retrosData
         ]);
     }
}
