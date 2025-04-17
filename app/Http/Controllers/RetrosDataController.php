<?php

namespace App\Http\Controllers;
use App\Models\RetrosData;
use App\Models\RetrosColumns;
use App\Events\RetrosDataCreate;
use App\Events\RetrosDataUpdate;
use App\Events\RetrosDataDelete;

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

     /**
      * function to update a card
      * @param Request $request
      */

        public function update(Request $request, RetrosData $retrosData)
        {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'column_id' => 'sometimes|exists:retros_columns,id',
            ]);

            $retrosData->update($validated);

            $retro_id = $retrosData->column->retro_id;

            broadcast(new RetrosDataUpdate( $retrosData , $retro_id));

            return response()->json([
                'message' => 'Carte mise à jour avec succès',
                'data' => $retrosData
            ]);
        }

        /**
         * function to delete a card
         * @param RetrosData $retrosData
         */

        public function deleteCard(RetrosData $retrosData)
        {
            $retro_id = $retrosData->column->retro_id;

            $retrosData->delete();

            broadcast(new RetrosDataDelete( $retrosData , $retro_id));

            return response()->json([
                'message' => 'Carte supprimée avec succès',
            ]);
        }
}
