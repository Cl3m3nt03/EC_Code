<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\RetrosColumnCreated; 

class RetrosColumnsController extends Controller
{
    /**
     * function to create a new column
     * @param Request $request
     * Retro_id is required
     * Name is required
     */ 

     public function store(Request $request, \App\Models\Retro $retro)
     {
         $validated = $request->validate([
             'name' => 'required|string|max:255',
         ]);
         
     
         $column = $retro->columns()->create([
             'name' => $validated['name'],
         ]);

         $retro = $column->retro_id;
     
         broadcast(new RetrosColumnCreated($column , $retro));
     
         return response()->json([
             'message' => 'Column created successfully',
             'column' => $column,
         ]);
     }
    
}
