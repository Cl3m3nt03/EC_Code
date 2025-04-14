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
    public function store(Request $request, \App\Models\Retro $retro)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $retro->columns()->create([
            'name' => $validated['name'],
        ]);
    
        return redirect()->back()->with('success', 'Colonne créée avec succès.');
    }
}
